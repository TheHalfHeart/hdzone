<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/customer_lists">Khách Hàng</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Đơn Hàng Mới</h1>
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
                        <tr>
                            <td>
                                <strong>Khách Hàng <span class="required">(*)</span></strong>
                                <span class="help">Nhập Tên Đăng Nhập Của Khách Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_customer_username" value="<?php _val($filter, 'order_customer_username'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_customer_username'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tên Khách Hàng</strong>
                                <span class="help">Tên Khách Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_fullname" value="<?php _val($filter, 'order_fullname'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_fullname'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Nhập Tiêu Đề Đơn Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_title" value="<?php _val($filter, 'order_title'); ?>" size="50" maxlength="500"/>
                                <?php showError($errors, 'order_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng Thái</strong>
                                <span class="help">Tình Trạng Của Đơn Hàng</span>
                            </td>
                            <td>
                                <select id="order_status">
                                    <option value="0">Mới chọn</option>
                                    <option value="1" <?php _selected($filter, 'order_status', '1'); ?>>Đã nhận ổ</option>
                                    <option value="2" <?php _selected($filter, 'order_status', '2'); ?> >Đã trả ổ</option>
                                    <option value="3" <?php _selected($filter, 'order_status', '3'); ?> >Không copy</option>
                                    <option value="4" <?php _selected($filter, 'order_status', '4'); ?> >Không hoàn tất</option>
                                </select>
                                <?php showError($errors, 'order_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email</strong>
                                <span class="help">Nhập Email</span>
                            </td>
                            <td>
                                <input type="text" id="order_email" value="<?php _val($filter, 'order_email'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_email'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Điện Thoại</strong>
                                <span class="help">Nhập Điện Thoại</span>
                            </td>
                            <td>
                                <input type="text" id="order_phone" value="<?php _val($filter, 'order_phone'); ?>" size="50" maxlength="30"/>
                                <?php showError($errors, 'order_phone'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa Chỉ</strong>
                                <span class="help">Nhập Địa Chỉ Giao Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_address" value="<?php _val($filter, 'order_address'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_address'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ghi Chú</strong>
                                <span class="help">Nội dung ghi ch</span>
                            </td>
                            <td>
                                <textarea id="order_note" cols="100" rows="10"><?php _val($filter, 'order_note'); ?></textarea>
                                <?php showError($errors, 'order_note'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('order_add'); ?>
            <?php $this->security->set_action('customer_get_by_id'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Thêm Đơn Hàng Mới');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Menu
        jsAdmin.changeMenu('customer/customer_lists');
        
        // Check Customer
        $('#order_customer_username').change(function ()
        {
            var data = {
                customer_username : $(this).val(),
                customer_get_by_id : $('#customer_get_by_id').val()
            };
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/customer_get_by_id', function (result)
            {
                if (trim(result) == 'ERROR_TOKEN'){
                    jAlert('Lỗi Token, Vui lòng đăng nhập lại để tiếp tục thao tác', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_AUTH'){
                    jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_NOT_FOUND'){
                    jAlert('Khách hàng bạn chọn không tìm thấy', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_CUS_BAND'){
                    jAlert('Khách hàng bạn chọn đã bị khóa không cho mua hàng', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_BAD_REQUEST'){
                    jAlert('Lỗi xử lý dữ liệu, có thể bạn gửi thông tin bị sai', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else{
                    result = $.parseJSON(result);
                    $('#order_email').val(result.customer_email);
                    $('#order_phone').val(result.customer_phone);
                    $('#order_address').val(result.customer_address);
                    $('#order_fullname').val(result.customer_fullname);
                }
            });
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
                order_customer_username   : trim($('#order_customer_username').val()),
                order_title   : trim($('#order_title').val()),
                order_status      : trim($('#order_status').val()),
                order_email      : trim($('#order_email').val()),
                order_phone      : trim($('#order_phone').val()),
                order_fullname   : trim($('#order_fullname').val()),
                order_note   : trim($('#order_note').val()),
                order_address    : trim($('#order_address').val()),
                order_add        : $('#order_add').val()
            };
                
            // Validate Username
            if (!is_username(data.order_customer_username)){
                jAlert('Tên đăng nhập dài từ 5 đến 15 ký tự', 'Lỗi dữ liệu');
                return false;
            }
            
            // Address
            if (isEmpty(data.order_title)){
                jAlert('Tiêu đề đơn hàng không được để trống', 'Lỗi dữ liệu');
                return false;
            }
            
            // Email
            if (!isEmail(data.order_email)){
                jAlert('Email không đúng định dạng', 'Lỗi dữ liệu');
                return false;
            }
            
            // Address
            if (isEmpty(data.order_address)){
                jAlert('Địa chỉ không thể thiếu được, hiểu hem? không có sao giao hàng ', 'Lỗi dữ liệu');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/order_add', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (is_number(result) && parseInt(result) > 0){
                    jsAdmin.redirect('customer/order_edit?order_id='+result);
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

