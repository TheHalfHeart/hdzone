<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/manu_lists">Nhà Sản Xuất</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Nhà Sản Xuất</h1>
        <div class="buttons">
            <a class="button" id="click-save">Bước kế tiếp</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-seo">SEO</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tên Nhà Sản Xuất<span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách phim theo chuyên mục)</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="manu_slug" to-title="manu_title_short" id="manu_title_short" name="manu_title_short" value="<?php _lang_val($filter, 'manu_title_short'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_title_short'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug (URL) <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="manu_slug" to-title="manu_title_short" id="manu_slug" name="manu_slug" value="<?php _lang_val($filter, 'manu_slug'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô Tả Nhà Sản Xuất <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Tiêu đề dài hiển thị chi tiết nhằm giúp tối ưu SEO</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_title" name="manu_title" value="<?php _lang_val($filter, 'manu_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Sắp Xếp</strong>
                                <span class="help">Thứ tự hiển thị chuyên mục</span>
                            </td>
                            <td>
                                <input type="text" onkeypress="return onlyNumbers(event)" id="manu_sort" value="<?php _val($filter, 'manu_sort', '0'); ?>" size="4" maxlength="4"/>
                                <?php showError($errors, 'manu_sort'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-seo">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Seo Title</strong>
                                <span class="help">Tiêu đề hiển thị phía trên cùng của website, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_seo_title" name="manu_seo_title" value="<?php _lang_val($filter, 'manu_seo_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_seo_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Keywords</strong>
                                <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_seo_keywords" name="manu_seo_keywords" value="<?php _lang_val($filter, 'manu_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_seo_keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Description</strong>
                                <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_seo_description" name="manu_seo_description" value="<?php _lang_val($filter, 'manu_seo_description'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_seo_description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Robots</strong>
                                <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'manu_seo_robots'); ?>" id="manu_seo_robots" size="100" maxlength="255"/>
                                <?php showError($errors, 'manu_seo_robots'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Last Visit</strong>
                                <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'manu_seo_last_visit'); ?>" id="manu_seo_last_visit" size="100" maxlength="255"/>
                                <?php showError($errors, 'manu_seo_last_visit'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Main Keyword</strong>
                                <span class="help">Từ khóa chính của bài</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_seo_main_keyword" name="manu_seo_main_keyword" value="<?php _lang_val($filter, 'manu_seo_main_keyword'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_seo_main_keyword'); ?>
                                <div id="seo-test"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('manu_add'); ?>
        </form>
    </div>
</div>

<script language="javscript" type="text/javascript">
    
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Thêm Nhà Sản Xuất Phim Mới');
        
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('product/manu_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/manu_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                manu_sort           : trim($('#manu_sort').val()),
                manu_type           : trim($('#manu_type').val()),
                manu_icon           : trim($('#image_server').val()),
                manu_seo_robots     : trim($('#manu_seo_robots').val()),
                manu_seo_last_visit : trim($('#manu_seo_last_visit').val()),
                manu_add            : $('#manu_add').val()
            };
            
            // Validate data
            if (i18n_is_empty('manu_title_short')){
                jAlert('Bạn chưa nhập tiêu đề ngắn đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (i18n_is_empty('manu_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('manu_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không in hoa, không dấu ở các ngôn ngữ', 'Lỗi slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'manu_title');
            i18n_val_text(data, 'manu_title_short');
            i18n_val_text(data, 'manu_slug');
            i18n_val_text(data, 'manu_seo_title');
            i18n_val_text(data, 'manu_seo_keywords');
            i18n_val_text(data, 'manu_seo_description');
            i18n_val_text(data, 'manu_seo_main_keyword');
            
            jsAdmin.sendAjax('post', 'text', data, 'product/manu_add', function (result)
            {
                result = trim(result);
                if (result == '0'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (result.length > 100){
                    jsAdmin.render(result);
                }
                else{
                    jsAdmin.redirect('product/manu_edit?manu_id='+result);
                }
            });
            return false;
        });
    });    
</script>