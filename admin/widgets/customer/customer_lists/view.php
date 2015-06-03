<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/customer_lists">Khách Hàng</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Khách Hàng (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('customer/customer_add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="3%" class="center"><?php echo $this->pagination->getSortLink('#', 'customer_id'); ?></td>
                        <td width="10%" class="left">
                            Mã khách hàng
                        </td>
                        <td width="11%" class="left">
                            Tên Khách Hàng
                        </td>
                        <td width="12%" class="left">
                            Email
                        </td>
                        <td  width="10%" class="left">
                            Điện Thoại
                        </td>
                        <td  width="20%" class="left">
                            Địa Chỉ
                        </td>
                        <td  width="5%" class="center">
                            <?php echo $this->pagination->getSortLink('Số Đơn', 'page_id'); ?>
                        </td>
                        <td  width="10%" class="center">
                            Nhóm
                        </td>
                        <td  width="10%" class="left">
                            Tình Trạng
                        </td>
                        <td width="9%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="left"><input type="text" id="customer_username" style="width:90%;" value="<?php echo $filter['customer_username']; ?>"/></td>
                        <td class="left"><input type="text" id="customer_fullname" style="width:90%;;" value="<?php echo $filter['customer_fullname']; ?>"/></td>
                        <td class="left"><input type="text" id="customer_email" style="width:90%;;" value="<?php echo $filter['customer_email']; ?>"/></td>
                        <td class="left"><input type="text" id="customer_phone" style="width:90%;;" value="<?php echo $filter['customer_phone']; ?>"/></td>
                        <td class="left"><input type="text" id="customer_address" style="width:90%;;" value="<?php echo $filter['customer_address']; ?>"/></td>
                        <td></td>
                        <td class="center">
                            <select id="customer_group">
                                <option value=""></option>
                                <option value="0" <?php _selected($filter, 'customer_group', '0'); ?>>Cá Nhận</option>
                                <option value="1" <?php _selected($filter, 'customer_group', '1'); ?>>Công Ty</option>
                            </select>
                        </td>
                        <td class="center">
                            <select id="customer_status">
                                <option value=""></option>
                                <option value="0" <?php _selected($filter, 'customer_status', '0'); ?>>Khóa</option>
                                <option value="1" <?php _selected($filter, 'customer_status', '1'); ?>>Mở</option>
                            </select>
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('page/lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <input type="checkbox" name="selected" value="<?php echo $item['customer_id']; ?>"/>
                        </td>
                        <td class="left"><?php echo $item['customer_username']; ?></td>
                        <td class="left"><?php echo $item['customer_fullname']; ?></td>
                        <td class="left"><?php echo $item['customer_email']; ?></td>
                        <td class="left"><?php echo $item['customer_phone']; ?></td>
                        <td class="left"><?php echo $item['customer_address']; ?></td>
                        <td class="center"><?php echo $item['customer_total_order']; ?></td>
                        <td class="center">
                            <select class="quick-edit" data-field="customer_group" data-id="<?php echo $item['customer_id']; ?>">
                                <option value="0">Cá Nhân</option>
                                <option value="1" <?php if ($item['customer_group'] == '1') echo 'selected'; ?>>Công Ty</option>
                            </select>
                        </td>
                        <td class="center">
                            <select class="quick-edit" data-field="customer_status" data-id="<?php echo $item['customer_id']; ?>">
                                <option value="1">Mở</option>
                                <option value="0" <?php if ($item['customer_status'] == '0') echo 'selected'; ?>>Khóa</option>
                            </select>
                        </td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                                <a title="Sửa" idval="<?php echo $item['customer_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <a title="Xóa" idval="<?php echo $item['customer_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('customer_delete'); ?>
            <?php $this->security->set_action('customer_quick_edit'); ?>
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
        jsAdmin.changeMenu('customer/customer_lists');
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_customer(list_id);
        });
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_customer($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_customer(list_id)
        {
            if (list_id)
            {
                list_id = list_id.replace(/\s+/g, ' ');
                        
                if (list_id.split(' ').length > 10){
                    jAlert('Bạn chỉ xóa tối đa 10 customer', 'Lỗi số lượng');
                    return false;
                }
                
                jConfirm('Bạn có chắc muốn xóa những trang này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            customer_delete : $('#customer_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'customer/customer_delete', function (result)
                        {
                            result = trim(result);
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else if (result == '103'){
                                jAlert('Bạn chỉ được xóa tối đa 10 khách hàng cùng lúc', 'Lỗi số lượng');
                            }
                            else if (result == '102'){
                                jAlert('Xóa thành công, tuy nhiên vẫn còn một số khách hàng không xóa được vì vẫn còn danh sách đơn hàng', 'Thành công 50%');
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
        
        // Edit Click Action
        $('.edit-click').click(function(){
            jsAdmin.redirect('customer/customer_edit?customer_id='+$(this).attr('idval'));
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
        $('#customer_id, #customer_title, #customer_fullname, #customer_email, #customer_phone, #customer_address').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#customer_id,#customer_username,#customer_fullname,#limit,#customer_email,#customer_phone,#customer_address,#customer_group,#customer_status').change(function(){
                filter();
        });
        
        // Quick Edit
        $('.quick-edit').change(function()
        {
            var data = {
                id : $(this).attr('data-id'),
                field : $(this).attr('data-field'),
                value : $(this).val(),
                customer_quick_edit : $('#customer_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('customer_group', 'customer_status'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/customer_quick_edit', function (result)
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
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        customer_id         : $('#customer_id').val(),
                        customer_username   : $('#customer_username').val(),
                        customer_fullname   : $('#customer_fullname').val(),
                        customer_email      : $('#customer_email').val(),
                        customer_phone      : $('#customer_phone').val(),
                        customer_address    : $('#customer_address').val(),
                        customer_group      : $('#customer_group').val(),
                        customer_status     : $('#customer_status').val(),
                        order_by            : $('#order_by').val(),
                        order_type          : $('#order_type').val(),
                        limit               : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'customer/customer_lists');
        }
    });
</script>