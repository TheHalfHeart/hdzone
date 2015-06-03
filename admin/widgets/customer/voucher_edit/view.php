<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#customer/voucher_lists">Voucher</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Voucher</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <?php if ($customer){ ?>
            <a href="#tab-customer">Khách hàng</a>
            <?php } ?>
            <?php if ($history){ ?>
            <a href="#tab-history">Lịch sử</a>
            <?php } ?>
            <a href="#tab-other">Khác</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Serie <span class="required">(*)</span></strong>
                                <span class="help">Nếu để trống hệ thống sẽ sinh tự động</span>
                            </td>
                            <td>
                                <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" id="voucher_code" value="<?php _val($filter, 'voucher_code'); ?>" size="100" maxlength="255" readonly style="background: #CACACA; color:blue; "/>
                                <?php showError($errors, 'voucher_code'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mệnh giá <span class="required">(*)</span></strong>
                                <span class="help">Mệnh giá của thẻ</span>
                            </td>
                            <td>
                                <input type="text" id="voucher_price" value="<?php echo number_format($filter['voucher_price']); ?>" size="100" maxlength="255" disabled/>
                                <?php showError($errors, 'voucher_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số tiền còn</strong>
                                <span class="help">Số tiền còn lại của thẻ</span>
                            </td>
                            <td>
                                <input type="text" id="voucher_price_current" value="<?php echo number_format($filter['voucher_price_current']); ?>" size="100" maxlength="255" disabled/>
                                <?php showError($errors, 'voucher_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mã khách hàng</strong>
                                <span class="help">Nhập mã khách hàng</span>
                            </td>
                            <td>
                                <input type="text" id="voucher_customer_id" value="<?php _val($filter, 'voucher_customer_id'); ?>" size="100" maxlength="255" placeholder="Chỉ nhập số"/>
                                <?php showError($errors, 'voucher_customer_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày kích hoạt</strong>
                                <span class="help">Ngày có giá trị</span>
                            </td>
                            <td>
                                <input type="text" id="voucher_active_date"  value="<?php echo (!empty($filter['voucher_active_date_int'])) ? date('d-m-Y', $filter['voucher_active_date_int']) : ''; ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'voucher_active_date'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày hết hạn</strong>
                                <span class="help">Ngày hết hạn thẻ</span>
                            </td>
                            <td>
                                <input type="text" id="voucher_end_date"  value="<?php echo (!empty($filter['voucher_end_date_int'])) ? date('d-m-Y', $filter['voucher_end_date_int']) : ''; ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'voucher_end_date'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng thái</strong>
                                <span class="help">Trạng thái của thẻ</span>
                            </td>
                            <td>
                                <select id="voucher_status">
                                    <option value="0">Chưa kích hoạt</option>
                                    <option value="1" <?php _selected($filter, 'voucher_status', '1'); ?>>Đã kích hoạt</option>
                                </select>
                                <?php showError($errors, 'voucher_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ghi chú</strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <textarea id="voucher_description" cols="96" rows="5"><?php _val($filter, 'voucher_description'); ?></textarea>
                                <?php showError($errors, 'voucher_description'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if ($customer){ ?>
            <div id="tab-customer">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>ID</strong>
                            </td>
                            <td>
                                <?php echo $customer['customer_id']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mã khách hàng</strong>
                            </td>
                            <td>
                                <?php echo $customer['customer_username']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email</strong>
                            </td>
                            <td>
                                <?php echo $customer['customer_email']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Điện thoại</strong>
                            </td>
                            <td>
                                <?php echo $customer['customer_phone']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa chỉ</strong>
                            </td>
                            <td>
                                <?php echo $customer['customer_address']; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
            <?php if ($history){ ?>
            <div id="tab-customer">
                <div class="htabs" id="tabs-2">
                    <a href="#tab-history-copy">Copy</a>
                </div>
                <div id="tab-history-copy">
                    <table class="list">
                        <thead>
                            <tr>
                                <td width="15%" class="left">ID Khách Hàng</td>
                                <td width="15%" class="left">ID Đơn hàng</td>
                                <td width="15%" class="left">Giá ban đầu</td>
                                <td width="15%" class="left">Giá còn lại</td>
                                <td width="15%" class="left">Người thực hiện</td>
                                <td width="20%" class="left">Thời gian</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $key => $item){ ?>
                            <?php if ($item['history_type'] == '1'){ ?>
                            <tr>
                                <td class="left"><?php echo $item['history_customer_id']; ?></td>
                                <td class="left"><?php echo $item['history_order_id']; ?></td>
                                <td class="left"><?php echo $item['history_voucher_price_before']; ?></td>
                                <td class="left"><?php echo $item['history_voucher_price_after']; ?></td>
                                <td class="left"><?php echo $item['history_add_user_username']; ?></td>
                                <td class="left"><?php echo date('d-m-Y H:i:s', $item['history_add_date_time_int']); ?></td>
                            </tr>
                            <?php unset($history[$key]); } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
            <div id="tab-other">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>ID</strong>
                                </td>
                                <td>
                                    <strong><?php echo $filter['voucher_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['voucher_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['voucher_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['voucher_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['voucher_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['voucher_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('voucher_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-customer-voucher-editting" value="customer-voucher-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Sửa Voucher');
         // Timer
        $('#voucher_active_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });

        // Timer
        $('#voucher_end_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });
        
        $('#tabs-2 a').tabs();
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('customer/voucher_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'customer/voucher_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            
            var data = 
            {
                voucher_code        : trim($('#voucher_code').val()),
                voucher_id          : '<?php echo $filter['voucher_id']; ?>',
                voucher_price       : trim($('#voucher_price').val()),
                voucher_customer_id : trim($('#voucher_customer_id').val()),
                voucher_active_date : trim($('#voucher_active_date').val()),
                voucher_end_date    : trim($('#voucher_end_date').val()),
                voucher_status      : trim($('#voucher_status').val()),
                voucher_description : trim($('#voucher_description').val()),
                voucher_edit         : $('#voucher_edit').val()
            };
            
            // Validate data
            if (isEmpty(data.voucher_code)){
                jAlert('Bạn chưa nhập số serie', 'Lỗi dữ liệu');
                return false;
            }
            
            // Validate data
            if (isEmpty(data.voucher_price)){
                jAlert('Bạn chưa nhập Mệnh giá', 'Lỗi dữ liệu');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/voucher_edit?voucher_id=<?php echo $filter['voucher_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('customer/voucher_edit?voucher_id=<?php echo $filter['voucher_id']; ?>');
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
            if (!isEmpty($('#interval-customer-voucher-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {voucher_id:<?php echo $filter['voucher_id']; ?>}, 'customer/voucher_editting');
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
                    hash_back = 'customer/voucher_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

