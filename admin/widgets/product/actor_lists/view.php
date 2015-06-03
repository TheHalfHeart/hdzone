<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/manu_lists">Diễn Viên</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Diễn Viên</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('product/actor_add');">Thêm Mới</a>
        </div>
    </div>
    <div class="content">
        <?php lang_show_list_page(); ?>
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">
                            ID
                        </td>
                        <td width="55%" class="left">
                            Tên Diễn Viên
                        </td>
                        <td width="10%" class="center">
                            Icon
                        </td>
                        <td  width="10%" class="center">
                            Sắp Xếp
                        </td>
                        <td  width="10%" class="left">
                            Người Tạo
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center">
                            <input type="text" id="actor_id" value="<?php echo $filter['actor_id']; ?>" size="3" style="text-align: center" />
                        </td>
                        <td><input type="text" id="actor_title_short" value="<?php echo $filter[lang_field('actor_title_short')]; ?>" size="50" /></td>
                        <td class="center"></td>
                        <td></td>
                        <td></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('product/actor_lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['actor_id']; ?></td>
                        <td class="left"><?php echo $item[lang_field('actor_title')]; ?></td>
                        <td class="center">
                            <?php if ($item['actor_icon']){ ?>
                            <img src="<?php echo $item['actor_icon']; ?>" style="max-width: 40px"/>
                            <?php } ?>
                        </td>
                        <td class="center"><input type="text" style="width:50px; text-align: center" class="quick-edit" data-field="actor_sort" data-id="<?php echo $item['actor_id']; ?>" value="<?php echo $item['actor_sort']; ?>" onkeypress="return onlyNumbers(event);" /></td>
                        <td class="left"><?php echo $item['actor_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['actor_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['actor_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('actor_delete'); ?>
            <?php $this->security->set_action('actor_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
        <?php echo $this->pagination->create(); ?>
    </div>
</div>
<script language="javascript">
    $(document).ready(function()
    {  
        // -----------------------
        
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Title
        jsAdmin.changeTitle('Danh Sách Diễn Viên Phim');
        
        // Menu
        jsAdmin.changeMenu('product/actor_lists');
        
        $('.delete-click').click(function(){
            return delete_actor($(this).attr('idval'));
        });
        
        function delete_actor(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa actorgory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            actor_delete : $('#actor_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'product/actor_delete', function (result)
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
        
        var page = '';
        
        // Quick Edit
        $('.quick-edit').change(function()
        {
            page = '<?php echo $this->input->get('page'); ?>';
            
            var data = {
                id : $(this).attr('data-id'),
                field : $(this).attr('data-field'),
                value : $(this).val(),
                actor_quick_edit : $('#actor_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('actor_sort', 'actor_ref_parent_id'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'product/actor_quick_edit', function (result)
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
        
        $('.edit-click').click(function(){
            jsAdmin.redirect('product/actor_edit?actor_id='+$(this).attr('idval'));
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
        
        $('#actor_id, #actor_title_short').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        $('#actor_id, #actor_title_short, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        lang : $('.lang-wrapper-field span.active').attr('langcode'),
                        page : page,
                        actor_title_short : $('#actor_title_short').val(),
                        actor_id : $('#actor_id').val()
                };
                
                jsAdmin.event.filter(data, 'product/actor_lists');
        }
    });
</script>

