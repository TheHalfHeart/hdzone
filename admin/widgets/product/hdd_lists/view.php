<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/hdd_lists">Ổ Đĩa</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Ổ Đĩa</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('product/hdd_add');">Thêm Mới</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">
                            ID
                        </td>
                        <td width="30%" class="left">
                            Tiêu Đề
                        </td>
                        <td  width="15%" class="center">
                            Code
                        </td>
                        <td  width="10%" class="center">
                            Thứ tự
                        </td>
                        <td  width="10%" class="center">
                            Trạng thái
                        </td>
                        <td  width="10%" class="center">
                            Kích Thước
                        </td>
                        <td  width="10%" class="left">
                            Người Tạo
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['hdd_id']; ?></td>
                        <td class="left"><?php echo $item['hdd_title']; ?></td>
                        <td class="center"><?php echo $item['hdd_code']; ?></td>
                        <td class="center"><?php echo $item['hdd_order']; ?></td>
                        <td class="center"><?php echo ($item['hdd_status'] == 1) ? '<strong style="color:red">Đã đầy</strong>' : 'Còn trống'; ?></td>
                        <td class="center"><?php echo $item['hdd_size']; ?></td>
                        <td class="left"><?php echo $item['hdd_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['hdd_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['hdd_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('hdd_delete'); ?>
            <?php $this->security->set_action('hdd_quick_edit'); ?>
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
        jsAdmin.changeTitle('Danh Sách Ổ Đĩa');
        
        // Menu
        jsAdmin.changeMenu('product/hdd_lists');
        
        $('.delete-click').click(function(){
            return delete_hdd($(this).attr('idval'));
        });
        
        function delete_hdd(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa hddgory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            hdd_delete : $('#hdd_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'product/hdd_delete', function (result)
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
            jsAdmin.redirect('product/hdd_edit?hdd_id='+$(this).attr('idval'));
            return false;
        });
    });
</script>

