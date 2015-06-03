<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#news/post_lists">Tin Tức</a> ::
    <a href="admin.php#news/tags_lists">Tag</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa tag</h1>
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
                                <strong>Tiêu Đề Ngắn <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span> 
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="tags_slug" to-title="tags_title_short" id="tags_title_short" name="tags_title_short" value="<?php _lang_val($filter, 'tags_title_short'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_title_short'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="tags_slug" to-title="tags_title_short" id="tags_slug" name="tags_slug" value="<?php _lang_val($filter, 'tags_slug'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Tiêu đề dài hiển thị chi tiết nhằm giúp tối ưu SEO</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="tags_title" name="tags_slug" value="<?php _lang_val($filter, 'tags_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_title'); ?>
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
                                <div class="multilang" type="text" id="tags_seo_title" name="tags_seo_title" value="<?php _lang_val($filter, 'tags_seo_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_seo_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Keywords</strong>
                                <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="tags_seo_keywords" name="tags_seo_keywords" value="<?php _lang_val($filter, 'tags_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_seo_keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Description</strong>
                                <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="tags_seo_description" name="tags_seo_description" value="<?php _lang_val($filter, 'tags_seo_description'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_seo_description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Robots</strong>
                                <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'tags_seo_robots'); ?>" id="tags_seo_robots" size="100" maxlength="255"/>
                                <?php showError($errors, 'tags_seo_robots'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Last Visit</strong>
                                <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'tags_seo_last_visit'); ?>" id="tags_seo_last_visit" size="100" maxlength="255"/>
                                <?php showError($errors, 'tags_seo_last_visit'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Main Keyword</strong>
                                <span class="help">Từ khóa chính của bài</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="tags_seo_main_keyword" name="tags_seo_main_keyword" value="<?php _lang_val($filter, 'tags_seo_main_keyword'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'tags_seo_main_keyword'); ?>
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
                                <span class="help">Mỗi tin sẽ có một ID duy nhất</span>
                            </td>
                            <td>
                                <strong><?php echo $filter['tags_id']; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày Đăng</strong>
                                <span class="help">Thông tin ngày đăng và người đăng</span>
                            </td>
                            <td>
                                <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['tags_add_date_time'])); ?></strong> 
                                <span>Bởi</span>: <strong><?php echo $filter['tags_add_user_username']; ?></strong> <br/>
                            </td>
                        </tr>
                        <?php if ($filter['tags_last_update_user_id']){ ?>
                        <tr>
                            <td>
                                <strong>Ngày Cập Nhật</strong>
                                <span class="help">Thông tin ngày cập nhật và người cập nhật cuối cùng</span>
                            </td>
                            <td>
                                <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['tags_last_update_date_time'])); ?></strong>
                                <span>Bởi</span>:  <strong><?php echo $filter['tags_last_update_user_username']; ?></strong> <br/>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <strong>Tổng Số Tin</strong>
                                <span class="help">Tổng số tin của tags này</span>
                            </td>
                            <td>
                                <strong><?php echo $filter['tags_total_post']; ?> Tin</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>URL</strong>
                                <span class="help">Đường link xem bài viết ngoài website</span>
                            </td>
                            <td>
                                <?php lang_url_front($filter, array('tags_slug'), 'tag/{tags_slug}'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('tags_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-news-tags-editting" value="news-tags-editting"/>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Lang
        jsAdmin.loadLang();
        
        jsAdmin.changeTitle('Sửa Tags');
        
        // Menu
        jsAdmin.changeMenu('news/tags_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'news/tags_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
             var data = 
            {
                tags_id             : '<?php echo $filter['tags_id']; ?>',
                tags_ref_parent_id  : trim($('#tags_ref_parent_id').val()),
                tags_seo_robots     : trim($('#tags_seo_robots').val()),
                tags_seo_last_visit : trim($('#tags_seo_last_visit').val()),
                tags_edit            : $('#tags_edit').val()
            };
            
            // Validate data
            if (i18n_is_empty('tags_title_short')){
                jAlert('Bạn chưa nhập tiêu đề ngắn đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (i18n_is_empty('tags_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ các ngôn ngữ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('tags_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không in hoa, không dấu ở các ngôn ngữ', 'Lỗi slug');
                return false;
            }
            
            // Add Data
            i18n_val_text(data, 'tags_title');
            i18n_val_text(data, 'tags_title_short');
            i18n_val_text(data, 'tags_slug');
            i18n_val_text(data, 'tags_seo_title');
            i18n_val_text(data, 'tags_seo_keywords');
            i18n_val_text(data, 'tags_seo_description');
            i18n_val_text(data, 'tags_seo_main_keyword');
            
            jsAdmin.sendAjax('post', 'text', data, 'news/tags_edit?tags_id=<?php echo $filter['tags_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('news/tags_edit?tags_id=<?php echo $filter['tags_id']; ?>');
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
            if (!isEmpty($('#interval-news-tags-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {tags_id:<?php echo $filter['tags_id']; ?>}, 'news/tags_editting');
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
                    hash_back = 'news/tags_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

