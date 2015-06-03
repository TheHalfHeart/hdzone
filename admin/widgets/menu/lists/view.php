<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chính</a> ::
    <a href="admin.php#menu/lists">Menu</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh sách menu</h1>
        <div class="buttons">
            <a class="button" href="admin.php#" onclick="return jsAdmin.redirect('menu/add?position=<?php echo $filter['menu_position']; ?>');" >Thêm mới</a>
        </div>
    </div>
    <div class="content">
        <div style="margin: 10px 40px; ">
            Chọn menu: 
            <select id="menu_position">
                <?php foreach ($position as $key => $item){ ?>
                <option <?php echo (isset($filter['menu_position']) && $filter['menu_position'] == $key) ? ' selected="selected" ' : ''; ?> value="<?php echo $key; ?>"><?php echo $item; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="menu-editor">
            <?php echo $this->menu->admin_show_list($menus); ?>
            <?php echo $this->menu->to_js_list($menus); ?>
        </div>
    </div>
    <?php $this->security->set_action('menu_update'); ?>
    <?php $this->security->set_action('menu_delete'); ?>
    <script language="javascript">
        $(document).ready(function()
        {
            // Lang
            jsAdmin.loadLang();
        
            var str = '';
            
            jsAdmin.urlBack.level1 = 'menu/lists?position=<?php echo $filter['menu_position']; ?>';
            
            jsAdmin.changeTitle('Danh Sách Menu');
            
            // Menu
            jsAdmin.changeMenu('menu/lists');
            
            function getMenuInside(id)
            {
                var menu_de_quy = new Array();
                for (var i = 0; i < menus.length; i++)
                {
                    if (menus[i].menu_id != id && menus[i].menu_ref_parent_id != id){
                        menu_de_quy.push(menus[i]);
                    }
                }
                return menu_de_quy;
            }

            function showMenuInsideLi(menuList, parent_id, dem, current_parent_id)
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
                    for (var i = 0; i < arrayForeach.length; i++)
                    {
                        str += '<option value="'+arrayForeach[i].menu_id+'"';
                        if (current_parent_id == arrayForeach[i].menu_id){
                            str += ' selected="selected" style="background:gray;color:white"';
                        }
                        str += '>';
                        for (var j = 0; j <= dem; j++){
                            str += '|---';
                        }
                        str += arrayForeach[i].<?php echo lang_default_field('menu_title'); ?>;
                        str += '</option>';
                        showMenuInsideLi(menuContinue, arrayForeach[i].menu_id, dem+1, current_parent_id);
                    }
                } 
            }

            $('.menu-editor a').click(function()
            {
                if ($(this).next('div').hasClass('menuexpand'))
                {
                    $(this).next('div').removeClass('menuexpand').addClass('menuunexpand');
                }
                else{
                    var id = $(this).attr('idval');
                    if (id)
                    {
                        str = '<option value="0">NONE</option>';
                        var menuAp = getMenuInside(id);
                        showMenuInsideLi(menuAp,0,0,$(this).attr('parentid'));
                        $('#menu_ref_parent_id_'+id).html(str);
                    }
                    $(this).next('div').removeClass('menuunexpand').addClass('menuexpand');
                }
                return false;
            });

            $('.btn-save-menu').click(function()
            {
                var id = $(this).attr('idval');
                var data = {
                    menu_id     : id,
                    menu_class  : $('#menu_class_'+id).val(),
                    menu_sort   : $('#menu_sort_'+id).val(),
                    menu_ref_parent_id : $('#menu_ref_parent_id_'+id).val(),
                    menu_target : $('#menu_target_'+id).val(),
                    menu_update : $('#menu_update').val()
                };
                
                i18n_val_text(data, 'menu_title', 'menu_title_'+id);
                i18n_val_text(data, 'menu_link','menu_link_'+id);
                
                if (isEmpty(data.menu_id)){
                    jAlert('Lỗi mã hệ thống, vui lòng liên hệ TheHalfheart@gmail.com', 'Lỗi hệ thống');
                }
                else if (i18n_is_empty('menu_title_'+id)){
                    jAlert('Bạn chưa nhập tên menu đầy đủ các ngôn ngữ', 'Lỗi dữ liệu');
                }
                else{
                    jsAdmin.sendAjax('post', 'text', data, 'menu/update', function(result){
                        result = trim(result);
                        if (result == '100'){
                            filter();
                        }
                        else if (result == '101'){
                            jAlert('Lỗi request', 'Lỗi');
                        }
                        else{
                            jAlert('Lỗi dữ liệu', 'Lỗi');
                        }
                    });
                }
                return false;
            });
            
            $('.btn-delete-menu').click(function()
            {
                var obj = this;
                jConfirm("Bạn có thực sự muốn xóa menu này?", "Xác nhận", function (r)
                {
                    if (r)
                    {
                        var id = $(obj).attr('idval');
                        if (!isEmpty(id))
                        {
                            var data = {
                                menu_id     : id, 
                                menu_delete : $('#menu_delete').val()
                            };

                            jsAdmin.sendAjax('post', 'text', data, 'menu/delete', function(result)
                            {    
                                result = trim(result);
                                if (result == '100'){
                                    filter();
                                }
                                else{
                                    jAlert('Lỗi request', 'Lỗi');
                                }
                            });
                        }
                    }
                });
                return false;
            });
            
            $('#menu_position').change(function(){
                filter();
            });
            
            function filter()
            {
                    var data = {
                            position   : $('#menu_position').val()
                    };
                    jsAdmin.event.filter(data, 'menu/lists');
            }
        
        });
        
    </script>
</div>