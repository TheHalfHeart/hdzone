<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#customer/voucher_lists">Voucher</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Voucher</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
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
                                <input type="text" id="voucher_price" value="<?php _val($filter, 'voucher_price'); ?>" size="100" maxlength="255" placeholder="Đơn vị: VNĐ"/>
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
            <?php $this->security->set_action('voucher_add'); ?>
        </form>
    </div>
</div>

<script language="javscript" type="text/javascript">
    
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Thêm Voucher Mới');
         // Timer
        $('#voucher_active_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });

        // Timer
        $('#voucher_end_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });
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
                voucher_price       : trim($('#voucher_price').val()),
                voucher_customer_id : trim($('#voucher_customer_id').val()),
                voucher_active_date : trim($('#voucher_active_date').val()),
                voucher_end_date    : trim($('#voucher_end_date').val()),
                voucher_status      : trim($('#voucher_status').val()),
                voucher_description : trim($('#voucher_description').val()),
                voucher_add         : $('#voucher_add').val()
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
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/voucher_add', function (result)
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