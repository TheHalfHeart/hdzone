<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/manu_lists">Nhà Sản Xuất</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Nhà Sản Xuất</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('product/manu_add');">Thêm Mới</a>
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
                            Tên Nhà Sản Xuất
                        </td>
                        <td width="10%" class="center">
                            Icon
                        </td>
                        <td  width="10%" class="center" style="display: none">
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
                            <input type="text" id="manu_id" value="<?php echo $filter['manu_id']; ?>" size="3" style="text-align: center" />
                        </td>
                        <td><input type="text" id="manu_title_short" value="<?php echo $filter[lang_field('manu_title_short')]; ?>" size="50" /></td>
                        <td class="center"></td>
                        <td></td>
                        <td style="display: none"></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('product/manu_lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center"><?php echo $item['manu_id']; ?></td>
                        <td class="left"><?php echo $item[lang_field('manu_title')]; ?></td>
                        <td class="center">
                            <?php if ($item['manu_icon']){ ?>
                            <img src="<?php echo $item['manu_icon']; ?>" style="max-width: 40px"/>
                            <?php } ?>
                        </td>
                        <td class="center" style="display: none"><input type="text" style="width:50px; text-align: center" class="quick-edit" data-field="manu_sort" data-id="<?php echo $item['manu_id']; ?>" value="<?php echo $item['manu_sort']; ?>" onkeypress="return onlyNumbers(event);" /></td>
                        <td class="left"><?php echo $item['manu_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['manu_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['manu_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('manu_delete'); ?>
            <?php $this->security->set_action('manu_quick_edit'); ?>
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
        jsAdmin.changeTitle('Danh Sách Nhà Sản Xuất Phim');
        
        // Menu
        jsAdmin.changeMenu('product/manu_lists');
        
        $('.delete-click').click(function(){
            return delete_manu($(this).attr('idval'));
        });
        
        function delete_manu(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa manugory này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            manu_delete : $('#manu_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'product/manu_delete', function (result)
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
                manu_quick_edit : $('#manu_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('manu_sort', 'manu_ref_parent_id'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'product/manu_quick_edit', function (result)
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
            jsAdmin.redirect('product/manu_edit?manu_id='+$(this).attr('idval'));
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
        
        $('#manu_id, #manu_title_short').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        $('#manu_id, #manu_title_short, #limit').change(function(){
                filter();
        });
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        lang : $('.lang-wrapper-field span.active').attr('langcode'),
                        page : page,
                        manu_title_short : $('#manu_title_short').val(),
                        manu_id : $('#manu_id').val()
                };
                
                jsAdmin.event.filter(data, 'product/manu_lists');
        }
    });
</script>

