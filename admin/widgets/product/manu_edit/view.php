<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/manu_lists">Nhà Sản Xuất</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Nhà Sản Xuất</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-advanced">Nâng Cao</a>
            <a href="#tab-seo">SEO</a>
            <a href="#tab-other">Khác</a>
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
                                <div class="multilang" type="text" id="manu_title" name="manu_title" value="<?php _lang_val($filter, 'manu_title'); ?>"  maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Quốc gia</strong>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="manu_country" name="manu_country" value="<?php _lang_val($filter, 'manu_country'); ?>"  maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'manu_country'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Năm</strong>
                            </td>
                            <td>
                                <input type="text" id="manu_year" value="<?php echo _val($filter, 'manu_year'); ?>" maxlength="255" size="50"/>
                                <?php showErrorLang($errors, 'manu_year'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Icon</strong>
                                <span class="help">Hình Icon của chuyên mục</span>
                            </td>
                            <td>
                                <?php _image_server($filter, 'manu_icon', $ck_img_path); ?>
                            </td>
                        </tr>
                        <tr style="display: none">
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
            <div id="tab-advanced">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Mô tả dài</strong>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['manu_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['manu_add_date_int']).$filter['manu_id']; ?>" ck-module="product_manu" id="manu_description" name="manu_description" value="<?php _lang_val($filter, 'manu_description'); ?>"></div>
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
                                <div class="multilang" type="text" id="manu_seo_main_keyword" name="manu_seo_main_keyword" value="<?php _lang_val($filter, 'manu_seo_main_keyword'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'manu_seo_main_keyword'); ?>
                                <div id="seo-test"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-other">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>ID</strong>
                                </td>
                                <td>
                                    <strong><?php echo $filter['manu_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['manu_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['manu_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['manu_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['manu_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['manu_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                </td>
                                <td>
                                    <a href="#" target="_blank"><?php echo $this->config->base_url($filter['manu_slug_vi']); ?></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('manu_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-product-manu-editting" value="product-manu-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Sửa Nhà Sản Xuất Phim');
    
        // Ckfinder
        jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/product_manu/connector/<?php echo $filter['manu_id']; ?>/Images';
        
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
                manu_year           : trim($('#manu_year').val()),
                manu_icon           : trim($('#image_server').val()),
                manu_id             : <?php echo $filter['manu_id']; ?>,
                manu_seo_robots     : trim($('#manu_seo_robots').val()),
                manu_seo_last_visit : trim($('#manu_seo_last_visit').val()),
                manu_edit            : $('#manu_edit').val()
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
            i18n_val_text(data, 'manu_country');
            i18n_val_ckeditor(data, 'manu_description');
            
            jsAdmin.sendAjax('post', 'text', data, 'product/manu_edit?manu_id=<?php echo $filter['manu_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('product/manu_edit?manu_id=<?php echo $filter['manu_id']; ?>');
                    });
                }
                else if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
        
        // Update Editting
        clearInterval(jsAdmin.editting);
        jsAdmin.editting = setInterval(function()
        {
            if (!isEmpty($('#interval-product-manu-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {manu_id:<?php echo $filter['manu_id']; ?>}, 'product/manu_editting');
            }
            else{
                clearInterval(jsAdmin.editting);
            }
        },10000);
    });    
</script>
<?php } ?>

<?php if (_is_editting($filter)){ ?>
    <script language="javascript">
        $('#content').html('');
        jAlert('Bài viết đang được sửa bởi <?php echo $filter['editting_user_username']; ?>', 'Lỗi phiên làm việc', function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/manu_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

