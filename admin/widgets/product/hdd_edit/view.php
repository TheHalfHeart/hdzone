<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#product/post_lists">Sản Phẩm</a> ::
    <a href="admin.php#product/hdd_lists">Ổ Đĩa</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Ổ Đĩa</h1>
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
                                <input type="text" id="hdd_title" value="<?php _val($filter, 'hdd_title'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'hdd_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Code <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <input type="text" id="hdd_code" value="<?php _val($filter, 'hdd_code'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'hdd_code'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Size <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <input type="text" id="hdd_size" value="<?php _val($filter, 'hdd_size'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'hdd_size'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng thái</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <select id="hdd_status">
                                    <option value="0">Chưa đầy</option>
                                    <option value="1" <?php if ($filter['hdd_status'] == 1) echo 'selected'; ?>>Đã đầy</option>
                                </select>
                                <?php showError($errors, 'hdd_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Số thứ tự</strong>
                                <span class="help"></span>
                            </td>
                            <td>
                                <input type="text" id="hdd_order" value="<?php _val($filter, 'hdd_order'); ?>" size="100" maxlength="255"/>
                                <?php showError($errors, 'hdd_order'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mô tả <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 255 ký tự. Hiển thị ở dạng ngắn (thường ở trang danh sách tin theo chuyên mục)</span>
                            </td>
                            <td>
                                <textarea id="hdd_description" cols="96" rows="5"><?php _val($filter, 'hdd_description'); ?></textarea>
                                <?php showError($errors, 'hdd_description'); ?>
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
                                    <strong><?php echo $filter['hdd_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['hdd_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['hdd_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['hdd_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['hdd_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['hdd_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                </td>
                                <td>
                                    <?php //lang_url_front($filter, array('hdd_slug'), '{hdd_slug}'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('hdd_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-product-hdd-editting" value="product-hdd-editting"/>
</div>

<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.changeTitle('Sửa Ổ Đĩa');
        
        // Lang
        jsAdmin.loadLang();
        
        // Menu
        jsAdmin.changeMenu('product/hdd_lists');
        
        $('#tabs a').tabs();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'product/hdd_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        $('#click-save').click(function()
        {
            var data = 
            {
                hdd_title       : trim($('#hdd_title').val()),
                hdd_id          : '<?php echo $filter['hdd_id']; ?>',
                hdd_size        : trim($('#hdd_size').val()),
                hdd_code        : trim($('#hdd_code').val()),
                hdd_status        : trim($('#hdd_status').val()),
                hdd_order        : trim($('#hdd_order').val()),
                hdd_description : trim($('#hdd_description').val()),
                hdd_edit         : $('#hdd_edit').val()
            };
            
            // Validate data
            if (isEmpty(data.hdd_title)){
                jAlert('Bạn chưa nhập tiêu đề ', 'Lỗi tiêu đề');
                return false;
            }
            
            // Validate data
            if (isEmpty(data.hdd_code)){
                jAlert('Bạn chưa nhập Code', 'Lỗi Code');
                return false;
            }
            
            if (isEmpty(data.hdd_size)){
                jAlert('Bạn chưa nhập size', 'Lỗi size');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'product/hdd_edit?hdd_id=<?php echo $filter['hdd_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('product/hdd_edit?hdd_id=<?php echo $filter['hdd_id']; ?>');
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
            if (!isEmpty($('#interval-product-hdd-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {hdd_id:<?php echo $filter['hdd_id']; ?>}, 'product/hdd_editting');
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
                    hash_back = 'product/hdd_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>

