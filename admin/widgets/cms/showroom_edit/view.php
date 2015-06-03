<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/showroom_lists">Showroom</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Showroom</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-other">Khác</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <input type="text" id="showroom_title" value="<?php _val($filter, 'showroom_title'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'showroom_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa chỉ <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <input type="text" id="showroom_address" value="<?php _val($filter, 'showroom_address'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'showroom_address'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng thái</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <select id="showroom_status">
                                    <option value="0">Chưa đầy</option>
                                    <option value="1" <?php if ($filter['showroom_status'] == 1) echo 'selected'; ?>>Đã đầy</option>
                                </select>
                                <?php showError($errors, 'showroom_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số thứ tự</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <input type="text" id="showroom_order" value="<?php _val($filter, 'showroom_order'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'showroom_order'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô tả <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <textarea id="showroom_description" cols="96" rows="5"><?php _val($filter, 'showroom_description'); ?></textarea>
                                <?php showError($errors, 'showroom_description'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-other">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>ID</strong>
                                </td>
                                <td>
                                    <strong><?php echo $filter['showroom_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['showroom_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['showroom_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['showroom_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['showroom_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['showroom_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('showroom_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-cms-showroom-editting" value="cms-showroom-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Sửa Showroom');
        
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('cms/showroom_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'cms/showroom_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                showroom_title       : trim($('#showroom_title').val()),
                showroom_id          : '<?php echo $filter['showroom_id']; ?>',
                showroom_address        : trim($('#showroom_address').val()),
                showroom_status        : trim($('#showroom_status').val()),
                showroom_order        : trim($('#showroom_order').val()),
                showroom_description : trim($('#showroom_description').val()),
                showroom_edit         : $('#showroom_edit').val()
            };
            
            // Validate data
            if (isEmpty(data.showroom_title)){
                jAlert('Bạn chưa nhập tiêu đề ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (isEmpty(data.showroom_address)){
                jAlert('Bạn chưa nhập Địa chỉ', 'Lỗi Code');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'cms/showroom_edit?showroom_id=<?php echo $filter['showroom_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('cms/showroom_edit?showroom_id=<?php echo $filter['showroom_id']; ?>');
                    });
                }
                else if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
        
        // Update Editting
        clearInterval(jsAdmin.editting);
        jsAdmin.editting = setInterval(function()
        {
            if (!isEmpty($('#interval-cms-showroom-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {showroom_id:<?php echo $filter['showroom_id']; ?>}, 'cms/showroom_editting');
            }
            else{
                clearInterval(jsAdmin.editting);
            }
        },10000);
    });    
</script>
<?php } ?>

<?php if (_is_editting($filter)){ ?>
    <script language="javascript">
        $('#content').html('');
        jAlert('Bài viết đang được sửa bởi <?php echo $filter['editting_user_username']; ?>', 'Lỗi phiên làm việc', function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'cms/showroom_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

