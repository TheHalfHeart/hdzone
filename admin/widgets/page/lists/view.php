<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#page/lists">Trang Web</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Trang Web (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('page/add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa</a>
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
                            <?php echo $this->pagination->getSortLink('ID', 'page_id'); ?>
                        </td>
                        <td width="63%" class="left">
                            <?php echo $this->pagination->getSortLink('Tiêu Đề', lang_field('page_title_first_char_ascii')); ?>
                        </td>
                        <td  width="7%" class="center">
                            Hiển Thị
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
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="page_id" value="<?php echo $filter['page_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input style="width: 300px;" type="text" id="page_title" value="<?php echo  $filter[lang_field('page_title')]; ?>" /></td>
                        <td class="left">
                            <select id="page_status" style="width: 90px;" >
                                <option value=""></option>
                                <option value="1" <?php _selected($filter, 'page_status', '1'); ?>>Hiển Thị</option>
                                <option value="2" <?php _selected($filter, 'page_status', '2'); ?>>Hẹn Giờ</option>
                                <option value="0" <?php _selected($filter, 'page_status', '0'); ?>>Ẩn</option>
                            </select>
                        </td>
                        <td>
                            <!-- Not Author & Contributor -->
                            <?php if (!$this->auth->isContributor() && !$this->auth->isAuthor()){ ?>
                            <input style="width: 100px;" type="text" id="page_add_user_username" value="<?php echo  $filter['page_add_user_username']; ?>" />
                            <?php } ?>
                            <!-- End Not Author & Contributor -->
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('page/lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <?php if (!_is_editting($item)){ ?>
                                <?php if (!$this->auth->isContributor() || $item['page_timer_date_time_int'] == timer_private()){ ?>
                                <input type="checkbox" name="selected" value="<?php echo $item['page_id']; ?>"/>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="center"><?php echo $item['page_id']; ?></td>
                        <td class="left">
                            <?php echo $item[lang_field('page_title')]; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="center">
                            <?php showStatus($item['page_timer_date_time_int']); ?>
                        </td>
                        <td class="left"><?php echo $item['page_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                                <a title="Sửa" idval="<?php echo $item['page_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <?php if (!$this->auth->isContributor() || $item['page_timer_date_time_int'] == timer_private()){ ?>
                                <a title="Xóa" idval="<?php echo $item['page_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('page_delete'); ?>
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
        jsAdmin.changeMenu('page/lists');
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_page(list_id);
        });
        
        // Delete One Record
        $('.delete-click').click(function(){
            return delete_page($(this).attr('idval'));
        });
        
        // Send Ajax Delete
        function delete_page(list_id)
        {
            if (list_id)
            {
                list_id = list_id.replace(/\s+/g, ' ');
                        
                if (list_id.split(' ').length > 10){
                    jAlert('Bạn chỉ xóa tối đa 10 page', 'Lỗi số lượng');
                    return false;
                }
                
                jConfirm('Bạn có chắc muốn xóa những trang này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            page_delete : $('#page_delete').val()
                        };
                        
                        jsAdmin.sendAjax('post', 'text', data, 'page/delete', function (result)
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
        
        // Edit Click Action
        $('.edit-click').click(function(){
            jsAdmin.redirect('page/edit?page_id='+$(this).attr('idval'));
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
        $('#page_id, #page_title, #page_add_user_username').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        // Filter Change
        $('#page_id, #page_title, #page_add_user_username, #limit, #page_status').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        page_id     : $('#page_id').val(),
                        <?php echo lang_field('page_title'); ?>  : $('#page_title').val(),
                        
                        /*<!-- Not Author & Contributor -->*/
                        <?php if (!$this->auth->isContributor() && !$this->auth->isAuthor()){ ?>
                        page_add_user_username : $('#page_add_user_username').val(),
                        <?php } ?>
                        /*<!-- End Not Author & Contributor -->*/
                        lang        : $('.lang-wrapper-field span.active').attr('langcode'),
                        page_status : $('#page_status').val(),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'page/lists');
        }
    });
</script>