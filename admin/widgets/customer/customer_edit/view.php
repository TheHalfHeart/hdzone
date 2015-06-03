<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
    <div class="breadcrumb">
        <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
        <a href="admin.php#customer/customer_lists">Trang Web</a>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img alt="" src="public/admin/image/home.png">Sủa Khách Hàng</h1>
            <div class="buttons">
                <?php if (!$this->auth->isContributor() || $filter['customer_timer_date_time_int'] == timer_private()){ ?>
                <a class="button" id="click-save">Lưu</a>
                <?php } ?>
                <a class="button" id="click-save">Xem đơn hàng</a>
                <a class="button" id="click-save">Xem phim đã chọn</a>
                <a class="button" id="click-save">Xem lịch sử giao dịch</a>
                <a class="button" id="click-back">Trở Về</a>
            </div>
        </div>
        <div class="content">
            <?php echo $message; ?>
            <div class="htabs" id="tabs">
                <a href="#tab-general" class="selected">Thông Tin</a>
                <a href="#tab-change-password" class="selected">Đổi Mật Khẩu</a>
                <a href="#tab-other">Khác</a>
                <div id="control-language"></div>
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
                                    <strong>Mã khách hàng</strong>
                                    <span class="help">Tối đa 12 ký tự</span>
                                </td>
                                <td>
                                    <strong><?php _val($filter, 'customer_username'); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Trạng Thái </strong>
                                    <span class="help">Trạng thái được phép đăng ký đơn hàng</span>
                                </td>
                                <td>
                                    <select id="customer_status">
                                        <option value="1">Mở</option>
                                        <option value="0" <?php _selected($filter, 'customer_status', '0'); ?>>Khóa</option>
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
                <div id="tab-change-password">
                    <table class="form">
                        <tbody>
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
                                    <strong><?php echo $filter['customer_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng Ký</strong>
                                    <span class="help">Thông tin ngày đăng và người đăng</span>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['customer_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['customer_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['customer_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                    <span class="help">Thông tin ngày cập nhật và người cập nhật cuối cùng</span>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['customer_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['customer_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>Tổng số đơn hàng</strong>
                                </td>
                                <td>
                                    <strong><?php echo $filter['customer_total_order']; ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php $this->security->set_action('customer_edit'); ?>
            </form>
        </div>
        <input type="hidden" id="interval-customer-editting" value="customer-editting"/>
    </div>
    <script language="javscript" type="text/javascript">
        $(document).ready(function()
        {
           
            // Title Page
            jsAdmin.changeTitle('Sửa Khách Hàng');
            
            // Menu
            jsAdmin.changeMenu('customer/customer_add');
            
            // Tabs
            jsAdmin.loadTabs('tabs');
            
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
            
            $('#click-save').click(function()
            {
                var data = 
                {
                    customer_id         : '<?php echo $filter['customer_id']; ?>',
                    customer_password   : trim($('#customer_password').val()),
                    customer_group      : trim($('#customer_group').val()),
                    customer_status     : trim($('#customer_status').val()),
                    customer_birthday   : trim($('#customer_birthday').val()),
                    customer_email      : trim($('#customer_email').val()),
                    customer_fullname   : trim($('#customer_fullname').val()),
                    customer_phone      : trim($('#customer_phone').val()),
                    customer_address    : trim($('#customer_address').val()),
                    customer_edit       : $('#customer_edit').val()
                };
                
                // Validate Fulllname
                if (isEmpty(data.customer_fullname)){
                    jAlert('Tên của khách hàng không được để trống', 'Lỗi dữ liệu');
                    return false;
                }
                
                // Validate Password
                if (!isEmpty(data.customer_password)){
                    
                    if (data.customer_password.length > 15 || data.customer_password <= 6){
                        jAlert('Mật khẩu phải dài từ 5 đến 12 ký tự', 'Lỗi dữ liệu');
                        return false;
                    }

                    if (data.customer_password != $('#customer_confirmpassword').val()){
                        jAlert('Mật khẩu ban nhập lại không đúng', 'Lỗi dữ liệu');
                        return false;
                    }
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
                
                jsAdmin.sendAjax('post', 'text', data, 'customer/customer_edit?customer_id=<?php echo $filter['customer_id']; ?>', function (result)
                {
                    result = trim(result);
                    if (result == '100'){
                        jAlert('Cập nhật thành công', 'Thành công', function (){
                            jsAdmin.redirect('customer/customer_edit?customer_id=<?php echo $filter['customer_id']; ?>');
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
                if (!isEmpty($('#interval-customer-editting').val())){
                    jsAdmin.sendHideAjax('get', 'text', {customer_id:<?php echo $filter['customer_id']; ?>}, 'customer/customer_editting');
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
                    hash_back = 'customer/customer_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>