<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Sản Phẩm Mới</h1>
        <div class="buttons">
            <a class="button" id="click-save">Bước Tiếp Theo</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="post_slug" to-title="post_title" id="post_title" name="post_title" value="<?php _lang_val($filter, 'post_title'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'post_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="post_slug" to-title="post_title" id="post_slug" name="post_slug" value="<?php _lang_val($filter, 'post_slug'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'post_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giới Thiệu Ngắn</strong>
                                <span class="help">Giới thiệu ngắn sơ lược về tin, tối đa 1000 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="textarea" id="post_summary" name="post_summary" value="<?php _lang_val($filter, 'post_summary'); ?>" maxlength="1000" cols="100" rows="5"></div>
                                <?php showErrorLang($errors, 'post_summary'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('post_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Thêm Sản Phẩm Mới');

        // Lang
        jsAdmin.loadLang();
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Menu
        jsAdmin.changeMenu('product/post_lists');
        
        // Related And Tags
        jsNews.init();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/post_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        // save
        $('#click-save').click(function()
        {
            var data = 
            {
                post_add            : $('#post_add').val()
            };
             
            // Validate data
            if (i18n_is_empty('post_title')){
                jAlert('Bạn chưa nhập tiêu đề ngắn đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('post_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không in hoa, không dấu ở các ngôn ngữ', 'Lỗi slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'post_title');
            i18n_val_text(data, 'post_slug');
            i18n_val_text(data, 'post_summary');
            
            jsAdmin.sendAjax('post', 'text', data, 'product/post_add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('product/post_edit?post_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

