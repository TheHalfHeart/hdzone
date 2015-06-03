<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#menu/lists">Menu</a> 
    <a href="admin.php#menu/lists?position=<?php echo $filter['menu_position']; ?>"><?php echo $this->menu->get_position_name($filter['menu_position']); ?></a>
</div>
<div class="box">
    <div class="heading">
        <h1>
            <img alt="" src="public/admin/image/category.png">
            Thêm Menu Mới
        </h1>
        <div class="buttons">
            <a class="button" id="click-save">Save</a>
            <a class="button" id="click-back">Back</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-link" id="btn-tab-link">Link</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-link" style="display: block;">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tiêu đề <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="menu_title" name="menu_title" value="<?php _lang_val($filter, 'menu_title'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'menu_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Link <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="menu_link" name="menu_link" value="<?php _lang_val($filter, 'menu_link'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'menu_link'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Class</strong>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'menu_class'); ?>" id="menu_class" size="100"/>
                                <?php showError($errors, 'menu_class'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Parent</strong>
                            </td>
                            <td>
                                <select id="menu_ref_parent_id" style="width: 200px;">
                                    <option value="0">NONE</option>
                                </select>
                                <?php showError($errors, 'menu_ref_parent_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Target</strong>
                            </td>
                            <td>
                                <select id="menu_target">
                                    <option value="1" <?php _selected($filter, 'menu_target', '1'); ?>>Hiện tại</option>
                                    <option value="2" <?php _selected($filter, 'menu_target', '2'); ?>>Tab mới</option>
                                </select>
                                <?php showError($errors, 'menu_target'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Sort</strong>
                            </td>
                            <td>
                                <input type="text" onkeypress="return onlyNumbers(event);" value="<?php _val($filter, 'menu_sort', '0'); ?>" id="menu_sort" size="4"/>
                                <?php showError($errors, 'menu_sort'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('menu_add'); ?>
        </form>
    </div>
</div>
<?php echo $this->menu->to_js_list($menus); ?>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Lang
        jsAdmin.loadLang();
       
        var str = '';
        
        // Menu
        jsAdmin.changeMenu('menu/lists');
        
        jsAdmin.changeTitle('Thêm Menu Mới');
        
        function showParent(menuList, parent_id, dem)
        {
            var arrayForeach = new Array();
            var menuContinue = new Array();

            for(var i = 0; i < menuList.length; i++){
                if (menuList[i].menu_ref_parent_id == parent_id){
                    arrayForeach.push(menuList[i]);
                }
                else{
                    menuContinue.push(menuList[i]);
                }
            }

            if (arrayForeach.length > 0)
            {
                for (i = 0; i < arrayForeach.length; i++)
                {
                    str += '<option value="'+arrayForeach[i].menu_id+'">';
                    for (var j = 0; j <= dem; j++){
                        str += '|---';
                    }
                    str += arrayForeach[i].<?php echo lang_default_field('menu_title'); ?>;
                    str += '</option>';
                    showParent(menuContinue, arrayForeach[i].menu_id, dem+1);
                }
            } 
        }
        
        showParent(menus, 0, 0);
        
        $('#menu_ref_parent_id').append(str);
        
        $('#tabs a').tabs();

        $('#click-back').click(function() {
            var hash_back = jsAdmin.urlBack.level1;
            if (!hash_back) {
                hash_back = 'menu/lists?position=<?php echo $filter['menu_position']; ?>';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = {
                menu_position   : <?php echo $filter['menu_position']; ?>,
                menu_class      : $('#menu_class').val(),
                menu_ref_parent_id  : $('#menu_ref_parent_id').val(),
                menu_target     : $('#menu_target').val(),
                menu_sort       : $('#menu_sort').val(),
                menu_add        : $('#menu_add').val()
            };
            
            // Validate data
            if (i18n_is_empty('menu_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'menu_title');
            i18n_val_text(data, 'menu_link');
            
            jsAdmin.sendAjax('post', 'text', data, 'menu/add?position=<?php echo $filter['menu_position']; ?>', function(result)
            {
                result = trim(result);
                if (result == '100'){
                    jConfirm('Thêm thành công, bạn có muốn thêm tiếp?', 'Thành công', function (r){
                        if (r){
                            jsAdmin.redirect('menu/add?position=<?php echo $filter['menu_position']; ?>');
                        }
                        else{
                            $('#click-back').click();
                        }
                    });
                }
                else{
                    jsAdmin.render(result);
                }
            });
            
            return false;
        });
    });
    
</script>

