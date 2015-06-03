<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/user_lists">Thành Viên</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Thành Viên</h1>
        <div class="buttons">
            <a class="button" id="click-save">Bước Tiếp Theo</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin Chính</a>
            <a href="#tab-more">Thông Tin Khác</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general" style="display: block;">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tài Khoản <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="text" id="user_username" value="<?php _val($filter, 'user_username'); ?>" size="50" maxlength="30"/>
                                <?php showError($errors, 'user_username'); ?>
                                <?php showError($errors, 'user_username_int'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng Thái <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <select id="user_status">
                                    <option value="0" <?php echo (!isset($filter['user_status']) || $filter['user_status'] != '1') ? ' selected ' : ''; ?>>Band</option>
                                    <option value="1" <?php echo (isset($filter['user_status']) && $filter['user_status'] == '1') ? ' selected ' : ''; ?>>Active</option>
                                </select>
                                <?php showError($errors, 'user_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nhóm <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <select id="user_level" style="width: 200px;">
                                    <?php foreach ($this->auth->getLevelList() as $key => $value){ ?>
                                        <?php if (can_edit_user_level($key)){ ?>
                                            <option <?php echo _selected($filter, 'user_level', (string)$key) ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php showError($errors, 'user_level'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mật Khẩu <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="password" id="user_password" value="" size="50" maxlength="30"/>
                                <?php showError($errors, 'user_password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nhập Lại Mật Khẩu <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="password" id="user_password_again" value="" size="50" maxlength="30"/>
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
            <div id="tab-more" style="display: block;">
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
            <?php $this->security->set_action('user_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Thêm Thành Viên');
        
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
        
        $('#click-save').click(function()
        {
            var data = 
            {
                user_username       : trim($('#user_username').val()),
                user_email          : trim($('#user_email').val()),
                user_password       : trim($('#user_password').val()),
                user_status         : trim($('#user_status').val()),
                user_level          : trim($('#user_level').val()),
                user_fullname       : trim($('#user_fullname').val()),
                user_website        : trim($('#user_website').val()),
                user_birthday       : trim($('#user_birthday').val()),
                user_phone          : trim($('#user_phone').val()),
                user_address        : trim($('#user_address').val()),
                user_facebook_url   : trim($('#user_facebook_url').val()),
                user_google_plus_url: trim($('#user_google_plus_url').val()),
                user_intro          : CKEDITOR.instances['user_intro'].getData(),
                user_add            : $('#user_add').val()
            };
            
            // Validate data
            if (!is_username(data.user_username)){
                jAlert('Tên tài khoản chỉ chấp nhận ký tự không dấu và số, dài từ 5 đến 15 ký tự', 'Lỗi tên tài khoản');
                return false;
            }
            
            if (isEmpty(data.user_password)){
                jAlert('Mật khẩu không được để trống', 'Lỗi mật khẩu');
                return false;
            }
            
            if (data.user_password != trim($('#user_password_again').val())){
                jAlert('Mật khẩu nhập lại không đúng với mật khẩu gốc', 'Lỗi mật khẩu');
                return false;
            }
            
            if (!isEmail(data.user_email)){
                jAlert('Email không đúng định dạng', 'Lỗi email');
                return false;
            }
            
            data.user_password = md5(data.user_password);
            
            jsAdmin.sendAjax('post', 'text', data, 'cms/user_add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('cms/user_edit?user_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

