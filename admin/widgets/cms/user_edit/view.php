<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
    <div class="breadcrumb">
        <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
        <a href="admin.php#cms/user_lists">Thành Viên</a>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img alt="" src="public/admin/image/home.png">Sửa Thành Viên</h1>
            <div class="buttons">
                <a class="button" id="click-save">Lưu</a>
                <a class="button" id="click-back">Trở Lại</a>
            </div>
        </div>
        <div class="content">
            <?php echo $message; ?>
            <div class="htabs" id="tabs">
                <a href="#tab-general">Thông Tin Chính</a>
                <a href="#tab-avatar">Avatar</a>
                <a href="#tab-password">Đổi Mật Khẩu</a>
                <a href="#tab-more">Thông Tin Khác</a>
            </div>
            <form id="form" method="post">
                <div id="tab-general">
                    <table class="form">
                        <tbody>
                            
                            <tr>
                                <td>
                                    <strong>ID</strong>
                                </td>
                                <td>
                                     <strong> <?php echo $filter['user_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Tài Khoản</strong>
                                </td>
                                <td>
                                     <strong> <?php echo $filter['user_username']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng Ký</strong>
                                </td>
                                <td>
                                    <strong> <?php echo date('d-m-Y H:i:s', $filter['user_add_date_time_int']); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Trạng Thái</strong>
                                </td>
                                <td>
                                    <?php if (can_edit_user_status($filter['user_id'], $filter['user_is_root'])){ ?>
                                    <select id="user_status">
                                        <option value="0" <?php echo (!isset($filter['user_status']) || $filter['user_status'] != '1') ? ' selected ' : ''; ?>>Khóa</option>
                                        <option value="1" <?php echo (isset($filter['user_status']) && $filter['user_status'] == '1') ? ' selected ' : ''; ?>>Bình Thường</option>
                                    </select>
                                    <?php } else echo  '<strong>'.(($filter['user_status']) ? 'Active' : 'Banded').'</strong>';?>
                                    <?php showError($errors, 'user_status'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nhóm</strong>
                                </td>
                                <td>
                                    <?php if (can_edit_user_status($filter['user_id'], $filter['user_is_root'])){ ?>
                                    <select id="user_level" style="width: 200px;">
                                        <?php foreach ($this->auth->getLevelList() as $key => $value){ ?>
                                            <?php if (can_edit_user_level($key)){ ?>
                                                <option <?php echo _selected($filter, 'user_level', (string)$key) ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php } else echo  '<strong style="color:blue">'.$this->auth->getLevelName($filter['user_level']).'<strong>'; ?>
                                    <?php showError($errors, 'user_level'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Email <span class="required">(*)</span></strong>
                                </td>
                                <td>
                                    <input type="text" id="user_email" value="<?php _val($filter, 'user_email'); ?>" size="50" maxlength="30"/>
                                    <?php showError($errors, 'user_email'); ?>
                                    <?php showError($errors, 'user_email_int'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tab-avatar">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Avatar</strong>
                                </td>
                                <td>
                                    <img style="border:solid 2px #CCCCCC;" src="<?php echo $this->auth->getAvatar($filter['user_username'], $filter['user_add_date_int']).'?rand='.  date('dmyhis'); ?>" width="100px" height="100px"/> <br/><br/>
                                    <strong>Đổi avatar</strong>
                                    <input type="file" name="user_avatar" id="user_avatar"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tab-password">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Mật Khẩu</strong>
                                </td>
                                <td>
                                    <input type="password" id="user_password" value="" size="50" maxlength="30"/>
                                    <?php showError($errors, 'user_password'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nhập Lại Mật Khẩu</strong>
                                </td>
                                <td>
                                    <input type="password" id="user_password_again" value="" size="50" maxlength="30"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tab-more">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Ngày Sinh</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_birthday" value="<?php _val($filter, 'user_birthday'); ?>" size="50" maxlength="30"/>
                                    <?php showError($errors, 'user_birthday'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Điện Thoại</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_phone" value="<?php _val($filter, 'user_phone'); ?>" size="50" maxlength="30"/>
                                    <?php showError($errors, 'user_phone'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Tên Đầy Đủ</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_fullname" value="<?php _val($filter, 'user_fullname'); ?>" size="100" maxlength="30"/>
                                    <?php showError($errors, 'user_fullname'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Website</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_website" value="<?php _val($filter, 'user_website'); ?>" size="100" maxlength="30"/>
                                    <?php showError($errors, 'user_website'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Địa Chỉ</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_address" value="<?php _val($filter, 'user_address'); ?>" size="100" maxlength="30"/>
                                    <?php showError($errors, 'user_address'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Facebook Url</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_facebook_url" value="<?php _val($filter, 'user_facebook_url'); ?>" size="100" maxlength="30"/>
                                    <?php showError($errors, 'user_facebook_url'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Google+ Url</strong>
                                </td>
                                <td>
                                    <input type="text" id="user_google_plus_url" value="<?php _val($filter, 'user_google_plus_url'); ?>" size="100" maxlength="30"/>
                                    <?php showError($errors, 'user_google_plus_url'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Giới Thiệu</strong>
                                </td>
                                <td>
                                    <textarea id="user_intro" cols="100" rows="3"><?php _val($filter, 'user_intro'); ?></textarea>
                                    <?php showError($errors, 'user_intro'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php $this->security->set_action('user_edit'); ?>
            </form>
        </div>
        <input type="hidden" id="interval-user-editting" value="user-editting"/>
    </div>
    <script language="javscript" type="text/javascript">
        $(document).ready(function()
        {
            // Title Page
            jsAdmin.changeTitle('Sửa Thành Viên');
            
            // Menu
            jsAdmin.changeMenu('cms/user_lists');
        
            // Editor
            jsAdmin.ckeditor.toolbar = [
                        ['Source','-','TextColor','Bold','Italic','Underline','Strike','Link','Unlink']
            ];

            CKEDITOR.replace('user_intro');

            // Tabs
            jsAdmin.loadTabs('tabs');

            $('#user_birthday').datepicker({
                dateFormat: 'dd-mm-yy'
            });

             $('#click-back').click(function(){
                var hash_back = jsAdmin.urlBack.level1.hash();
                if (!hash_back){
                        hash_back = 'cms/user_lists';
                }
                jsAdmin.redirect(hash_back, 'get');
            });
            
            var root = <?php echo $filter['user_is_root'] ? '1' : '0'; ?>;
            var current_id = <?php echo $this->auth->getItem('user_id'); ?>;
            $('#click-save').click(function()
            {
                var data = 
                {
                    user_id             : <?php echo $filter['user_id']; ?>,
                    user_email          : trim($('#user_email').val()),
                    user_avatar        : $('#user_avatar'),
                    user_password       : trim($('#user_password').val()),
                    user_fullname       : trim($('#user_fullname').val()),
                    user_website        : trim($('#user_website').val()),
                    user_birthday       : trim($('#user_birthday').val()),
                    user_phone          : trim($('#user_phone').val()),
                    user_address        : trim($('#user_address').val()),
                    user_facebook_url   : trim($('#user_facebook_url').val()),
                    user_google_plus_url: trim($('#user_google_plus_url').val()),
                    user_intro          : CKEDITOR.instances['user_intro'].getData(),
                    user_edit           : $('#user_edit').val()
                };
                
                if (root != 1 && current_id != data.user_id){
                    data.user_status = trim($('#user_status').val());
                    data.user_level  = trim($('#user_level').val());
                }
                
                // Validate data
                if (!is_username(data.user_username)){
                    jAlert('Tên đăng nhập chỉ chấp nhận ký tự không dấu và số, dài từ 5 đến 15', 'Lỗi dữ liệu');
                    return false;
                }
                
                if (!isEmail(data.user_email)){
                    jAlert('Email không đúng định dạng', 'Lỗi dữ liệu');
                    return false;
                }
                
                if (!isEmpty(data.user_password)){
                    if (data.user_password != trim($('#user_password_again').val())){
                        jAlert('Mật khẩu nhập lại không đúng với mật khẩu gốc', 'Lỗi dữ liệu');
                        return false;
                    }
                    data.user_password = md5(data.user_password);
                }
                
                var form = new FormData();
                
                form.append('user_avatar', $('#user_avatar')[0].files[0]);
                
                $.each(data, function(key, value) {
                    form.append(key, value);
                });

                jsAdmin.sendAjaxFile('text', form, 'cms/user_edit?user_id=<?php echo $filter['user_id']; ?>', function (result)
                {
                    result = trim(result);
                    if (result == '100'){
                        jAlert('Cập nhật thành công', 'Thành công', function (){
                            jsAdmin.redirect('cms/user_edit?user_id=<?php echo $filter['user_id']; ?>');
                        });
                    }
                    else if (result == '101'){
                        jAlert('Có thể do mạng yếu hoặc lỗi dữ liệu', 'Thất bại');
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
                if (!isEmpty($('#interval-user-editting').val())){
                    jsAdmin.sendHideAjax('get', 'text', {user_id:<?php echo $filter['user_id']; ?>}, 'cms/user_editting');
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
        jAlert('Người dùng này đang được sửa bởi <?php echo $filter['editting_user_username']; ?>', 'Lỗi phiên làm việc', function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'cms/user_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

