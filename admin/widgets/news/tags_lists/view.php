<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#news/post_lists">Tin Tức</a> ::
    <a href="admin.php#news/tags_lists">Tag</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Danh Sách Tags (<?php echo $this->pagination->total_record; ?>)</h1>
        <div class="buttons">
            <a class="button" onclick="return jsAdmin.redirect('news/tags_add');">Thêm Mới</a>
            <a class="button" id="delete-all-click">Xóa</a>
        </div>
    </div>
    <div class="content">
        <?php lang_show_list_page(); ?>
        <form id="form" onsubmit="return false;" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td width="5%" style="text-align: center;">
                            #
                        </td>
                        <td width="5%" style="text-align: center;">
                            <?php echo $this->pagination->getSortLink('ID', 'tags_id'); ?>
                        </td>
                        <td width="55%" class="left">
                            Tiêu Đề Ngắn
                        </td>
                        <td  width="10%" class="center">
                            <?php echo $this->pagination->getSortLink('Tổng Số Tin', 'tags_total_post'); ?>
                        </td>
                        <td  width="15%" class="left">
                            Người Đăng
                        </td>
                        <td width="10%" class="right">Tùy Chọn</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="filter">
                        <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"  value=""/></td>
                        <td class="center"><input type="text" onkeypress="return onlyNumbers(event);" id="tags_id" value="<?php echo $filter['tags_id']; ?>" style="text-align: center; width: 80%;" /></td>
                        <td><input type="text" id="tags_title_short" value="<?php echo $filter[lang_field('tags_title_short')]; ?>" size="50" /></td>
                        <td></td>
                        <td><input style="width: 100px;" type="text" id="tags_add_user_username" value="<?php echo  $filter['tags_add_user_username']; ?>" /></td>
                        <td align="right">
                            <a class="button" onclick=" jsAdmin.redirect('news/tags_lists'); return false;">Làm Mới</a>
                        </td>
                    </tr>
                    <?php foreach ($data as $item){ ?>
                    <tr>
                        <td class="center">
                            <input type="checkbox" name="selected" value="<?php echo $item['tags_id']; ?>"/>
                        </td>
                        <td class="center"><?php echo $item['tags_id']; ?></td>
                        <td class="left">
                            <?php echo $item[lang_field('tags_title_short')]; ?>
                            <?php _editting_message($item); ?>
                        </td>
                        <td class="center"><?php echo $item['tags_total_post']; ?></td>
                        <td class="left"><?php echo $item['tags_add_user_username']; ?></td>
                        <td class="right">
                            <?php if (!_is_editting($item)){ ?>
                            <a title="Sửa" idval="<?php echo $item['tags_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                            <a title="Xóa" idval="<?php echo $item['tags_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php $this->security->set_action('tags_delete'); ?>
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
        
        jsAdmin.changeTitle('Danh Sách Tags');
        
        // Menu
        jsAdmin.changeMenu('news/tags_lists');
        
        // Delete  All Action
        $('#delete-all-click').click(function(){
            var list_id = get_list_input_id('selected', ' ');
            return delete_tags(list_id);
        });
        
        
        $('.delete-click').click(function(){
            return delete_tags($(this).attr('idval'));
        });
        
        function delete_tags(list_id)
        {
            list_id = list_id.replace(/\s+/g, ' ');
            
            if (list_id.split(' ').length > 10){
                jAlert('Bạn chỉ xóa tối đa 10 tags', 'Lỗi số lượng');
                return false;
            }

            if (list_id)
            {
                jConfirm('Bạn có chắc muốn xóa Tags này?', 'Xác nhận xóa', function (r){
                    if (r)
                    {
                        var data = {
                            list_id : list_id,
                            tags_delete : $('#tags_delete').val()
                        };
                        jsAdmin.sendAjax('post', 'text', data, 'news/tags_delete', function (result)
                        {
                            result = trim(result);
                            
                            if (result == '100'){
                                jAlert('Xóa thành công', 'Thành công', function (){
                                    jsAdmin.redirect('<?php echo $link_back; ?>'.hash());
                                });
                            }
                            else if (result == '102'){
                                jAlert('Bạn chỉ được phép xóa tối đa 10 tin cùng một lúc', 'Lỗi số lượng');
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
            jsAdmin.redirect('news/tags_edit?tags_id='+$(this).attr('idval'));
            return false;
        });
        
        $('#tags_id, #tags_add_user_username,#tags_title_short').keyup(function (e)
        {
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13){
                        filter();
                }
        });
        
        $('#tags_id, #tags_add_user_username,#tags_title_short, #limit').change(function(){
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
                        tags_id     : $('#tags_id').val(),
                        lang        : $('.lang-wrapper-field span.active').attr('langcode'),
                        tags_add_user_username : $('#tags_add_user_username').val(),
                        <?php echo lang_field('tags_title_short'); ?> : $('#tags_title_short').val(),
                        order_by    : $('#order_by').val(),
                        order_type  : $('#order_type').val(),
                        limit       : $('#limit').val()
                };
                jsAdmin.event.filter(data, 'news/tags_lists');
        }
    });
</script>

