<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chính</a> ::
    <a href="admin.php#slide/lists">Slider</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Slide (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('slide/add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa Tất Cả</a>
        </div>
    </div>
    <div class="content">
        <?php lang_show_list_page(); ?>
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">#</td>
                        <td width="5%" style="text-align: center;">
                            <?php echo $this->pagination->getSortLink('ID', 'slide_id'); ?>
                        </td>
                        <td width="53%" class="left">
                            Tiêu Đề
                        </td>
                        <td  width="7%" class="center">
                            Hiển Thị
                        </td>
                        <td  width="10%" class="left">
                            Vị Trí
                        </td>
                        <td  width="10%" class="left">
                            Người Đăng
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="slide_id" value="<?php echo $filter['slide_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input style="width: 300px;" type="text" id="slide_title" value="<?php echo  $filter[lang_field('slide_title')]; ?>" /></td>
                        <td class="center">
                            <select id="slide_status" style="width: 90px;">
                                <option value=""></option>
                                <option value="1" <?php _selected($filter, 'slide_status', '1'); ?>>Hiển Thị</option>
                                <option value="2" <?php _selected($filter, 'slide_status', '2'); ?>>Hẹn Giờ</option>
                                <option value="0" <?php _selected($filter, 'slide_status', '0'); ?>>Ẩn</option>
                            </select>
                        </td>
                        <td  width="10%" class="left">
                            <select id="slide_position" style="width: 100%;">
                                <option value=""></option>
                                <?php foreach (slide_position() as $key => $val){ ?>
                                <option value="<?php echo $key; ?>" <?php _selected($filter, 'slide_position', (string)$key); ?>><?php echo $val; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('slide/lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <?php if (!_is_editting($item)){ ?>
                                <input type="checkbox" name="selected" value="<?php echo $item['slide_id']; ?>"/>
                            <?php } ?>
                        </td>
                        <td class="center"><?php echo $item['slide_id']; ?></td>
                        <td class="left">
                            <?php echo $item[lang_field('slide_title')]; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="center">
                            <?php showStatus($item['slide_timer_date_time_int']); ?>
                        </td>
                        <td class="left"><?php echo slide_name($item['slide_position']); ?></td>
                        <td class="left"><?php echo $item['slide_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                                <a title="Sửa" idval="<?php echo $item['slide_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <a title="Xóa" idval="<?php echo $item['slide_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('slide_delete'); ?>
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
        jsAdmin.changeTitle('Danh Sách Slide');
        
        // Link Back
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Menu
        jsAdmin.changeMenu('slide/lists');
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_slide(list_id);
        });
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_slide($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_slide(list_id)
        {
            if (list_id)
            {
                list_id = list_id.replace(/\s+/g, ' ');
                        
                if (list_id.split(' ').length > 10){
                    jAlert('Bạn chỉ xóa tối đa 10 slide', 'Lỗi số lượng');
                    return false;
                }
                
                jConfirm('Bạn có chắc muốn xóa những bài này và tất cả các files liên quan?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            slide_delete : $('#slide_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'slide/delete', function (result)
                        {
                            result = trim(result);
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else if (result == '102'){
                                jAlert('Bạn chỉ xóa tối đa 10 slide', 'Lỗi số lượng');
                            }
                            else{
                                jAlert('Xóa thất bại', 'Thất bại');
                            }
                        });
                    }
                });
            }
            else{
                jAlert('Vui lòng chọn những bài cần xóa', 'Thông báo');
            }
            return false;
        }
        
        // Edit Click Action
        $('.edit-click').click(function(){
            jsAdmin.redirect('slide/edit?slide_id='+$(this).attr('idval'));
            return false;
        });
        
        // Filter Enter 
        $('#slide_id, #slide_title').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#slide_id, #slide_status,#slide_title, #slide_position, #limit').change(function(){
                filter();
        });
        
        $('.lang-wrapper-field span').click(function(){
            if ($(this).hasClass('active')){
                return false;
            }
            $('.lang-wrapper-field span').removeClass('active');
            $(this).addClass('active');
            filter();   
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        slide_id        : $('#slide_id').val(),
                        slide_position  : $('#slide_position').val(),
                        <?php echo lang_field('slide_title'); ?>     : $('#slide_title').val(),
                        lang        : $('.lang-wrapper-field span.active').attr('langcode'),
                        slide_status    : $('#slide_status').val(),
                        order_by        : $('#order_by').val(),
                        order_type      : $('#order_type').val(),
                        limit           : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'slide/lists');
        }
    });
</script>