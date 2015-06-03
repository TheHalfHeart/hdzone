<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/receive_lists">Phiếu Nhận Copy</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Phiếu Nhận Copy</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('cms/receive_add');">Thêm Mới</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="12%" style="text-align: center;">
                            Số phiếu nhận
                        </td>
                        <td width="10%" class="left">
                            Giờ nhận
                        </td>
                        <td  width="10%" class="left">
                            Giờ trả
                        </td>
                        <td  width="10%" class="left">
                            Phí copy
                        </td>
                        <td  width="14%" class="center">
                            Tên khách hàng
                        </td>
                        <td  width="10%" class="center">
                            Điện thoại
                        </td>
                        <td  width="8%" class="center">
                            Tình trạng
                        </td>
                        <td  width="8%" class="left">
                            HT/Thanh toán
                        </td>
                        <td width="7%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['receive_code']; ?></td>
                        <td class="left"><?php echo $item['receive_add_date_time_int']; ?></td>
                        <td class="left"><?php echo $item['receive_ngay_tra_int']; ?></td>
                        <td class="center"><?php echo $item['receive_price']; ?></td>
                        <td class="center"><?php echo $item['receive_fullname']; ?></td>
                        <td class="center"><?php echo $item['receive_phone']; ?></td>
                        <td class="center"><?php echo ($item['receive_status'] == 0) ? '<strong style="color:red">Ngưng hoạt động</strong>' : 'Hoạt động'; ?></td>
                        <td class="center"><?php echo ($item['receive_type'] == 0) ? '<strong style="color:red">Ngưng hoạt động</strong>' : 'Hoạt động'; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['receive_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['receive_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('receive_delete'); ?>
            <?php $this->security->set_action('receive_quick_edit'); ?>
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
        
        // Title
        jsAdmin.changeTitle('Danh Sách Phiếu Nhận Copy');
        
        // Menu
        jsAdmin.changeMenu('cms/receive_lists');
        
        $('.delete-click').click(function(){
            return delete_receive($(this).attr('idval'));
        });
        
        function delete_receive(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa receivegory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            receive_delete : $('#receive_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'cms/receive_delete', function (result)
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
            jsAdmin.redirect('cms/receive_edit?receive_id='+$(this).attr('idval'));
            return false;
        });
    });
</script>

