<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/director_lists">Đạo Diễn</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Đạo Diễn</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('product/director_add');">Thêm Mới</a>
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
                            Tên Đạo Diễn
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
                            <input type="text" id="director_id" value="<?php echo $filter['director_id']; ?>" size="3" style="text-align: center" />
                        </td>
                        <td><input type="text" id="director_title_short" value="<?php echo $filter[lang_field('director_title_short')]; ?>" size="50" /></td>
                        <td class="center"></td>
                        <td></td>
                        <td></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('product/director_lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['director_id']; ?></td>
                        <td class="left"><?php echo $item[lang_field('director_title')]; ?></td>
                        <td class="center">
                            <?php if ($item['director_icon']){ ?>
                            <img src="<?php echo $item['director_icon']; ?>" style="max-width: 40px"/>
                            <?php } ?>
                        </td>
                        <td class="center"><input type="text" style="width:50px; text-align: center" class="quick-edit" data-field="director_sort" data-id="<?php echo $item['director_id']; ?>" value="<?php echo $item['director_sort']; ?>" onkeypress="return onlyNumbers(event);" /></td>
                        <td class="left"><?php echo $item['director_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['director_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['director_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('director_delete'); ?>
            <?php $this->security->set_action('director_quick_edit'); ?>
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
        jsAdmin.changeTitle('Danh Sách Đạo Diễn Phim');
        
        // Menu
        jsAdmin.changeMenu('product/director_lists');
        
        $('.delete-click').click(function(){
            return delete_director($(this).attr('idval'));
        });
        
        function delete_director(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa directorgory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            director_delete : $('#director_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'product/director_delete', function (result)
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
                director_quick_edit : $('#director_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('director_sort', 'director_ref_parent_id'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'product/director_quick_edit', function (result)
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
            jsAdmin.redirect('product/director_edit?director_id='+$(this).attr('idval'));
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
        
        $('#director_id, #director_title_short').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        $('#director_id, #director_title_short, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        lang : $('.lang-wrapper-field span.active').attr('langcode'),
                        page : page,
                        director_title_short : $('#director_title_short').val(),
                        director_id : $('#director_id').val()
                };
                
                jsAdmin.event.filter(data, 'product/director_lists');
        }
    });
</script>

