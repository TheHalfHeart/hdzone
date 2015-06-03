<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#contact/lists">Liên Hệ</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Liên Hệ (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('contact/add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa Tất Cả</a>
        </div>
    </div>
    <div class="content">
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">#</td>
                        <td width="5%" style="text-align: center;">
                            <?php echo $this->pagination->getSortLink('ID', 'contact_id'); ?>
                        </td>
                        <td width="56%" class="left">
                            <?php echo $this->pagination->getSortLink('Tiêu Đề', 'contact_title_first_char_ascii'); ?>
                        </td>
                        <td  width="7%" class="left">
                            Kiểm Tra
                        </td>
                        <td  width="7%" class="left">
                            Trả Lời
                        </td>
                        <td  width="10%" class="center">
                            Ngày Đăng
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="contact_id" value="<?php echo $filter['contact_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input style="width: 300px;" type="text" id="contact_title" value="<?php echo  $filter['contact_title']; ?>" /></td>
                        <td class="center">
                            <select id="contact_status" style="width: 100%;">
                                <option value=""></option>
                                <option value="0" <?php echo ($filter['contact_status'] === '0') ? ' selected ': ''; ?>>Chưa</option>
                                <option value="1" <?php echo ($filter['contact_status'] === '1') ? ' selected ': ''; ?>>Rồi</option>
                            </select>
                        </td>
                        <td class="center">
                            <select id="contact_answer" style="width: 100%;">
                                <option value=""></option>
                                <option value="0" <?php echo ($filter['contact_answer'] === '0') ? ' selected ': ''; ?>>Chưa</option>
                                <option value="1" <?php echo ($filter['contact_answer'] === '1') ? ' selected ': ''; ?>>Rồi</option>
                            </select>
                        </td>
                        <td class="center">
                            <input type="text" class="date" id="contact_add_date" value="<?php echo $filter['contact_add_date']; ?>" style="text-align: center"/>
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('contact/lists'); return false;">Làm Lại</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <?php if (!_is_editting($item)){ ?>
                                <?php if (!$this->auth->isContributor() || $item['contact_timer_date_time_int'] == timer_private()){ ?>
                                <input type="checkbox" name="selected" value="<?php echo $item['contact_id']; ?>"/>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="center"><?php echo $item['contact_id']; ?></td>
                        <td class="left">
                            <?php echo $item['contact_title']; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="center">
                            <?php if ($item['contact_status'] != '1'){ ?>
                            <a href="javascript:void(0)" class="quick-edit" data-id="<?php echo $item['contact_id']; ?>" data-field="contact_status" data-value="1" title="Thiết lập đã kiểm tra"><span class="color-icons lock_co"></span></a>
                            <?php }else{ ?>
                            <a href="javascript:void(0)" class="quick-edit" title="Thiết lập ẩn"  data-id="<?php echo $item['contact_id']; ?>"  data-field="contact_status" data-value="0" title="Thiết lập chưa kiểm tra"><span class="color-icons accept_co"></span></a>
                            <?php } ?>
                        </td>
                        <td class="center">
                            <?php if (empty($item['contact_answer'])){ ?>
                            <a href="javascript:void(0)" class="quick-edit" data-id="<?php echo $item['contact_id']; ?>" data-field="contact_answer" data-value="1" title="Thiết lập đã trả lời"><span class="color-icons lock_co"></span></a>
                            <?php }else{ ?>
                            <a href="javascript:void(0)" class="quick-edit" title="Thiết lập ẩn"  data-id="<?php echo $item['contact_id']; ?>"  data-field="contact_answer" data-value="0" title="Thiết lập chưa trả lời" ><span class="color-icons accept_co"></span></a>
                            <?php } ?>
                        </td>
                        <td class="center"> <?php echo date('d-m-Y \L\ú\c H:i:s', $item['contact_add_date_time_int']); ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                                <a title="Sửa" idval="<?php echo $item['contact_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <a title="Xóa" idval="<?php echo $item['contact_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('contact_delete'); ?>
            <?php $this->security->set_action('contact_quick_edit'); ?>
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
    
        // Title Page
        jsAdmin.changeTitle('Danh sách liên hệ');
        
        // Menu
        jsAdmin.changeMenu('contact/lists');
        
        // Link Back
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_contact(list_id);
        });
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_contact($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_contact(list_id)
        {
            if (list_id)
            {
                list_id = list_id.replace(/\s+/g, ' ');
                        
                if (list_id.split(' ').length > 10){
                    jAlert('Bạn chỉ xóa tối đa 10 contact', 'Lỗi số lượng');
                    return false;
                }
                
                jConfirm('Bạn có chắc muốn xóa những trang này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            contact_delete : $('#contact_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'contact/delete', function (result)
                        {
                            result = trim(result);
                            if (result == 'ERROR_TOKEN'){
                                jAlert('Sai token, vui lòng đăng nhập lại để thực hiện thao tác', 'Lỗi Token');
                            }
                            else if (result == 'ERROR_AUTH'){
                                jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi quyền');
                            }
                            else if (result == 'ERROR_SUCCESS'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else {
                                jAlert('Thao tác của bạn bị lỗi', 'Lỗi thao tác');
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
            jsAdmin.redirect('contact/edit?contact_id='+$(this).attr('idval'));
            return false;
        });
        
        // Quick Edit
        $('.quick-edit').click(function()
        {
            var obj = this;
            var id      = $(this).attr('data-id');
            var value   = $(this).attr('data-value');
            var field   = $(this).attr('data-field');
            quick_edit(id, field, value, function(){
                if (value == '1'){
                    $(obj).children('span').removeClass('lock_co').addClass('accept_co');
                    $(obj).attr('data-value', '0');
                }
                else{
                    $(obj).children('span').removeClass('accept_co').addClass('lock_co');
                    $(obj).attr('data-value', '1');
                }
            });
        });
        
        function quick_edit(id, field, value, success)
        {
            var data = 
            {
                id : id,
                field : field,
                value : value,
                contact_quick_edit : $('#contact_quick_edit').val()
            };
            
            if (inArray(data.field, new Array('contact_status', 'contact_answer')))
            {
                jsAdmin.sendAjax('post', 'text', data, 'contact/quick_edit', function(result)
                {
                    result = trim(result);
                    if (result == 'Success'){
                        if (success){
                            success();
                        }
                    }
                    else{
                        jAlert('Thao tác thất bại, vui lòng kiểm tra lại thông tin', 'Thất bại');
                    }
                });
            }
        }
        
        // Filter Enter 
        $('#contact_id, #contact_title, #contact_add_date').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#contact_id, #contact_title, #contact_answer, #contact_add_date, #limit, #contact_status').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        contact_id     : $('#contact_id').val(),
                        contact_title  : $('#contact_title').val(),
                        contact_add_date : $('#contact_add_date').val(),
                        contact_status : $('#contact_status').val(),
                        contact_answer : $('#contact_answer').val(),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'contact/lists');
        }
    });
</script>