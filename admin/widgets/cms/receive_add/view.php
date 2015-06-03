<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/receive_lists">Phiếu Nhận Copy</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Phiếu Nhận Copy</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-money">Thanh Toán</a>
            <a href="#tab-device">Thiết bị</a>
            <a href="#tab-customer">Khách Hàng</a>
            <a href="#tab-link">Liên Kết</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Mã đơn<span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="text" id="receive_code" value="<?php echo date('\H\D\Z\O\N\E/Y/m/XXXXX'); ?>" size="100" maxlength="255" readonly style="background: #CACACA; color:blue;"/>
                                <?php showError($errors, 'receive_code'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng thái</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <select id="receive_status">
                                    <option value="0">Mới nhận</option>
                                    <option value="1" <?php if (isset($filter['receive_status']) && $filter['receive_status'] == 1) echo 'selected'; ?>>Đang copy</option>
                                    <option value="1" <?php if (isset($filter['receive_status']) && $filter['receive_status'] == 2) echo 'selected'; ?>>Đã copy xong</option>
                                    <option value="1" <?php if (isset($filter['receive_status']) && $filter['receive_status'] == 3) echo 'selected'; ?>>Đã gọi báo khách</option>
                                    <option value="1" <?php if (isset($filter['receive_status']) && $filter['receive_status'] == 4) echo 'selected'; ?>>Đã trả ổ</option>
                                </select>
                                <?php showError($errors, 'receive_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Thiết bị USB</strong>
                            </td>
                            <td>
                                <select id="receive_is_usb">
                                    <option value="0">Không phải</option>
                                    <option value="1" <?php if (isset($filter['receive_is_usb']) && $filter['receive_is_usb'] == '1') echo 'selected'; ?>>Phải</option>
                                </select>
                                <?php showError($errors, 'receive_is_usb'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Dung lượng dự tính</strong>
                            </td>
                            <td>
                                <input type="text" id="receive_diskspace_estimated" value="<?php _val($filter, 'receive_diskspace_estimated'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'receive_diskspace_estimated'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Dung lượng đã dùng</strong>
                            </td>
                            <td>
                                <input type="text" id="receive_diskspace_used" value="<?php _val($filter, 'receive_diskspace_used'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'receive_diskspace_used'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày - Giờ trả dự tính</strong>
                            </td>
                            <td>
                                <input type="text" id="receive_ngay_tra_int" value="" placeholder="Ngày" size="50" maxlength="255"/> <input type="text" id="receive_gio_tra_int" value="" size="50" maxlength="255" placeholder="Giờ"/>
                                <?php showError($errors, 'receive_ngay_gio_tra_int'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô tả</strong>
                            </td>
                            <td>
                                <textarea id="receive_content" cols="96" rows="5"><?php _val($filter, 'receive_content'); ?></textarea>
                                <?php showError($errors, 'receive_content'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-money">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Phương thức thanh toán</strong>
                            </td>
                            <td>
                                <select id="receive_type">
                                    <option value="0">Tiền Mặt</option>
                                    <option value="1" <?php if (isset($filter['receive_is_usb']) && $filter['receive_is_usb'] == '1') echo 'selected'; ?>>Thẻ HDZONE</option>
                                    <option value="1" <?php if (isset($filter['receive_is_usb']) && $filter['receive_is_usb'] == '2') echo 'selected'; ?>>Tiền mặt + thẻ HDZONE</option>
                                    <option value="1" <?php if (isset($filter['receive_is_usb']) && $filter['receive_is_usb'] == '3') echo 'selected'; ?>>Thanh toán sau</option>
                                </select>
                                <?php showError($errors, 'receive_type'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giá tiền<span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="text" id="receive_price" value="<?php _val($filter, 'receive_price'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'receive_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số tiền giảm giá</strong>
                            </td>
                            <td>
                                <input type="text" id="receive_price_discount" value="<?php _val($filter, 'receive_price_discount'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'receive_price_discount'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-device">
                <div id="tab-history-copy">
                    <table class="list">
                        <thead>
                            <tr>
                                <td width="15%" class="left">Tên thiết bị</td>
                                <td width="15%" class="left">Serie</td>
                                <td width="15%" class="left">Bảo hành đến</td>
                                <td width="50%" class="left">Thông tin</td>
                                <td width="5%" class="left">Tùy chọn</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left"><a class="button" id="click-save">Thêm</a></td>
                                <td class="left"></td>
                            </tr>
                            <tr>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left"><input type='text' style='width: 93%' /></td>
                                <td class="left">Còn bảo hành</td>
                                <td class="left">
                                    <a title="Xóa" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tab-customer">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>TÌM KIẾM KHÁCH HÀNG</strong>
                            </td>
                            <td>
                                <input type="text" id="search_customer_email" placeholder="Email" value="" size="47" maxlength="255"/>
                                <input type="text" id="search_customer_username" placeholder="Mã khách hàng" value="" size="46" maxlength="255"/> <br/>
                                <input type="text" id="search_customer_id" placeholder="ID khách hàng" value="" size="47" maxlength="255" style="margin-top: 5px"/>
                                <input type="text" id="search_customer_phone" placeholder="Điện thoại" value="" size="31" maxlength="255"/> 
                                <a class="button" id="click-search-cus" style="margin-top: 5px;">Tìm kiếm</a> <br/>
                                <?php $this->security->set_action('customer_get_by_id'); ?>
                                <script language="javascript">
                                    $('#click-search-cus').click(function(){
                                        var data = {
                                            customer_email      : $('#search_customer_email').val(),
                                            customer_username   : $('#search_customer_username').val(),
                                            customer_id         : $('#search_customer_id').val(),
                                            customer_phone      : $('#search_customer_phone').val(),
                                            customer_get_by_id  : $('#customer_get_by_id').val()
                                        };
                                        
                                        jsAdmin.sendAjax('post', 'json', data, 'customer/customer_get_by_id', function(result){
                                            if (result.hasOwnProperty('customer_id')){
                                                $('#receive_fullname').val(result.customer_fullname);
                                                $('#receive_phone').val(result.customer_phone);
                                                $('#receive_address').val(result.customer_address);
                                            }
                                        });
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tên khách hàng<span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="text" id="receive_fullname" value="<?php if (isset($customer['customer_fullname'])){ echo $customer['customer_fullname'];}else {_val($filter, 'receive_fullname');} ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'receive_fullname'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số điện thoại<span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <input type="text" id="receive_phone" value="<?php if (isset($customer['customer_phone'])){ echo $customer['customer_phone'];}else {_val($filter, 'receive_phone');} ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'receive_phone'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa chỉ</strong>
                            </td>
                            <td>
                                <input type="text" id="receive_address" value="<?php if (isset($customer['customer_address'])){ echo $customer['customer_address'];}else {_val($filter, 'receive_address');} ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'receive_address'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-link">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Showroom</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <select id="receive_showroom_id">
                                    <?php foreach ($showroom as $item){ ?>
                                    <option value="<?php echo $item['showroom_id']; ?>"><?php echo $item['showroom_title']; ?></option>
                                    <?php } ?>
                                </select>
                                <?php showError($errors, 'receive_showroom_id'); ?>
                            </td>
                        </tr>
                        <?php if ($order){ ?>
                        <tr>
                            <td>
                                <strong>Đơn hàng</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <a href="#" onclick="return jsAdmin.redirect('customer/order_edit?order_id=<?php echo $order['order_id']; ?>');">Xem đơn hàng</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('receive_add'); ?>
        </form>
    </div>
</div>

<script language="javscript" type="text/javascript">
    
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Thêm Phiếu Nhận Copy Mới');
         // Timer
        $('#receive_ngay_tra_int').datepicker({
                    dateFormat: 'dd-mm-yy'
        });
        $('#receive_gio_tra_int').timepicker({
                    dateFormat: 'HH:i'
        });
        // Menu
        jsAdmin.changeMenu('cms/receive_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'cms/receive_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                receive_title       : trim($('#receive_title').val()),
                receive_address        : trim($('#receive_address').val()),
                receive_status        : trim($('#receive_status').val()),
                receive_order        : trim($('#receive_order').val()),
                receive_description : trim($('#receive_description').val()),
                receive_add         : $('#receive_add').val()
            };
            
            // Validate data
            if (isEmpty(data.receive_title)){
                jAlert('Bạn chưa nhập tiêu đề ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (isEmpty(data.receive_address)){
                jAlert('Bạn chưa nhập Địa chỉ', 'Lỗi Code');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'cms/receive_add', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Thêm thành công', 'Thành công', function (){
                        $('#click-back').click();
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
    });    
</script>