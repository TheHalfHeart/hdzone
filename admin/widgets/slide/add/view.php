<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#slide/lists">Slide</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Slide Mới</h1>
        <div class="buttons">
            <a class="button" id="click-save">Bước Kế Tiếp</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit="return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tiêu đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="slide_title" name="slide_title" value="<?php _lang_val($filter, 'slide_title'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'slide_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Link<span class="required">(*)</span></strong>
                                <span class="help">Tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="slide_link" name="slide_link" value="<?php _lang_val($filter, 'slide_link'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'slide_link'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Vị Trí</strong>
                                <span class="help">Vị trí hiển thị slide</span>
                            </td>
                            <td>
                                <select id="slide_position" style="width: 200px;">
                                    <?php foreach (slide_position() as $key => $value){ ?>
                                    <option <?php echo _selected($filter, 'slide_position', $key) ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <?php showError($errors, 'slide_position'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giới Thiệu</strong>
                                <span class="help">Mô tả slide</span>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="short" id="slide_content" name="slide_content" value="<?php _lang_val($filter, 'slide_content'); ?>"></div>
                                <?php showErrorLang($errors, 'slide_content'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('slide_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
       // Lang
       jsAdmin.loadLang();
        
        // Title Page
        jsAdmin.changeTitle('Thêm Tin Slide Mới');
        
        // Menu
        jsAdmin.changeMenu('slide/lists');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'slide/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = {
                slide_position       : trim($('#slide_position').val()),
                slide_add            : $('#slide_add').val()
            };
            
            // Validate data
            if (i18n_is_empty('slide_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (i18n_is_empty('slide_link')){
                jAlert('Bạn chưa nhập link slide đầy đủ', 'Lỗi link slide');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'slide_title');
            i18n_val_text(data, 'slide_link');
            i18n_val_ckeditor(data, 'slide_content');
            
            // Send Ajax
            jsAdmin.sendAjax('post', 'text', data, 'slide/add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('slide/edit?slide_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

