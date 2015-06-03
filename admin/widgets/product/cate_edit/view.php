<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/cate_lists">Chuyên Mục</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Chuyên Mục</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
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
                                <strong>Tên Chuyên Mục<span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách phim theo chuyên mục)</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="cate_slug" to-title="cate_title_short" id="cate_title_short" name="cate_title_short" value="<?php _lang_val($filter, 'cate_title_short'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_title_short'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug (URL) <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="cate_slug" to-title="cate_title_short" id="cate_slug" name="cate_slug" value="<?php _lang_val($filter, 'cate_slug'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô Tả Chuyên Mục <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Tiêu đề dài hiển thị chi tiết nhằm giúp tối ưu SEO</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="cate_title" name="cate_title" value="<?php _lang_val($filter, 'cate_title'); ?>"  maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Icon</strong>
                                <span class="help">Hình Icon của chuyên mục</span>
                            </td>
                            <td>
                                <?php _image_server($filter, 'cate_icon', $ck_img_path); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Sắp Xếp</strong>
                                <span class="help">Thứ tự hiển thị chuyên mục</span>
                            </td>
                            <td>
                                <input type="text" onkeypress="return onlyNumbers(event)" id="cate_sort" value="<?php _val($filter, 'cate_sort', '0'); ?>" size="4" maxlength="4"/>
                                <?php showError($errors, 'cate_sort'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Thể Loại</strong>
                                <span class="help">Phim hoặc Nhạc</span>
                            </td>
                            <td>
                                <select id="cate_type">
                                    <option value="1" <?php echo (isset($filter['cate_type']) && $filter['cate_type'] == 1) ? 'selected' : ''; ?>>PHIM</option>
                                    <option value="2" <?php echo (isset($filter['cate_type']) && $filter['cate_type'] != 1) ? 'selected' : ''; ?>>NHẠC</option>
                                </select>
                                <?php showError($errors, 'cate_type'); ?>
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
                                <div class="multilang" type="text" id="cate_seo_title" name="cate_seo_title" value="<?php _lang_val($filter, 'cate_seo_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_seo_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Keywords</strong>
                                <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="cate_seo_keywords" name="cate_seo_keywords" value="<?php _lang_val($filter, 'cate_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_seo_keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Description</strong>
                                <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="cate_seo_description" name="cate_seo_description" value="<?php _lang_val($filter, 'cate_seo_description'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'cate_seo_description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Robots</strong>
                                <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'cate_seo_robots'); ?>" id="cate_seo_robots" size="100" maxlength="255"/>
                                <?php showError($errors, 'cate_seo_robots'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Last Visit</strong>
                                <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'cate_seo_last_visit'); ?>" id="cate_seo_last_visit" size="100" maxlength="255"/>
                                <?php showError($errors, 'cate_seo_last_visit'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Main Keyword</strong>
                                <span class="help">Từ khóa chính của bài</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="cate_seo_main_keyword" name="cate_seo_main_keyword" value="<?php _lang_val($filter, 'cate_seo_main_keyword'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'cate_seo_main_keyword'); ?>
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
                                    <strong><?php echo $filter['cate_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['cate_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['cate_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['cate_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['cate_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['cate_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                </td>
                                <td>
                                    <a href="#" target="_blank"><?php echo $this->config->base_url($filter['cate_slug_vi']); ?></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('cate_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-product-cate-editting" value="product-cate-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Sửa Chuyên Mục Phim');
    
        // Ckfinder
        jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/product_cate/connector/<?php echo $filter['cate_id']; ?>/Images';
        
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('product/cate_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/cate_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                cate_sort           : trim($('#cate_sort').val()),
                cate_type           : trim($('#cate_type').val()),
                cate_icon           : trim($('#image_server').val()),
                cate_id             : <?php echo $filter['cate_id']; ?>,
                cate_seo_robots     : trim($('#cate_seo_robots').val()),
                cate_seo_last_visit : trim($('#cate_seo_last_visit').val()),
                cate_edit            : $('#cate_edit').val()
            };
            
            // Validate data
            if (i18n_is_empty('cate_title_short')){
                jAlert('Bạn chưa nhập tiêu đề ngắn đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (i18n_is_empty('cate_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('cate_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không in hoa, không dấu ở các ngôn ngữ', 'Lỗi slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'cate_title');
            i18n_val_text(data, 'cate_title_short');
            i18n_val_text(data, 'cate_slug');
            i18n_val_text(data, 'cate_seo_title');
            i18n_val_text(data, 'cate_seo_keywords');
            i18n_val_text(data, 'cate_seo_description');
            i18n_val_text(data, 'cate_seo_main_keyword');
            
            jsAdmin.sendAjax('post', 'text', data, 'product/cate_edit?cate_id=<?php echo $filter['cate_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('product/cate_edit?cate_id=<?php echo $filter['cate_id']; ?>');
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
            if (!isEmpty($('#interval-product-cate-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {cate_id:<?php echo $filter['cate_id']; ?>}, 'product/cate_editting');
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
                    hash_back = 'product/cate_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

