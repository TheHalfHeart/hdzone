<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chính</a> ::
    <a href="admin.php#contact/lists">Liên Hệ</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Liên Hệ Mới</h1>
        <div class="buttons">
            <a class="button" id="click-save">Thêm Mới</a>
            <a class="button" id="click-back">Trở Lại</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general" class="selected">Thông Tin</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="contact_title" value="<?php _val($filter, 'contact_title'); ?>" size="100" maxlength="500"/>
                                <?php showError($errors, 'contact_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 250 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="contact_email" value="<?php _val($filter, 'contact_email'); ?>" size="100" maxlength="250"/>
                                <?php showError($errors, 'contact_email'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tên Đầy Đủ <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 250 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="contact_fullname" value="<?php _val($filter, 'contact_fullname'); ?>" size="100" maxlength="250"/>
                                <?php showError($errors, 'contact_fullname'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa Chỉ</strong>
                                <span class="help">Tối đa 250 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="contact_address" value="<?php _val($filter, 'contact_address'); ?>" size="100" maxlength="250"/>
                                <?php showError($errors, 'contact_address'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Điện Thoại</strong>
                                <span class="help">Tối đa 30 ký tự</span>
                            </td>
                            <td>
                                <input type="text" id="contact_phone" value="<?php _val($filter, 'contact_phone'); ?>" size="100" maxlength="30"/>
                                <?php showError($errors, 'contact_phone'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nội Dung <span class="required">(*)</span></strong>
                            </td>
                            <td>
                                <?php showError($errors, 'contact_content'); ?>
                                <textarea id="contact_content" cols="100" rows="10"><?php _val($filter, 'contact_content'); ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('contact_add'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Thêm Liên Hệ Mới');
        
        // Ckeditor
        jsAdmin.loadCkeditorSort('contact_content');
        
        // Menu
        jsAdmin.changeMenu('contact/lists');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'contact/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                contact_title       : trim($('#contact_title').val()),
                contact_fullname    : trim($('#contact_fullname').val()),
                contact_email       : trim($('#contact_email').val()),
                contact_address     : trim($('#contact_address').val()),
                contact_phone       : trim($('#contact_phone').val()),
                contact_content:    CKEDITOR.instances['contact_content'].getData(),
                contact_add         : $('#contact_add').val()
            };
            
            // Validate data
            if (isEmpty(data.contact_title)){
                jAlert('Tiêu đề không được để trống', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!isEmail(data.contact_email)){
                jAlert('Email không được để trống và phải nhập đúng', 'Lỗi email');
                return false;
            }
            
            if (isEmpty(data.contact_content)){
                jAlert('Nội dung liên hệ không được để trống', 'Lỗi nội dung liên hệ');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'contact/add', function (result)
            {
                result = trim(result);
                
                if (result == 'ERROR_TOKEN'){
                    jAlert('Mã token bị sai, vui lòng đăng nhập lại để thực hiện thao tác này', 'Sai mã token');
                    return false;
                }
                else if (result == 'ERROR_AUTH'){
                    jAlert('Bạn không đủ quyền để thực hiện thao tác này', 'Lỗi không đủ quyền thao tác');
                }
                else if (result == 'ERROR_UNSUCCESS'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (result == 'ERROR_SUCCESS')
                {
                    jConfirm('Thêm thành công, bạn có muốn thêm tiếp?', 'Thêm thành công', function (r){
                        if (r){
                            jsAdmin.redirect('contact/add');
                        }
                        else{
                            $('#click-back').click();
                        }
                    });
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
    });    
</script>

