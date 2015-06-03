<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#customer/voucher_lists">Voucher</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Voucher</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('customer/voucher_add');">Thêm Mới</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">
                            <?php echo $this->pagination->getSortLink('ID', 'voucher_id'); ?>
                        </td>
                        <td width="10%" class="left">
                            <?php echo $this->pagination->getSortLink('Số Serie', 'voucher_code'); ?>
                        </td>
                        <td  width="10%" class="center">
                            <?php echo $this->pagination->getSortLink('Mệnh giá', 'voucher_price'); ?>
                        </td>
                        <td  width="10%" class="center">
                            <?php echo $this->pagination->getSortLink('Số tiền còn', 'voucher_price_current'); ?>
                        </td>
                        <td  width="10%" class="center">
                            <?php echo $this->pagination->getSortLink('Ngày kích hoạt', 'voucher_active_date'); ?>
                        </td>
                        <td  width="10%" class="center">
                            <?php echo $this->pagination->getSortLink('Ngày hết hạn', 'voucher_end_date'); ?>
                        </td>
                        <td width="10%" class="center">
                            Trạng thái
                        </td>
                        <td  width="10%" class="center">
                            Mã Khách hàng
                        </td>
                        <td  width="10%" class="left">
                            Người Tạo
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="left"><input type="text" id="voucher_code" style="width:90%;" value="<?php echo $filter['voucher_code']; ?>"/></td>
                        <td class="left"><input type="text" id="voucher_price" style="width:90%;" value="<?php echo $filter['voucher_price']; ?>"/></td>
                        <td class="left"><input type="text" id="voucher_price_current" style="width:90%;" value="<?php echo $filter['voucher_price_current']; ?>"/></td>
                        <td class="left"><input type="text" id="voucher_active_date" style="width:90%;" value="<?php echo $filter['voucher_active_date']; ?>"/></td>
                        <td class="left"><input type="text" id="voucher_end_date" style="width:90%;" value="<?php echo $filter['voucher_end_date']; ?>"/></td>
                        <td class="center">
                            <select id="voucher_status">
                                <option value=""></option>
                                <option value="0" <?php _selected($filter, 'voucher_status', '0'); ?>>Chưa kích hoạt</option>
                                <option value="1" <?php _selected($filter, 'voucher_status', '1'); ?>>Đã kích hoạt</option>
                            </select>
                        </td>
                        <td class="left"><input type="text" id="customer_username" style="width:90%;" value="<?php echo $filter['customer_username']; ?>"/></td>
                        <td class="left"><input type="text" id="voucher_add_user_username" style="width:90%;" value="<?php echo $filter['voucher_add_user_username']; ?>"/></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('page/lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['voucher_id']; ?></td>
                        <td class="left"><?php echo $item['voucher_code']; ?></td>
                        <td class="center"><?php echo number_format((int)$item['voucher_price']); ?> đ</td>
                        <td class="center"><?php echo number_format((int)$item['voucher_price_current']); ?> đ</td>
                        <td class="center"><?php if (!$item['voucher_end_date_int']){ echo 'Chưa'; } else {echo date('d/m/Y', $item['voucher_active_date_int']);} ?></td>
                        <td class="center">
                            <?php
                                if (!$item['voucher_end_date_int']){ echo 'Chưa'; }
                                else if ($item['voucher_end_date_int'] < strtotime(date('m-d-Y'))){
                                    echo '<strong style="color:red">'.date('d/m/Y', $item['voucher_end_date_int']).'</strong>'; 
                                }
                                else {
                                    echo date('d/m/Y', $item['voucher_end_date_int']); 
                                }
                            ?>
                        </td>
                        <td class="center"><?php echo ($item['voucher_status'] == 1) ? 'Đã kích hoạt' : '<strong style="color:red">Chưa kích hoạt</strong>'; ?></td>
                        <td class="left"><?php echo $item['customer_username']; ?></td>
                        <td class="left"><?php echo $item['voucher_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['voucher_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['voucher_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('voucher_delete'); ?>
            <?php $this->security->set_action('voucher_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
        <?php echo $this->pagination->create(); ?>
    </div>
</div>
<script language="javascript">
    $(document).ready(function()
    {  
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Timer
        $('#voucher_active_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });

        // Timer
        $('#voucher_end_date').datepicker({
                    dateFormat: 'dd-mm-yy'
        });
        
        // Title
        jsAdmin.changeTitle('Danh Sách Voucher');
        
        // Menu
        jsAdmin.changeMenu('customer/voucher_lists');
        
        $('.delete-click').click(function(){
            return delete_voucher($(this).attr('idval'));
        });
        
        function delete_voucher(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa vouchergory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            voucher_delete : $('#voucher_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'customer/voucher_delete', function (result)
                        {
                            result = trim(result);
                            
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    jsAdmin.redirect('<?php echo $link_back; ?>'.hash());
                                });
                            }
                            else if (result == '102'){
                                jAlert('Chuyên mục này vẫn còn bài viết', 'Lỗi còn dữ liệu');
                            }
                            else{
                                jAlert('Xóa thât bại, có thể do mạng yếu hoặc lỗi hệ thống', 'Thất bại');   
                            }
                        });
                    }
                });
            }
            else{
                jAlert('Vui lòng chọn trang cần xóa', 'Thông báo');
            }
            return false;
        }
        
        $('.edit-click').click(function(){
            jsAdmin.redirect('customer/voucher_edit?voucher_id='+$(this).attr('idval'));
            return false;
        });
        
        // Filter Enter 
        $('#voucher_code, #voucher_price, #voucher_price_current, #voucher_active_date, #voucher_end_date, #voucher_status, #customer_username, #voucher_add_user_username').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#voucher_code, #voucher_price, #voucher_price_current, #voucher_active_date, #voucher_end_date, #voucher_status, #customer_username, #voucher_add_user_username, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        voucher_code         : $('#voucher_code').val(),
                        voucher_price       : $('#voucher_price').val(),
                        voucher_price_current   : $('#voucher_price_current').val(),
                        voucher_active_date : $('#voucher_active_date').val(),
                        voucher_end_date    : $('#voucher_end_date').val(),
                        voucher_status      : $('#voucher_status').val(),
                        customer_username       : $('#customer_username').val(),
                        voucher_add_user_username     : $('#voucher_add_user_username').val(),
                        order_by            : $('#order_by').val(),
                        order_type          : $('#order_type').val(),
                        limit               : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'customer/voucher_lists');
        }
        
    });
</script>

