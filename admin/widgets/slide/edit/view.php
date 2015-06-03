<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
    <div class="breadcrumb">
        <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
        <a href="admin.php#slide/lists">Slider</a>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img alt="" src="public/admin/image/home.png">Sửa Slide</h1>
            <div class="buttons">
                <a class="button" id="click-save">Lưu</a>
                <a class="button" id="click-back">Trở Về</a>
            </div>
        </div>
        <div class="content">
            <?php echo $message; ?>
            <div class="htabs" id="tabs">
                <a href="#tab-general">Thông Tin</a>
                <a href="#tab-image">Hình Ảnh</a>
                <a href="#tab-other">Khác</a>
                <div id="control-language"></div>
            </div>
            <form id="form" onsubmit="return false;" method="post">
                <div id="tab-general">
                    <table class="form">
                        <tbody>
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
                                    <?php showError($errors, 'slide_timer_date_time_int'); ?>
                                </td>
                            </tr>
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
                                        <option <?php echo _selected($filter, 'slide_position', (string)$key) ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
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
                                    <?php _image_server($filter, 'slide_image', $ck_img_path); ?>
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
                                    <span class="help">Mỗi sản phẩm sẽ có một ID duy nhất</span>
                                </td>
                                <td>
                                    <strong><?php echo $filter['slide_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                    <span class="help">Thông tin ngày đăng và người đăng</span>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['slide_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['slide_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['slide_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['slide_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['slide_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php $this->security->set_action('slide_edit'); ?>
            </form>
        </div>
        <input type="hidden" id="interval-slide-editting" value="slide-editting"/>
    </div>
    <script language="javscript" type="text/javascript">
        $(document).ready(function()
        {
            // Lang
            jsAdmin.loadLang();
        
            // Title Slide
            jsAdmin.changeTitle('Sửa Tin Slide');

            // Tabs
            jsAdmin.loadTabs('tabs');

            // Timer
            jsAdmin.loadTimer();
            
            // Ckfinder
            jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/slide/connector/<?php echo $ck_img_id; ?>/Images';
            
            // Click Back
            $('#click-back').click(function(){
                var hash_back = jsAdmin.urlBack.level1.hash();
                if (!hash_back){
                        hash_back = 'slide/lists';
                }
                jsAdmin.redirect(hash_back, 'get');
            });
            
            $('#click-save').click(function()
            {
                var data = 
                {
                    slide_id             : <?php echo $filter['slide_id']; ?>,
                    slide_position       : trim($('#slide_position').val()),
                    slide_image   : trim($('#image_server').val()),
                    slide_edit           : $('#slide_edit').val()
                };
                
                // Add Data
                i18n_val_text(data, 'slide_title');
                i18n_val_text(data, 'slide_link');
                i18n_val_ckeditor(data, 'slide_content');

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
                data.slide_timer = timer;
                
                // Validate data
                if (i18n_is_empty('slide_title')){
                    jAlert('Bạn chưa nhập tiêu đề đầy đủ', 'Lỗi tiêu đề');
                    return false;
                }

                if (i18n_is_empty('slide_link')){
                    jAlert('Bạn chưa nhập link slide đầy đủ', 'Lỗi link slide');
                    return false;
                }

                jsAdmin.sendAjax('post', 'text', data, 'slide/edit?slide_id=<?php echo $filter['slide_id']; ?>', function (result)
                {
                    result = trim(result);
                    if (result == '100'){
                        jAlert('Cập nhật thành công', 'Cập nhật thành công', function (){
                            jsAdmin.redirect('slide/edit?slide_id=<?php echo $filter['slide_id']; ?>');
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
                if (!isEmpty($('#interval-slide-editting').val())){
                    jsAdmin.sendHideAjax('get', 'text', {slide_id:<?php echo $filter['slide_id']; ?>}, 'slide/editting');
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
                    hash_back = 'slide/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

