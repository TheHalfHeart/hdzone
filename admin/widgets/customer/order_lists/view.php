<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/customer_lists">Khách Hàng</a>
    <a href="admin.php#customer/order_lists">Đơn Hàng</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Đơn Hàng (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('customer/order_add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="3%" class="center"><?php echo $this->pagination->getSortLink('#', 'order_id'); ?></td>
                        <td width="5%" class="center">
                            ID
                        </td>
                        <td width="15%" class="left">
                            Tên Đăng Nhập
                        </td>
                        <td width="31%" class="left">
                            Tiêu Đề
                        </td>
                        <td width="10%" class="left">
                            Ngày Đặt Hàng
                        </td>
                        <td  width="8%" class="center">
                            Trạng Thái
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="left"><input type="text" id="order_id" style="width:80%;" value="<?php echo $filter['order_id']; ?>"/></td>
                        <td class="left"><input type="text" id="order_customer_username" value="<?php echo $filter['order_customer_username']; ?>"/></td>
                        <td class="left"></td>
                        <td class="left"></td>
                        <td class="center">
                            <select id="order_status">
                                <option value="">----</option>
                                <option value="0" <?php if ((string)$filter['order_status'] === '0') echo 'selected'; ?>>Mới chọn</option>
                                <option value="1" <?php if ($filter['order_status'] == '1') echo 'selected'; ?>>Đã nhận ổ</option>
                                <option value="2" <?php if ($filter['order_status'] == '2') echo 'selected'; ?>>Đã trả ổ</option>
                                <option value="3" <?php if ($filter['order_status'] == '3') echo 'selected'; ?>>Không copy</option>
                                <option value="4" <?php if ($filter['order_status'] == '4') echo 'selected'; ?>>Không hoàn tất</option>
                            </select>
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('customer/order_lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <input type="checkbox" name="selected" value="<?php echo $item['order_id']; ?>"/>
                        </td>
                        <td class="center"><?php echo $item['order_id']; ?></td>
                        <td class="left"><?php echo $item['order_customer_username']; ?></td>
                        <td class="left"><?php echo $item['order_title']; ?></td>
                        <td class="left"><?php echo date('d/m/Y', $item['order_add_date_time_int']); ?></td>
                        <td class="center">
                            <select class="quick-edit" data-id="<?php echo $item['order_id']; ?>" data-field="order_status">
                                <option value="0">Mới chọn</option>
                                <option value="1" <?php if ($item['order_status'] == '1') echo 'selected'; ?>>Đã nhận ổ</option>
                                <option value="2" <?php if ($item['order_status'] == '2') echo 'selected'; ?>>Đã trả ổ</option>
                                <option value="3" <?php if ($item['order_status'] == '3') echo 'selected'; ?>>Không copy</option>
                                <option value="4" <?php if ($item['order_status'] == '4') echo 'selected'; ?>>Không hoàn tất</option>
                            </select>
                        </td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                                <a title="Sửa" idval="<?php echo $item['order_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <a title="Xóa" idval="<?php echo $item['order_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('order_delete'); ?>
            <?php $this->security->set_action('order_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
        <?php echo $this->pagination->create(); ?>
    </div>
</div>

<script language="javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Danh Sách Trang Web');
        
        // Link Back
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Menu
        jsAdmin.changeMenu('customer/order_lists');
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_order(list_id);
        });
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_order($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_order(list_id)
        {
            if (list_id)
            {
                list_id = list_id.replace(/\s+/g, ' ');
                        
                if (list_id.split(' ').length > 10){
                    jAlert('Bạn chỉ xóa tối đa 10 order', 'Lỗi số lượng');
                    return false;
                }
                
                jConfirm('Bạn có chắc muốn xóa những trang này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            order_delete : $('#order_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'customer/order_delete', function (result)
                        {
                            result = trim(result);
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else if (result == '102'){
                                jAlert('Bạn chỉ xóa tối đa 10 trang', 'Lỗi số lượng');
                            }
                            else{
                                jAlert('Xóa thất bại', 'Thất bại');
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
        
        // Quick Edit
        $('.quick-edit').change(function()
        {
            var data = {
                id : $(this).attr('data-id'),
                field : $(this).attr('data-field'),
                value : $(this).val(),
                order_quick_edit : $('#order_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('order_status'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/order_quick_edit', function (result)
            {
                result = trim(result);
                if (result == 'ERROR_TOKEN'){
                    jAlert('Sai token, vui lòng đăng nhập lại', 'Sai token');
                    return false;
                }
                else if (result == 'ERROR_AUTH'){
                    jAlert('Bạn không có đủ quyền để thực hiện thao tác này', 'Lỗi phân quyền');
                    return false;
                }else if (result == 'SUCCESS'){
                    filter();
                }
                if (result == 'ERROR_BAD_REQUEST'){
                    jAlert('Lỗi hệ thống, vui lòng liên hệ quản trị viên', 'Lỗi hệ thống');
                    return false;
                }
            });
        });
        
        // Edit Click Action
        $('.edit-click').click(function(){
            jsAdmin.redirect('customer/order_edit?order_id='+$(this).attr('idval'));
            return false;
        });
        
        $('.lang-wrapper-field span').click(function(){
            if ($(this).hasClass('active')){
                return false;
            }
            $('.lang-wrapper-field span').removeClass('active');
            $(this).addClass('active');
            filter();   
        });
        
        // Filter Enter 
        $('#order_id, #order_customer_username').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#order_id, #order_status, #order_customer_username, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        order_id     : $('#order_id').val(),
                        order_status : $('#order_status').val(),
                        order_customer_username : $('#order_customer_username').val(),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'customer/order_lists');
        }
    });
</script>