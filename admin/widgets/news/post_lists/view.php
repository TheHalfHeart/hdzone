<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#news/post_lists">Tin Tức</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Tin Tức (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('news/post_add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa Tất Cả</a>
        </div>
    </div>
    <div class="content">
        <?php lang_show_list_page(); ?>
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" class="center">#</td>
                        <td width="5%" class="center">
                            <?php echo $this->pagination->getSortLink('ID', 'post_id'); ?>
                        </td>
                        <td width="50%" class="left">
                            <?php echo $this->pagination->getSortLink('Tiêu Đề', lang_field('post_title_first_char_ascii')); ?>
                        </td>
                        <td  width="7%" class="left">
                            Hiển Thị
                        </td>
                        <td  width="13%" class="left" style="display: none">
                            Chuyên Mục
                        </td>
                        <td  width="10%" class="left">
                            Tác Giả
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="post_id" value="<?php echo $filter['post_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input style="width: 300px;" type="text" id="post_title" value="<?php echo  $filter[lang_field('post_title')]; ?>" /></td>
                        <td class="center">
                            <select id="post_status" style="width: 100%;">
                                <option value=""></option>
                                <option value="1" <?php _selected($filter, 'post_status', '1'); ?>>Hiển Thị</option>
                                <option value="2" <?php _selected($filter, 'post_status', '2'); ?>>Hẹn Giờ</option>
                                <option value="0" <?php _selected($filter, 'post_status', '0'); ?>>Ẩn</option>
                            </select>
                        </td>
                         <td class="center" style="display: none">
                             <select id="post_ref_cate_id">
                                 
                             </select>
                        </td>
                        <td>
                            <?php if (!$this->auth->isContributor() && !$this->auth->isAuthor()){ ?>
                            <input style="width: 100px;" type="text" id="post_add_user_username" value="<?php echo  $filter['post_add_user_username']; ?>" />
                            <?php } ?>
                        </td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('news/post_lists'); return false;">Reset</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <?php if (!_is_editting($item)){ ?>
                                <?php if (!$this->auth->isContributor() || $item['post_timer_date_time_int'] == timer_private()){ ?>
                                <input type="checkbox" name="selected" value="<?php echo $item['post_id']; ?>"/>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="center"><?php echo $item['post_id']; ?></td>
                        <td class="left">
                            <?php echo $item[lang_field('post_title')]; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="center">
                            <?php showStatus($item['post_timer_date_time_int']); ?>
                        </td>
                        <td class="left" style="display: none">
                            <select id="parent_id_wrapper_<?php echo $item['post_id']; ?>" data-id="<?php echo $item['post_id']; ?>" data-field="post_ref_cate_id" class="quick-edit">
                            </select>
                        </td>
                        <td class="left"><?php echo $item['post_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['post_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                                <?php if (!$this->auth->isContributor() || $item['post_timer_date_time_int'] == timer_private()){ ?>
                                <a title="Xóa" idval="<?php echo $item['post_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('post_delete'); ?>
            <?php $this->security->set_action('post_quick_edit'); ?>
            <input type="hidden" name="order_by" id="order_by" value="<?php echo $filter['order_by']; ?>"/>
            <input type="hidden" name="order_type" id="order_type" value="<?php echo $filter['order_type']; ?>"/>
        </form>
        <?php echo $this->pagination->create(); ?>
    </div>
</div>

<?php $this->news_cate_model->to_js_list($cate); ?>

<script language="javascript">
    $(document).ready(function()
    {
        jsAdmin.urlBack.level1 = '<?php echo $link_back; ?>';
        
        var str = '';
    
        // INIT CATE LEVEL
        function showParent(cateList, parent_id, dem, current_id)
        {
            var arrayForeach = new Array();
            
            var cateContinue = new Array();
            
            for(var i = 0; i < cateList.length; i++){
                if (cateList[i].cate_ref_parent_id == parent_id){
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
                    
                    if (arrayForeach[i].cate_id == current_id){
                        str += ' selected style="background:gray" ';
                    }
                    
                    str += '">';
                    
                    for (var j = 0; j <= dem; j++){
                        str += '|---';
                    }
                    
                    str += arrayForeach[i].<?php echo lang_field('cate_title_short'); ?>;
                    
                    str += '</option>';
                    
                    showParent(cateContinue, arrayForeach[i].cate_id, dem+1, current_id);
                }
            } 
        }
        
        str = '<option value="">TẤT CẢ</option>';
        showParent(cate, 0, 0, <?php echo (int)$filter['post_ref_cate_id']; ?>);
        $('#post_ref_cate_id').html(str);
        
        <?php foreach ($data as $item){ ?>
        str = '<option value="">KHO LƯU TRỮ</option>';
        showParent(cate, 0, 0, <?php echo (int)$item['post_ref_cate_id']; ?>);
        $('#parent_id_wrapper_'+<?php echo (int)$item['post_id']; ?>).html(str);
        <?php } ?>
        
        jsAdmin.changeTitle('Danh Sách Tin Tức');
        
        // Menu
        jsAdmin.changeMenu('news/post_lists');
        
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_post(list_id);
        });
        
        $('.delete-click').click(function(){
            return delete_post($(this).attr('idval'));
        });
        
        function delete_post(list_id)
        {    
            if (list_id.split(' ').length > 5){
                jAlert('Bạn chỉ xóa tối đa 5 bài', 'Lỗi số lượng');
                return false;
            }
            
            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa những trang này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            post_delete : $('#post_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'news/post_delete', function (result)
                        {
                            result = trim(result);
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    var hash = '<?php echo $link_back; ?>';
                                    jsAdmin.redirect(hash.hash());
                                });
                            }
                            else if (result == '102'){
                                jAlert('Bạn chỉ xóa tối đa 5 bài', 'Lỗi số lượng');
                            }
                            else{
                                jAlert('Xóa thất bại', 'Thất bại');
                            }
                        });
                    }
                });
            }
            else{
                jAlert('Vui lòng chọn bài cần xóa', 'Thông báo');
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
                post_quick_edit : $('#post_quick_edit').val()
            };
            
            if (!inArray(data.field, new Array('post_ref_cate_id'))){
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'news/post_quick_edit', function (result)
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
            jsAdmin.redirect('news/post_edit?post_id='+$(this).attr('idval'));
            return false;
        });
        
        $('#post_id, #post_title, #post_add_user_username').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        $('#post_id, #post_title, #post_add_user_username, #limit, #post_status, #post_ref_cate_id').change(function(){
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
        
        function filter()
        {
                var data = 
                {
                        post_id     : $('#post_id').val(),
                        <?php echo lang_field('post_title'); ?>  : $('#post_title').val(),
                        <?php if (!$this->auth->isContributor() && !$this->auth->isAuthor()){ ?>
                        post_add_user_username : $('#post_add_user_username').val(),
                        <?php } ?>
                        post_status : $('#post_status').val(),
                        post_ref_cate_id : $('#post_ref_cate_id').val(),
                        lang        : $('.lang-wrapper-field span.active').attr('langcode'),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'news/post_lists');
        }
    });
</script>