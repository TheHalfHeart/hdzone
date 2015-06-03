<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/device_lists">Thiết Bị</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Thiết Bị</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
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
                                <input type="text" id="device_title" value="<?php _val($filter, 'device_title'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'device_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa chỉ <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <input type="text" id="device_address" value="<?php _val($filter, 'device_address'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'device_address'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng thái</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <select id="device_status">
                                    <option value="0">Ngưng hoạt động</option>
                                    <option value="1" <?php if (isset($filter['device_status']) && $filter['device_status'] == 1) echo 'selected'; ?>>Hoạt động</option>
                                </select>
                                <?php showError($errors, 'device_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số thứ tự</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <input type="text" id="device_order" value="<?php _val($filter, 'device_order'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'device_order'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô tả <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <textarea id="device_description" cols="96" rows="5"><?php _val($filter, 'device_description'); ?></textarea>
                                <?php showError($errors, 'device_description'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('device_add'); ?>
        </form>
    </div>
</div>

<script language="javscript" type="text/javascript">
    
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Thêm Thiết Bị Mới');
        
        // Menu
        jsAdmin.changeMenu('cms/device_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'cms/device_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                device_title       : trim($('#device_title').val()),
                device_address        : trim($('#device_address').val()),
                device_status        : trim($('#device_status').val()),
                device_order        : trim($('#device_order').val()),
                device_description : trim($('#device_description').val()),
                device_add         : $('#device_add').val()
            };
            
            // Validate data
            if (isEmpty(data.device_title)){
                jAlert('Bạn chưa nhập tiêu đề ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (isEmpty(data.device_address)){
                jAlert('Bạn chưa nhập Địa chỉ', 'Lỗi Code');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'cms/device_add', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Thêm thành công', 'Thành công', function (){
                        $('#click-back').click();
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
    });    
</script>