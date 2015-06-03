<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#page/lists">Trang Web</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Trang Web Mới</h1>
        <div id="wrapperInputLang"></div>
        <div class="buttons">
            <a class="button" id="click-save">Bước Tiếp Theo</a>
            <a class="button" id="click-back">Trở Lại</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general" class="selected">Thông Tin</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general" style="display: block;">
                <table class="form">
                    <tbody >
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="page_slug" to-title="page_title" id="page_title" name="page_title" value="<?php _lang_val($filter, 'page_title'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'page_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="page_slug" to-title="page_title" id="page_slug" name="page_slug" value="<?php _lang_val($filter, 'page_slug'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'page_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Template</strong>
                                <span class="help">Chọn template cho trang web</span>
                            </td>
                            <td>
                                <select id="page_template" style="width: 200px;">
                                    <?php foreach (page_list_template() as $key => $value){ ?>
                                    <option <?php echo _selected($filter, 'page_template', $key) ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <?php showError($errors, 'page_template'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giới Thiệu Ngắn</strong>
                                <span class="help">Nội dung giới thiệu ngắn, tối đa 1000 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="textarea" toolbar="short" id="page_summary" name="page_summary" value="<?php _lang_val($filter, 'page_summary'); ?>" cols="100" rows="3"></div>
                                <?php showErrorLang($errors, 'page_summary'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('page_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Lang
        jsAdmin.loadLang();
       
        // Menu
        jsAdmin.changeMenu('page/add');
        
        // Title Page
        jsAdmin.changeTitle('Thêm Trang Web Mới');
    
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Back
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'page/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                page_template       : trim($('#page_template').val()),
                page_add            : $('#page_add').val()
            };
            
            // Validate data
            if (i18n_is_empty('page_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('page_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không dấu', 'Lỗi link slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'page_title');
            i18n_val_text(data, 'page_slug');
            i18n_val_text(data, 'page_summary');
            
            jsAdmin.sendAjax('post', 'text', data, 'page/add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('page/edit?page_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
                
            });
            return false;
        });
    });    
</script>
