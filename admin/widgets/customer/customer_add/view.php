<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/customer_lists">Khách Hàng</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Khách Hàng Mới</h1>
        <div class="buttons">
            <a class="button" id="click-save">Bước Tiếp Theo</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr style="display: none">
                            <td>
                                <strong>Nhóm </strong>
                                <span class="help">Nhóm Khách Hàng</span>
                            </td>
                            <td>
                                <select id="customer_group">
                                    <option value="0">Cá Nhân</option>
                                    <option value="1" <?php _selected($filter, 'customer_group', '1'); ?>>Công Ty</option>
                                </select>
                                <?php showError($errors, 'customer_group'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tên Khách Hàng <span class="required">(*)</span></strong>
                                <span class="help">Tên đầy đủ của khách hàng</span>
                            </td>
                            <td>
                                <input type="text" id="customer_fullname" value="<?php _val($filter, 'customer_fullname'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'customer_fullname'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mã khách hàng <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 12 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="customer_username" value="<?php _val($filter, 'customer_username'); ?>" size="50" maxlength="15"/>
                                <?php showError($errors, 'customer_username'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mật Khẩu <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 15 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="customer_password" value="" size="50" maxlength="15"/>
                                <?php showError($errors, 'customer_password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nhập Lại Mật Khẩu <span class="required">(*)</span></strong>
                                <span class="help">Nhập lại mật khẩu mà bạn đã chọn</span>
                            </td>
                            <td>
                                <input type="text" id="customer_confirmpassword" value="" size="50" maxlength="15"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày Sinh</strong>
                                <span class="help">Ngày sinh của khách hàng, bạn sẽ chăm sóc tốt hơn</span>
                            </td>
                            <td>
                                <input type="text" class="timer" id="customer_birthday" value="<?php echo (empty($filter['customer_birthday_int']) ? '' : date('d-m-Y', $filter['customer_birthday_int'])); ?>" size="50" maxlength="155"/>
                                <?php showError($errors, 'customer_birthday'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email <span class="required">(*)</span></strong>
                                <span class="help">Nhập Email của khách hàng, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="customer_email" value="<?php _val($filter, 'customer_email'); ?>" size="50" maxlength="155"/>
                                <?php showError($errors, 'customer_email'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Điện Thoại</strong>
                                <span class="help">Nhập số điện thoại của khách hàng, tối đa 30 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="customer_phone" value="<?php _val($filter, 'customer_phone'); ?>" size="50" maxlength="30"/>
                                <?php showError($errors, 'customer_phone'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa Chỉ <span class="required">(*)</span></strong>
                                <span class="help">Nhập số địa chỉ của khách hàng, tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="customer_address" value="<?php _val($filter, 'customer_address'); ?>" size="100" maxlength="500"/>
                                <?php showError($errors, 'customer_address'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('customer_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        
        // Title Page
        jsAdmin.changeTitle('Thêm Khách Hàng HMới');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Menu
        jsAdmin.changeMenu('customer/customer_lists');
        
        // Timer
        $('#customer_birthday').datepicker({
                    dateFormat: 'dd-mm-yy'
        });
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'customer/customer_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        // save
        $('#click-save').click(function()
        {
            var data = 
            {
                customer_username   : trim($('#customer_username').val()),
                customer_fullname   : trim($('#customer_fullname').val()),
                customer_password   : trim($('#customer_password').val()),
                customer_birthday   : trim($('#customer_birthday').val()),
                customer_group      : trim($('#customer_group').val()),
                customer_email      : trim($('#customer_email').val()),
                customer_phone      : trim($('#customer_phone').val()),
                customer_address    : trim($('#customer_address').val()),
                customer_add        : $('#customer_add').val()
            };
            
            // Validate Fulllname
            if (isEmpty(data.customer_fullname)){
                jAlert('Tên của khách hàng không được để trống', 'Lỗi dữ liệu');
                return false;
            }
                
            // Validate Username
            if (!is_username(data.customer_username)){
                jAlert('Tên đăng nhập dài từ 5 đến 15 ký tự, chỉ chấp nhận chữ không dấu và số', 'Lỗi dữ liệu');
                return false;
            }
            
            // Validate Password
            if (data.customer_password.length > 15 || data.customer_password <= 6){
                jAlert('Mật khẩu phải dài từ 6 đến 12 ký tự', 'Lỗi dữ liệu');
                return false;
            }
            
            if (data.customer_password != $('#customer_confirmpassword').val()){
                jAlert('Mật khẩu ban nhập lại không đúng', 'Lỗi dữ liệu');
                return false;
            }
            
            // Email
            if (!isEmail(data.customer_email)){
                jAlert('Vui lòng nhập đúng email', 'Lỗi dữ liệu');
                return false;
            }
            
            // Address
            if (isEmpty(data.customer_address)){
                jAlert('Bạn chưa nhập địa chỉ', 'Lỗi dữ liệu');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/customer_add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('customer/customer_edit?customer_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

