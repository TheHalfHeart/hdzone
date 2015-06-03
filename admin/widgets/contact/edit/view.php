<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    <div class="breadcrumb">
        <a href="admin.php#cms/dashboard">Trang Chính</a> ::
        <a href="admin.php#contact/lists">Liên Hệ</a>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img alt="" src="public/admin/image/home.png">Sửa Tin Liên Hệ</h1>
            <div class="buttons">
                <a class="button" id="click-save">Lưu</a>
                <a class="button" id="click-back">Trở Lại</a>
            </div>
        </div>
        <div class="content">
            <?php echo $message; ?>
            <div class="htabs" id="tabs">
                <a href="#tab-general" style="display: inline;" class="selected">Thông Tin</a>
            </div>
            <form id="form" onsubmit=" return false;" method="post">
                <div id="tab-general">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Kiểm Tra <span class="required">(*)</span></strong>
                                </td>
                                <td>
                                    <select id="contact_status">
                                        <option value=""></option>
                                        <option value="0" <?php _selected($filter, 'contact_status', '0'); ?>>Chưa</option>
                                        <option value="1" <?php _selected($filter, 'contact_status', '1'); ?>>Rồi</option>
                                    </select>
                                    <?php showError($errors, 'contact_status'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Trả Lời <span class="required">(*)</span></strong>
                                </td>
                                <td>
                                    <select id="contact_answer">
                                        <option value=""></option>
                                        <option value="0" <?php _selected($filter, 'contact_answer', '0'); ?>>Chưa</option>
                                        <option value="1" <?php _selected($filter, 'contact_answer', '1'); ?>>Rồi</option>
                                    </select>
                                    <?php showError($errors, 'contact_status'); ?>
                                </td>
                            </tr>
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
                                    <strong>Email<span class="required">(*)</span></strong>
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
                <?php $this->security->set_action('contact_edit'); ?>
            </form>
        </div>
        <input type="hidden" id="interval-contact-editting" value="contact-editting"/>
    </div>
    <script language="javscript" type="text/javascript">
        $(document).ready(function()
        {
            // Title Page
            jsAdmin.changeTitle('Sửa Tin Liên Hệ');
            
            jsAdmin.changeMenu('contact/lists');
            
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
                    contact_id          : <?php echo $filter['contact_id']; ?>,
                    contact_title       : trim($('#contact_title').val()),
                    contact_address     : trim($('#contact_address').val()),
                    contact_status      : trim($('#contact_status').val()),
                    contact_answer      : trim($('#contact_answer').val()),
                    contact_fullname    : trim($('#contact_fullname').val()),
                    contact_email       : trim($('#contact_email').val()),
                    contact_phone       : trim($('#contact_phone').val()),
                    contact_content:    CKEDITOR.instances['contact_content'].getData(),
                    contact_edit         : $('#contact_edit').val()
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
                
                jsAdmin.sendAjax('post', 'text', data, 'contact/edit?contact_id=<?php echo $filter['contact_id']; ?>', function (result)
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
                        jAlert('Cập nhật thành công', 'Thành công', function(){
                            jsAdmin.redirect('contact/edit?contact_id=<?php echo $filter['contact_id']; ?>');
                        });
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
                if (!isEmpty($('#interval-contact-editting').val())){
                    jsAdmin.sendHideAjax('get', 'text', {contact_id:<?php echo $filter['contact_id']; ?>}, 'contact/editting');
                }
                else{
                    clearInterval(jsAdmin.editting);
                }
            },10000);
        });
    </script>

<?php if (_is_editting($filter)){ ?>
    <script language="javascript">
        $('#content').html('');
        jAlert('Bài viết đang được sửa bởi <?php echo $filter['editting_user_username']; ?>', 'Lỗi phiên làm việc', function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'contact/lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php } ?>

