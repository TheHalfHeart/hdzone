<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#news/post_lists">Tin Tức</a> ::
    <a href="admin.php#news/cate_lists">Chuyên Mục</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Chuyên Mục</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('news/cate_add');">Thêm Mới</a>
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
                        <td width="40%" class="left">
                            Tiêu Đề
                        </td>
                        <td  width="15%" class="center">
                            Mục Cha
                        </td>
                        <td  width="10%" class="center">
                            Tổng Số Tin
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
                    <?php $this->news_cate_model->show_main_list($data); ?>
                </tbody>
            </table>
            <?php $this->security->set_action('cate_delete'); ?>
            <?php $this->security->set_action('cate_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
    </div>
</div>
<?php $this->news_cate_model->to_js_list($data); ?>
<script language="javascript">
    $(document).ready(function()
    {
        var str = '';
    
        // INIT CATE LEVEL
        function showParent(cateList, parent_id, dem, current_id, current_parent_id)
        {
            var arrayForeach = new Array();
            var cateContinue = new Array();

            for(var i = 0; i < cateList.length; i++){
                if (cateList[i].cate_id == current_id){
                    
                }
                else if (cateList[i].cate_ref_parent_id == parent_id){
                    arrayForeach.push(cateList[i]);
                }
                else{
                    cateContinue.push(cateList[i]);
                }
            }

            if (arrayForeach.length > 0)
            {
                for (i = 0; i < arrayForeach.length; i++)
                {
                    str += '<option value="'+arrayForeach[i].cate_id +'"';
                    
                    if (arrayForeach[i].cate_id == current_parent_id){
                        str += ' selected style="background:gray" ';
                    }
                    
                    str += '">';
                    for (var j = 0; j <= dem; j++){
                        str += '|---';
                    }
                    str += arrayForeach[i].<?php echo lang_field('cate_title_short'); ?>;
                    str += '</option>';
                    showParent(cateContinue, arrayForeach[i].cate_id, dem+1, current_id, current_parent_id);
                }
            } 
        }
        
        for (var i = 0; i < cate.length; i++){
            str = '<option value="0">TOP</option>';
            showParent(cate, 0, 0, cate[i].cate_id,cate[i].cate_ref_parent_id);
            $('#parent_id_wrapper_'+cate[i].cate_id).html(str);
        }
        
        // -----------------------
        
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        // Title
        jsAdmin.changeTitle('Danh Sách Chuyên Mục');
        
        // Menu
        jsAdmin.changeMenu('news/cate_lists');
        
        $('.delete-click').click(function(){
            return delete_cate($(this).attr('idval'));
        });
        
        function delete_cate(list_id)
        {
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa category này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            cate_delete : $('#cate_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'news/cate_delete', function (result)
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
        
        // Quick Edit
        $('.quick-edit').change(function()
        {
            var data = {
                id : $(this).attr('data-id'),
                field : $(this).attr('data-field'),
                value : $(this).val(),
                cate_quick_edit : $('#cate_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('cate_sort', 'cate_ref_parent_id'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'news/cate_quick_edit', function (result)
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
            jsAdmin.redirect('news/cate_edit?cate_id='+$(this).attr('idval'));
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
        
        // Send Ajax Filer
        function filter()
        {
                var data = 
                {
                        lang        : $('.lang-wrapper-field span.active').attr('langcode')
                };
                jsAdmin.event.filter(data, 'news/cate_lists');
        }
    });
</script>

