<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
    <div class="breadcrumb">
        <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
        <a href="admin.php#page/lists">Trang Web</a>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img alt="" src="public/admin/image/home.png">Sủa Trang Web</h1>
            <div class="buttons">
                <?php if (!$this->auth->isContributor() || $filter['page_timer_date_time_int'] == timer_private()){ ?>
                <a class="button" id="click-save">Lưu</a>
                <?php } ?>
                <a class="button" id="click-back">Trở Về</a>
            </div>
        </div>
        <div class="content">
            <?php echo $message; ?>
            <div class="htabs" id="tabs">
                <a href="#tab-general" class="selected">Thông Tin</a>
                <a href="#tab-image">Hình Ảnh</a>
                <a href="#tab-seo">SEO</a>
                <a href="#tab-other">Khác</a>
                <div id="control-language"></div>
            </div>
            <form id="form" onsubmit=" return false;" method="post">
                <div id="tab-general">
                    <table class="form">
                        <tbody>
                            <?php if (!$this->auth->isContributor()){ ?>
                            <tr>
                                <td>
                                    <strong>Tình Trạng</strong>
                                    <span class="help">Hiển thị, ẩn, hẹn giờ hiển thị</span>
                                </td>
                                <td>
                                    <input type="radio" name="timer" value="1" id="timer_public" <?php _timer_public($filter); ?>/> 
                                    <label for="timer_public">Hiển Thị</label>
                                    <input type="radio" name="timer" value="0" id="timer_private" <?php _timer_private($filter); ?>/>
                                    <label for="timer_private">Ẩn</label>
                                    <input type="radio" name="timer" value="2" id="timer_timer" <?php _timer_timer($filter); ?>/>
                                    <label for="timer_timer"><strong>Hẹn Giờ</strong></label>
                                    <input type="text" id="timer_date" class="timer" value="<?php _val($filter, 'timer_day'); ?>" placeholder="dd-mm-yyyy" style="width: 70px;"/>
                                    <input type="text" id="timer_time" class="timer" value="<?php _val($filter, 'timer_time'); ?>" placeholder="hh:mm:ss" style="width: 60px;"/>
                                    <?php showError($errors, 'page_timer_date_time_int'); ?>
                                </td>
                            </tr>
                            <?php } ?>
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
                            <tr>
                                <td>
                                    <strong>Nội Dung Trang</strong>
                                    <span class="help">Nội dung chính của trang</span>
                                </td>
                                <td>
                                    <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['page_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['page_add_date_int']).$filter['page_id']; ?>" ck-module="page" id="page_content" name="page_content" value="<?php _lang_val($filter, 'page_content'); ?>"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tab-image">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Hình Đại Diện</strong>
                                    <span class="help">- Tối đa 500 ký tự. Có thể nhập URL có sẵn hoặc dùng chức năng up hình lên server bằng cách bấm vào nút Server</span>
                                    <span class="help">- Hãy resize hình ảnh về mức medium để website chạy nhanh hơn</span>
                                </td>
                                <td>
                                    <?php _image_server($filter, 'page_image', $ck_img_path); ?>
                                    <?php showError($errors, 'page_image'); ?>
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
                                    <div class="multilang" type="text" id="page_seo_title" name="page_seo_title" value="<?php _lang_val($filter, 'page_seo_title'); ?>" maxlength="255" size="100"></div>
                                    <?php showErrorLang($errors, 'page_seo_title'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Seo Keywords</strong>
                                    <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                                </td>
                                <td>
                                    <div class="multilang" type="text" id="page_seo_keywords" name="page_seo_keywords" value="<?php _lang_val($filter, 'page_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                    <?php showErrorLang($errors, 'page_seo_keywords'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Seo Description</strong>
                                    <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                                </td>
                                <td>
                                    <div class="multilang" type="text" id="page_seo_description" name="page_seo_description" value="<?php _lang_val($filter, 'page_seo_description'); ?>" maxlength="255" size="100"></div>
                                    <?php showErrorLang($errors, 'page_seo_description'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Seo Robots</strong>
                                    <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                                </td>
                                <td>
                                    <input type="text" value="<?php _val($filter, 'page_seo_robots'); ?>" id="page_seo_robots" size="100" maxlength="255"/>
                                    <?php showError($errors, 'page_seo_robots'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Seo Last Visit</strong>
                                    <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                                </td>
                                <td>
                                    <input type="text" value="<?php _val($filter, 'page_seo_last_visit'); ?>" id="page_seo_last_visit" size="100" maxlength="255"/>
                                    <?php showError($errors, 'page_seo_last_visit'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Main Keyword</strong>
                                    <span class="help">Từ khóa chính của bài</span>
                                </td>
                                <td>
                                    <div class="multilang" type="text" id="page_seo_main_keyword" name="page_seo_main_keyword" value="<?php _lang_val($filter, 'page_seo_main_keyword'); ?>" maxlength="500" size="100"></div>
                                    <?php showErrorLang($errors, 'page_seo_main_keyword'); ?>
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
                                    <strong><?php echo $filter['page_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                    <span class="help">Thông tin ngày đăng và người đăng</span>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['page_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['page_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['page_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                    <span class="help">Thông tin ngày cập nhật và người cập nhật cuối cùng</span>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['page_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['page_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                    <span class="help">Đường link xem bài viết ngoài website</span>
                                </td>
                                <td>
                                    <?php echo $this->config->base_url($filter['page_slug_vi'].'.html'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php $this->security->set_action('page_edit'); ?>
            </form>
        </div>
        <input type="hidden" id="interval-page-editting" value="page-editting"/>
    </div>
    <script language="javscript" type="text/javascript">
        $(document).ready(function()
        {
            // Lang
            jsAdmin.loadLang();
            
            // Title Page
            jsAdmin.changeTitle('Sửa Trang Web');
            
            // Menu
            jsAdmin.changeMenu('page/add');
            
            // Tabs
            jsAdmin.loadTabs('tabs');
            
            // Ckfinder
            jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/page/connector/<?php echo $filter['page_id']; ?>/Images';
            
            // Timer
            jsAdmin.loadTimer();

            $('#click-back').click(function(){
                var hash_back = jsAdmin.urlBack.level1.hash();
                if (!hash_back){
                        hash_back = 'page/lists';
                }
                jsAdmin.redirect(hash_back, 'get');
            });
            
            <?php if (!$this->auth->isContributor() || $filter['page_timer_date_time_int'] == timer_private()){ ?>
            $('#click-save').click(function()
            {
                var data = 
                {
                    page_id             : <?php echo $filter['page_id']; ?>,
                    page_template       : trim($('#page_template').val()),
                    page_image          : trim($('#image_server').val()),
                    page_seo_robots     : trim($('#page_seo_robots').val()),
                    page_seo_last_visit : trim($('#page_seo_last_visit').val()),
                    page_edit           : $('#page_edit').val()
                };
                
                <?php if (!$this->auth->isContributor()){ ?>
                var timer = $('input[name="timer"]:checked').val();
                if (timer.toString() === '2')
                {
                    timer = trim($('#timer_date').val()) + ' ' + trim($('#timer_time').val());
                    
                    if (!is_timer(timer)){
                        jAlert('Định dạng ngày hiển thị không đúng', 'Lỗi ngày tháng');
                        return false;
                    }
                }
                else if (timer.toString() === '1'){
                    var tmp = trim($('#timer_date').val()) + ' ' + trim($('#timer_time').val());
                    if (!isEmpty(tmp)){
                        timer = tmp;
                    }
                }
                data.page_timer = timer;
                <?php } ?>
                
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
                i18n_val_ckeditor(data,'page_content');
                i18n_val_text(data, 'page_seo_title');
                i18n_val_text(data, 'page_seo_keywords');
                i18n_val_text(data, 'page_seo_description');
                i18n_val_text(data, 'page_seo_main_keyword');
                
                jsAdmin.sendAjax('post', 'text', data, 'page/edit?page_id=<?php echo $filter['page_id']; ?>', function (result)
                {
                    result = trim(result);
                    if (result == '100'){
                        jAlert('Cập nhật thành công', 'Thành công', function (){
                            jsAdmin.redirect('page/edit?page_id=<?php echo $filter['page_id']; ?>');
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
            <?php } ?>
            
            // Update Editting
            clearInterval(jsAdmin.editting);
            jsAdmin.editting = setInterval(function()
            {
                if (!isEmpty($('#interval-page-editting').val())){
                    jsAdmin.sendHideAjax('get', 'text', {page_id:<?php echo $filter['page_id']; ?>}, 'page/editting');
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
                    hash_back = 'page/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>