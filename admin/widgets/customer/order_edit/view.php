<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#customer/customer_lists">Khách Hàng</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Thêm Đơn Hàng Mới</h1>
        <div class="buttons">
            <a class="button" id="click-save">Lưu</a>
            <a class="button" id="click-save">Export Excel</a>
            <a class="button" id="click-save">Export Word</a>
            <a class="button" id="click-back">Trở Về</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-product">Sản Phẩm</a>
            <a href="#tab-other">Khác</a>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Khách Hàng <span class="required">(*)</span></strong>
                                <span class="help">Nhập Tên Đăng Nhập Của Khách Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_customer_username" value="<?php _val($filter, 'order_customer_username'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_customer_username'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tên Khách Hàng</strong>
                                <span class="help">Tên Khách Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_fullname" value="<?php _val($filter, 'order_fullname'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_fullname'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Nhập Tiêu Đề Đơn Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_title" value="<?php _val($filter, 'order_title'); ?>" size="50" maxlength="500"/>
                                <?php showError($errors, 'order_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Trạng Thái</strong>
                                <span class="help">Tình Trạng Của Đơn Hàng</span>
                            </td>
                            <td>
                                <select id="order_status">
                                    <option value="0">Mới chọn</option>
                                    <option value="1" <?php _selected($filter, 'order_status', '1'); ?>>Đã nhận ổ</option>
                                    <option value="2" <?php _selected($filter, 'order_status', '2'); ?> >Đã trả ổ</option>
                                    <option value="3" <?php _selected($filter, 'order_status', '3'); ?> >Không copy</option>
                                    <option value="4" <?php _selected($filter, 'order_status', '4'); ?> >Không hoàn tất</option>
                                </select>
                                <?php showError($errors, 'order_status'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email</strong>
                                <span class="help">Nhập Email</span>
                            </td>
                            <td>
                                <input type="text" id="order_email" value="<?php _val($filter, 'order_email'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_email'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Điện Thoại</strong>
                                <span class="help">Nhập Điện Thoại</span>
                            </td>
                            <td>
                                <input type="text" id="order_phone" value="<?php _val($filter, 'order_phone'); ?>" size="50" maxlength="30"/>
                                <?php showError($errors, 'order_phone'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Địa Chỉ</strong>
                                <span class="help">Nhập Địa Chỉ Giao Hàng</span>
                            </td>
                            <td>
                                <input type="text" id="order_address" value="<?php _val($filter, 'order_address'); ?>" size="50" maxlength="255"/>
                                <?php showError($errors, 'order_address'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ghi Chú</strong>
                                <span class="help">Nội dung ghi chú</span>
                            </td>
                            <td>
                                <textarea id="order_note" cols="100" rows="10"><?php _val($filter, 'order_note'); ?></textarea>
                                <?php showError($errors, 'order_note'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-product">
                
                <table class="form">
                    <tbody>
                         <tr>
                            <td>
                                <strong>Ổ Cứng</strong>
                                <span class="help">Loại ổ cứng mà khách hàng chọn cho đơn hàng này</span>
                            </td>
                            <td>
                                <select id="order_hdd_group_id">
                                    <?php foreach ($hdd_group as $item){ ?>
                                    <option <?php if ($item['hdd_group_id'] == $filter['order_hdd_group_id']) echo 'selected'; ?> value="<?php echo $item['hdd_group_id']; ?>"><?php echo $item['hdd_group_code']; ?></option>
                                    <?php } ?>
                                </select>
                                <?php showError($errors, 'order_hdd_group_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tìm kiếm sản phẩm</strong>
                            </td>
                            <td>
                                <input type="text" placeholder="Nhập id sản phẩm" id="add_order_prod_id" value="" size="50" maxlength="255"/>
                                <input type="text" placeholder="Số lượng" id="add_order_prod_number" value="1" size="10" maxlength="255" style="display: none"/>
                                <a class="button" id="click-add-order-product">Thêm</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="list">
                    <thead>
                        <tr>
                            <td width="10%" class="center">ID Sản Phẩm</td>
                            <td width="50%" class="left">
                                Tên Sản Phẩm
                            </td>
                            <td width="10%" class="left">
                                Số Lượng
                            </td>
                            <td width="10%" class="left">
                                Dung lượng
                            </td>
                            <td width="10%" class="left">
                                Giá
                            </td>
                            <td width="10%" class="left">
                                Thành Tiền
                            </td>
                            <td width="10%" class="right">Tùy Chọn</td>
                        </tr>
                    </thead>
                    <tbody id="content-order-product">
                        <?php foreach ($order_prod as $item){ ?>
                        <tr>
                            <td class="center"><?php echo $item['post_id']; ?></td>
                            <td class="left"><?php echo $item['post_title_vi']; ?></td>
                            <td class="left"><?php echo $item['number']; ?></td>
                            <td class="left"><?php echo $item['post_diskspace']; ?></td>
                            <td class="left"><input typte="text" data-init="<?php echo $item['post_price']; ?>" onchange="jsCart.change('post_price', '<?php echo $item['id']; ?>', this, '<?php echo $item['post_price']; ?>')" value="<?php echo (int)$item['post_price']; ?>"/></td>
                            <td class="left" id="total-price-<?php echo $item['id']; ?>"><?php echo number_format((int)$item['number']*(int)$item['post_price']); ?> VND</td>
                            <td class="right">
                                <a title="Xóa" onclick="return jsCart.remove(this, '<?php echo $item['id']; ?>')" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="center"></td>
                            <td class="left"></td>
                            <td class="left"></td>
                            <td class="left"></td>
                            <td class="left"><strong id="total-price"></strong></td>
                            <td class="right"></td>
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
                                <span class="help">Mỗi tin sẽ có một ID duy nhất</span>
                            </td>
                            <td>
                                <strong><?php echo $filter['order_id']; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ngày Đăng Ký</strong>
                                <span class="help">Thông tin ngày đăng và người đăng</span>
                            </td>
                            <td>
                                <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['order_add_date_time'])); ?></strong> 
                                <span>Bởi</span>: <strong><?php echo $filter['order_add_user_username']; ?></strong> <br/>
                            </td>
                        </tr>
                        <?php if ($filter['order_last_update_user_id']){ ?>
                        <tr>
                            <td>
                                <strong>Ngày Cập Nhật</strong>
                                <span class="help">Thông tin ngày cập nhật và người cập nhật cuối cùng</span>
                            </td>
                            <td>
                                <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['order_last_update_date_time'])); ?></strong>
                                <span>Bởi</span>:  <strong><?php echo $filter['order_last_update_user_username']; ?></strong> <br/>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php $this->security->set_action('order_edit'); ?>
            <?php $this->security->set_action('customer_get_by_id'); ?>
            
            <?php $this->security->set_action('order_product_add'); ?>
            <?php $this->security->set_action('order_product_delete'); ?>
            <?php $this->security->set_action('order_product_quick_edit'); ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // Title Page
        jsAdmin.changeTitle('Thêm Đơn Hàng Mới');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Menu
        jsAdmin.changeMenu('customer/order_lists');
        
        // Object Cart
        jsCart = 
        {
            // ID đơn hàng hiện tại
            orderId : '<?php echo $filter['order_id']; ?>',
            
            // Danh sách product đang có
            listProd : new Array(),
                    
            // Thêm product vào danh sách product đang có
            addProdExits : function (prod){
                jsCart.listProd.push(prod);
            },
            // Edit trực tiếp
            change : function (field, id, obj, init){
        
                init = $(obj).attr('data-init');
                var value = parseInt($(obj).val());
                if (isEmpty(value) || value < 1){
                    jAlert('Ban phải nhập là số', 'Lỗi dữ liệu');
                     $(obj).val(init);
                    return false;
                }
                
                var data = {
                    order_product_quick_edit : $('#order_product_quick_edit').val(),
                    field : field,
                    id : id,
                    value : value
                };
                
                jsAdmin.sendAjax('post', 'text', data, 'customer/order_product_edit', function (result)
                {
                    if (trim(result) == 'ERROR_TOKEN'){
                        $(obj).val(init);
                        jAlert('Lỗi Token, Vui lòng đăng nhập lại để tiếp tục thao tác', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_AUTH'){
                        $(obj).val(init);
                   
                        jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_NOT_FOUND'){
                        $(obj).val(init);
                    
                        jAlert('Sản Phẩm bạn chọn không tìm thấy', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_BAD_REQUEST'){
                        $(obj).val(init);
                    
                        jAlert('Lỗi xử lý dữ liệu, có thể bạn gửi thông tin bị sai', 'Lỗi');
                    }
                    else{
                        result = trim(result);
                        $(obj).attr('data-init', value);
                        for (var i = 0; i < jsCart.listProd.length; i++){
                            if (jsCart.listProd[i].id == id){
                                if (field == 'post_price'){
                                    jsCart.listProd[i].post_price = value;
                                }
                                else if (field == 'number'){
                                    jsCart.listProd[i].number = value;
                                }
                            }
                        }
                        $('#total-price-'+id).html(number_format(parseInt(result)) + ' VND');
                        jsCart.changeTotalPrice();
                    }
                });
            },
            changeTotalPrice : function (){
                var total = 0;
                for (var i = 0; i < jsCart.listProd.length; i++){
                    total += (parseInt(jsCart.listProd[i].number) * parseInt(jsCart.listProd[i].post_price));
                }
                
                $('#total-price').html(number_format(parseInt(total)) + ' VND');
            },
            // Thêm sản phẩm mới vào giỏ hàng
            addProd : function (post_id, number)
            {
                var flag = true;
                
                number = parseInt(number);
                post_id  = parseInt(post_id);
                
                if (isEmpty(number) || number < 1){
                    jAlert('Số lượng thêm phải lớn hơn 1', 'Lỗi số lượng');
                    return false;
                }
                
                if (isEmpty(post_id) || post_id < 1){
                    jAlert('ID sản phẩm bạn nhập không đúng', 'Lỗi số lượng');
                    return false;
                }
                
                for (var i = 0; i < jsCart.listProd.length; i++){
                    if (jsCart.listProd[i].post_id == post_id){
                        jAlert('Sản phẩm bạn chọn đã có trong giỏ hàng, ban muốn thêm thì hãy chỉnh lại số lượng', 'Lỗi trùng lặp sản phẩm');
                        return false;
                    }
                }
                
                var data = {
                    order_product_add : $('#order_product_add').val(),
                    number      : number,
                    order_id    : jsCart.orderId,
                    post_id     : post_id
                };
                
                jsAdmin.sendAjax('post', 'text', data, 'customer/order_product_add', function (result)
                {
                    if (trim(result) == 'ERROR_TOKEN'){
                        jAlert('Lỗi Token, Vui lòng đăng nhập lại để tiếp tục thao tác', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_AUTH'){
                        jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_NOT_FOUND'){
                        jAlert('Sản Phẩm bạn chọn không tìm thấy', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_BAD_REQUEST'){
                        jAlert('Lỗi xử lý dữ liệu, có thể bạn gửi thông tin bị sai', 'Lỗi');
                    }
                    else {
                        result = $.parseJSON(result);
                        jsCart.listProd.push({
                            order_id        : result.order_id,
                            post_id         : result.post_id,
                            post_title_vi   : result.post_title_vi,
                            post_title_en   : result.post_title_en,
                            post_price      : result.post_price,
                            number          : number,
                            id              : result.id
                        });
                        
                        var html = '<tr>';
                            html += '<td class="center">'+result.post_id+'</td>';
                            html += '<td class="left">'+result.post_title_vi+'</td>';
                            html += '<td class="left"><input data-init="'+result.number+'" typte="text" onchange="jsCart.change(\'number\', \''+result.id+'\', this, \''+result.number+'\')" value="'+result.number+'"/></td>';
                            html += '<td class="left"><input data-init="'+result.post_price+'" typte="text" onchange="jsCart.change(\'post_price\', \''+result.id+'\', this, \''+result.post_price+'\')" value="'+result.post_price+'"/></td>';
                            html += '<td class="left" id="total-price-'+result.id+'">'+number_format(result.post_price * number)+' VND</td>';
                            html += '<td class="right">';
                                html += '<a title="Xóa" idval="1" href="#" onclick="return jsCart.remove(this, '+result.id+')" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>';
                            html += '</td>';
                        html += '</tr>';

                        $('#content-order-product').html(html + $('#content-order-product').html());
                        jsCart.changeTotalPrice();
                    }
                });
            },
            // Xóa sanrp hẩm ra khỏi giỏ hàng
            remove : function (obj,id)
            {
                var data = {
                    order_product_delete : $('#order_product_delete').val(),
                    id      : id
                };
                
                jsAdmin.sendAjax('post', 'text', data, 'customer/order_product_delete', function (result)
                {
                    if (trim(result) == 'ERROR_TOKEN'){
                        jAlert('Lỗi Token, Vui lòng đăng nhập lại để tiếp tục thao tác', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_AUTH'){
                        jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_NOT_FOUND'){
                        jAlert('Sản Phẩm bạn chọn không tìm thấy', 'Lỗi');
                    }
                    else if (trim(result) == 'ERROR_SUCCESS'){
                        $(obj).parent().parent().remove();
                        var tmp = new Array();
                        for (var i = 0; i < jsCart.listProd.length; i++ ){
                            if (jsCart.listProd[i].id != id){
                                tmp.push(jsCart.listProd[i]);
                            }
                        }
                        
                        jsCart.listProd = tmp;
                        
                        jsCart.changeTotalPrice();
                    }
                    else {
                        jAlert('Lỗi xử lý dữ liệu, có thể bạn gửi thông tin bị sai', 'Lỗi');
                    }
                });
                return false;
            }
        };
        
        // Lặp qua sản phẩm để đưa vào danh sách đã load 
        <?php foreach ($order_prod as $item){ ?>
        jsCart.addProdExits({
            order_id        : '<?php echo $filter['order_id']; ?>',
            post_id         : '<?php echo $item['post_id'];  ?>',
            post_title_vi   : '<?php echo $item['post_title_vi'];  ?>',
            post_title_en   : '<?php echo $item['post_title_en'];  ?>',
            number          : '<?php echo $item['number'];  ?>',
            post_price      : '<?php echo $item['post_price'];  ?>',
            id              : '<?php echo $item['id'];  ?>'
        });
        <?php } ?>
        jsCart.changeTotalPrice();
        
        // ORDER PRODUCT
        // Filter Enter 
        $('#click-add-order-product').click(function ()
        {
            var id = $('#add_order_prod_id').val();
            var num = $('#add_order_prod_number').val();
            jsCart.addProd(id, num);
        });
        
        // Check Customer
        $('#order_customer_username').change(function ()
        {
            var data = {
                customer_username : $(this).val(),
                customer_get_by_id : $('#customer_get_by_id').val()
            };
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/customer_get_by_id', function (result)
            {
                if (trim(result) == 'ERROR_TOKEN'){
                    jAlert('Lỗi Token, Vui lòng đăng nhập lại để tiếp tục thao tác', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_AUTH'){
                    jAlert('Bạn không có quyền thực hiện thao tác này', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_NOT_FOUND'){
                    jAlert('Khách hàng bạn chọn không tìm thấy', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_CUS_BAND'){
                    jAlert('Khách hàng bạn chọn đã bị khóa không cho mua hàng', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else if (trim(result) == 'ERROR_BAD_REQUEST'){
                    jAlert('Lỗi xử lý dữ liệu, có thể bạn gửi thông tin bị sai', 'Lỗi');
                    $('#order_customer_username').val('');
                }
                else{
                    result = $.parseJSON(result);
                    $('#order_email').val(result.customer_email);
                    $('#order_phone').val(result.customer_phone);
                    $('#order_address').val(result.customer_address);
                    $('#order_fullname').val(result.customer_fullname);
                }
            });
        });
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'customer/order_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        // save
        $('#click-save').click(function()
        {
            var data = 
            {
        
                order_id : '<?php echo $filter['order_id']; ?>',
                order_customer_username   : trim($('#order_customer_username').val()),
                order_title   : trim($('#order_title').val()),
                order_status      : trim($('#order_status').val()),
                order_hdd_group_id: trim($('#order_hdd_group_id').val()),
                order_email      : trim($('#order_email').val()),
                order_phone      : trim($('#order_phone').val()),
                order_fullname   : trim($('#order_fullname').val()),
                order_note   : trim($('#order_note').val()),
                order_address    : trim($('#order_address').val()),
                order_edit        : $('#order_edit').val()
            };
                
            // Validate Username
            if (!is_username(data.order_customer_username)){
                jAlert('Tên đăng nhập dài từ 5 đến 15 ký tự', 'Lỗi dữ liệu');
                return false;
            }
            
            // Address
            if (isEmpty(data.order_title)){
                jAlert('Tiêu đề đơn hàng không được để trống', 'Lỗi dữ liệu');
                return false;
            }
            
            // Email
            if (!isEmail(data.order_email)){
                jAlert('Email không đúng định dạng', 'Lỗi dữ liệu');
                return false;
            }
            
            // Address
            if (isEmpty(data.order_address)){
                jAlert('Địa chỉ không thể thiếu được, hiểu hem? không có sao giao hàng ', 'Lỗi dữ liệu');
                return false;
            }
            
            jsAdmin.sendAjax('post', 'text', data, 'customer/order_edit', function (result)
            {
                result = trim(result);
                
                if (result == '101'){
                    jAlert('Có lỗi xảy ra trong quá trình xử lý', 'Lỗi xử lý');
                }
                else if (result == '100'){
                    jAlert('Cập nhật thành công', 'Thành công', function (){
                        jsAdmin.redirect('customer/order_edit?order_id=<?php echo $filter['order_id']; ?>');
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
