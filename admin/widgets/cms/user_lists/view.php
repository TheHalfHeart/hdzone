<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/user_lists">Thành Viên</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thành Viên (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('cms/user_add');">Thêm Mới</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="10%" style="text-align: center;">
                            <?php echo $this->pagination->getSortLink('ID', 'user_id'); ?>
                        </td>
                        <td width="25%" class="left">
                            Tài Khoản
                        </td>
                        <td  width="24%" class="left">
                            Email
                        </td>
                        <td  width="10%" class="left">
                            <?php echo $this->pagination->getSortLink('Ngày Đăng Ký', 'user_add_date_time_int'); ?>
                        </td>
                        <td  width="11%" class="left">
                            Trạng Thái
                        </td>
                        <td  width="10%" class="left">
                            Cấp Độ
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="user_id" value="<?php echo $filter['user_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input style="width: 150px;" type="text" id="user_username" value="<?php echo  $filter['user_username']; ?>" /></td>
                        <td><input style="width: 200px;" type="text" id="user_email" value="<?php echo  $filter['user_email']; ?>" /></td>
                        <td class="center">
                            <input type="text" class="date" id="user_add_date" value="<?php echo $filter['user_add_date']; ?>" style="text-align: center"/>
                        </td>
                        <td class="center">
                            <select id="user_status" style="width: 100%;">
                                <option value=""></option>
                                <option value="0" <?php _selected($filter, 'user_status', '0'); ?>>Khóa</option>
                                <option value="1" <?php _selected($filter, 'user_status', '1'); ?>>Bình Thường</option>
                            </select>
                        </td>
                        <td align="right">
                            <select id="user_level">
                                <option value=""></option>
                                <?php foreach ($level as $key => $val){ ?>
                                <option value="<?php echo $key; ?>" <?php echo ($filter['user_level'] == $key) ? ' selected ' : ''; ?>><?php echo $val; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('cms/user_lists'); return false;">Làm Lại</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['user_id']; ?></td>
                        <td class="left">
                            <?php echo $item['user_username']; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="left">
                            <?php echo $item['user_email']; ?>
                        </td>
                        <td class="center">
                            <?php echo date('d-m-Y', $item['user_add_date_time_int']); ?>
                        </td>
                        <td class="center">
                            <?php if ($item['user_status'] == '1'){ ?>
                            <span class="color-icons accept_co"></span>
                            <?php } else { ?>
                            <span class="color-icons lock_co"></span>
                            <?php } ?>
                        </td>
                        <td class="left"><?php echo $this->auth->getLevelName($item['user_level']); ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item) && can_edit_user($item['user_id'], $item['user_level'], $item['user_is_root'])){ ?>
                                <a title="Sửa" idval="<?php echo $item['user_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <?php if ($this->auth->isRoot() && $this->auth->getItem('user_id') != $item['user_id']){ ?>
                                    <a title="Xóa" idval="<?php echo $item['user_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('user_delete'); ?>
            <?php $this->security->set_action('user_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
        <?php echo $this->pagination->create(); ?>
    </div>
</div>

<script language="javascript">
    $(document).ready(function()
    {
        $('.date').datepicker({
                dateFormat: 'dd-mm-yy'
        });
        
        // Menu
        jsAdmin.changeMenu('cms/user_lists');
        
        // Title
        jsAdmin.changeTitle('Danh Sách Thành Viên');
        
        // Link Back
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_page($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_page(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa thành viên này ?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            user_delete : $('#user_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'cms/user_delete', function (result)
                        {
                            result = trim(result);
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else{
                                jAlert('Xóa thất bại', 'Thất bại');
                            }
                        });
                    }
                });
            }
            return false;
        }
        
        // Edit Click Action
        $('.edit-click').click(function(){
            jsAdmin.redirect('cms/user_edit?user_id='+$(this).attr('idval'));
            return false;
        });
        
        // Filter Enter 
        $('#user_id, #user_username,#user_add_date, #user_email').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#user_id, #user_username, #user_email,#user_add_date, #user_status, #user_level, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        user_id     : $('#user_id').val(),
                        user_username  : $('#user_username').val(),
                        user_email  : $('#user_email').val(),
                        user_status : $('#user_status').val(),
                        user_level  : $('#user_level').val(),
                        user_add_date  : $('#user_add_date').val(),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'cms/user_lists');
        }
    });
</script>