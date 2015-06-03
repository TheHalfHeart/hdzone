<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/director_lists">Đạo Diễn</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Đạo Diễn</h1>
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
                                <strong>Tên Đạo Diễn<span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách phim theo chuyên mục)</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="director_slug" to-title="director_title_short" id="director_title_short" name="director_title_short" value="<?php _lang_val($filter, 'director_title_short'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_title_short'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug (URL) <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="director_slug" to-title="director_title_short" id="director_slug" name="director_slug" value="<?php _lang_val($filter, 'director_slug'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô Tả Đạo Diễn <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Tiêu đề dài hiển thị chi tiết nhằm giúp tối ưu SEO</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="director_title" name="director_title" value="<?php _lang_val($filter, 'director_title'); ?>"  maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Quốc tịch</strong>
                                <span class="help">Quốc tịch của đạo diễn</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="director_country" name="director_country" value="<?php _lang_val($filter, 'director_country'); ?>"  maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_country'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giới tính</strong>
                                <span class="help">Giới tính của đạo diễn</span>
                            </td>
                            <td>
                                <select id="director_sex">
                                    <option value="1">Nam</option>
                                    <option <?php echo ($filter['director_sex'] == '0') ? 'selected' : ''; ?> value="0">Nữ</option>
                                </select>
                                <?php showErrorLang($errors, 'director_sex'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày sinh</strong>
                                <span class="help">Ngày sinh nhật của đạo diễn</span>
                            </td>
                            <td>
                                <input type="text" id="director_birthday" value="<?php echo _val($filter, 'director_birthday'); ?>" maxlength="255" size="50"/>
                                <?php showErrorLang($errors, 'director_birthday'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Icon</strong>
                                <span class="help">Hình Icon của chuyên mục</span>
                            </td>
                            <td>
                                <?php _image_server($filter, 'director_icon', $ck_img_path); ?>
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td>
                                <strong>Sắp Xếp</strong>
                                <span class="help">Thứ tự hiển thị chuyên mục</span>
                            </td>
                            <td>
                                <input type="text" onkeypress="return onlyNumbers(event)" id="director_sort" value="<?php _val($filter, 'director_sort', '0'); ?>" size="4" maxlength="4"/>
                                <?php showError($errors, 'director_sort'); ?>
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
                                <strong>Tiểu sử</strong>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['director_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['director_add_date_int']).$filter['director_id']; ?>" ck-module="product_director" id="director_history" name="director_history" value="<?php _lang_val($filter, 'director_history'); ?>"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Phần thưởng</strong>
                                <span class="help">Nội dung chi tiết của tin</span>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['director_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['director_add_date_int']).$filter['director_id']; ?>" ck-module="product_director" id="director_award" name="director_award" value="<?php _lang_val($filter, 'director_award'); ?>"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ghi chú</strong>
                                <span class="help">Nội dung chi tiết của tin</span>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['director_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['director_add_date_int']).$filter['director_id']; ?>" ck-module="product_director" id="director_note" name="director_note" value="<?php _lang_val($filter, 'director_note'); ?>"></div>
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
                                <div class="multilang" type="text" id="director_seo_title" name="director_seo_title" value="<?php _lang_val($filter, 'director_seo_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_seo_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Keywords</strong>
                                <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="director_seo_keywords" name="director_seo_keywords" value="<?php _lang_val($filter, 'director_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_seo_keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Description</strong>
                                <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="director_seo_description" name="director_seo_description" value="<?php _lang_val($filter, 'director_seo_description'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'director_seo_description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Robots</strong>
                                <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'director_seo_robots'); ?>" id="director_seo_robots" size="100" maxlength="255"/>
                                <?php showError($errors, 'director_seo_robots'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Last Visit</strong>
                                <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'director_seo_last_visit'); ?>" id="director_seo_last_visit" size="100" maxlength="255"/>
                                <?php showError($errors, 'director_seo_last_visit'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Main Keyword</strong>
                                <span class="help">Từ khóa chính của bài</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="director_seo_main_keyword" name="director_seo_main_keyword" value="<?php _lang_val($filter, 'director_seo_main_keyword'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'director_seo_main_keyword'); ?>
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
                                    <strong><?php echo $filter['director_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['director_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['director_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['director_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['director_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['director_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                </td>
                                <td>
                                    <a href="#" target="_blank"><?php echo $this->config->base_url($filter['director_slug_vi']); ?></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('director_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-product-director-editting" value="product-director-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        $('#director_birthday').datepicker({
                dateFormat: 'dd-mm-yy'
        });
        
        jsAdmin.changeTitle('Sửa Đạo Diễn Phim');
    
        // Ckfinder
        jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/product_director/connector/<?php echo $filter['director_id']; ?>/Images';
        
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('product/director_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/director_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                director_sort           : trim($('#director_sort').val()),
                director_type           : trim($('#director_type').val()),
                director_icon           : trim($('#image_server').val()),
                director_sex            : trim($('#director_sex').val()),
                director_birthday       : trim($('#director_birthday').val()),
                director_id             : <?php echo $filter['director_id']; ?>,
                director_seo_robots     : trim($('#director_seo_robots').val()),
                director_seo_last_visit : trim($('#director_seo_last_visit').val()),
                director_edit            : $('#director_edit').val()
            };
            
            // Validate data
            if (i18n_is_empty('director_title_short')){
                jAlert('Bạn chưa nhập tiêu đề ngắn đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (i18n_is_empty('director_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('director_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không in hoa, không dấu ở các ngôn ngữ', 'Lỗi slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'director_title');
            i18n_val_text(data, 'director_title_short');
            i18n_val_text(data, 'director_slug');
            i18n_val_text(data, 'director_seo_title');
            i18n_val_text(data, 'director_seo_keywords');
            i18n_val_text(data, 'director_seo_description');
            i18n_val_text(data, 'director_seo_main_keyword');
            i18n_val_ckeditor(data, 'director_note');
            i18n_val_ckeditor(data, 'director_award');
            i18n_val_ckeditor(data, 'director_history');
            i18n_val_text(data, 'director_country');
            
            jsAdmin.sendAjax('post', 'text', data, 'product/director_edit?director_id=<?php echo $filter['director_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('product/director_edit?director_id=<?php echo $filter['director_id']; ?>');
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
            if (!isEmpty($('#interval-product-director-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {director_id:<?php echo $filter['director_id']; ?>}, 'product/director_editting');
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
                    hash_back = 'product/director_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

