// Có sử dụng jquery

var site = 
{
    config : 
    {
        base_url    : '',
        template_url  : '',
        csrf_token  : '',
        csrf_val    : '',
        validate    : true
    },
    helper : {
        scrollTo : function (element){
            $('html, body').animate({
                scrollTop: parseInt($(element).offset().top)
            }, 500);
        }
    },
    contact : 
    {
        sendding : false,
                
        send : function ()
        {
            
            if (site.contact.sendding){
                jAlert('Hệ thống đang gửi liên hệ của bạn', "Vui lòng chờ ...");
                return false;
            }
            
            // Data
            var data = {
                contact_title   : $('#contact_title').val(),
                contact_phone   : $('#contact_phone').val(),
                contact_fullname: $('#contact_fullname').val(),
                contact_address : $('#contact_address').val(),
                contact_email   : $('#contact_email').val(),
                contact_content : $('#contact_content').val(),
                contact_captcha : $('#contact_captcha').val(),
                action_contact_add : $('#action_contact_add').val()
            };
            data[site.config.csrf_token] = site.config.csrf_val;
            
            // Validate
            if (isEmpty(data.contact_title)){
                jAlert("Tiêu đề không được để trống", "Lỗi tiêu đề");
                return false;
            }
            
            if (isEmpty(data.contact_fullname)){
                jAlert("Tên của bạn không được để trống", "Lỗi tên của bạn");
                return false;
            }
            
            if (isEmpty(data.contact_email)){
                jAlert("Email không được để trống", "Lỗi email");
                return false;
            }
            
            if (!isEmail(data.contact_email)){
                jAlert("Email không đúng định dạng", "Lỗi email");
                return false;
            }
            
            if (isEmpty(data.contact_phone)){
                jAlert("Số điện thoại không được để trống", "Lỗi số điện thoại");
                return false;
            }
            
            if (!/^[0-9]+$/.test(data.contact_phone)){
                jAlert("Số điện thoại phải là các chữ số", "Lỗi số điện thoại");
                return false;
            }
            
            if (isEmpty(data.contact_address)){
                jAlert("Địa chỉ của bạn không được để trống", "Lỗi địa chỉ");
                return false;
            }
            
            if (isEmpty(data.contact_captcha)){
                jAlert("Bạn chưa nhập mã bảo vệ", "Lỗi mã bảo vệ");
                return false;
            }
            
            site.contact.sendding = true;
            
            $.ajax(
            {
                url : site.config.base_url + 'ajax/contact_add',
                data : data,
                type : "post",
                dataType : 'text',
                success : function(result)
                {
                    result = $.trim(result);
                    
                    var obj = $.parseJSON(result);
                    
                    if (!obj || !obj.hasOwnProperty('type')){
                        jAlert("Dường như bạn đang tấn công website ?", "Cảnh báo");
                    }
                    else if (obj.type == 'Success'){
                        jAlert("Gửi liên hệ thành công", "Thành công", function(){
                            window.location.href = window.location.href;
                        });
                    }
                    else if (obj.type == 'Error')
                    {
                        if (obj.hasOwnProperty('bad_captcha')){
                            jAlert("Mã captcha bạn nhập không đúng", "Lỗi captcha");
                        }
                        else {
                            jAlert("Vui lòng nhập đúng dữ liệu", "Thất bại");
                        }
                    }
                },
                error : function (){
                    jAlert("Hệ thống gửi thất bại, vui lòng thử lại sau", "Lỗi hệ thống");
                }
            }).always(function(){
                site.contact.sendding = false;
            });
        }
    },
    
    shop : 
    {
        sendding : false,
        add : function (id, num)
        {
            // Add
            var data = {
                product_id      : parseInt(id) | 0,
                number          : parseInt(num) | 1,
                action_shop_add : $('#action_shop_add').val()
            };
            
            // Validate
            if (data.product_id < 1){
                jAlert('Sản phẩm bạn chọn không tìm thấy', 'Lỗi sản phẩm');
                return false;
            }
            
            if (data.number < 1){
                jAlert('Số lượng sản phẩm phải hơn hơn 0', 'Lỗi sản phẩm');
                return false;
            }
            
            // Send
            $.ajax(
            {
                url : site.config.base_url + 'ajax/shop_add',
                data : data,
                type : "post",
                dataType : 'text',
                success : function(result)
                {
                    result = $.trim(result);
                    
                    var obj = $.parseJSON(result);
                    
                    if (!obj || !obj.hasOwnProperty('type')){
                        jAlert("Dường như bạn đang tấn công website ?", "Cảnh báo");
                    }
                    else if (obj.type == 'Success'){
                        jConfirm('Ban có muốn đến giỏ hàng?', 'Thêm thành công', function (r){
                            if (r){
                                window.location = site.config.base_url + 'gio-hang.html';
                            }
                        });
                        $('.show_cart_num').html(obj.response);
                    }
                    else if (obj.type == 'Error')
                    {
                        if (obj.hasOwnProperty('bad_request')){
                            jAlert("Yêu cầu của bạn không chính xác", "Lỗi gửi yêu cầu");
                        }
                    }
                },
                error : function (){
                    jAlert("Hệ thống gửi thất bại, vui lòng thử lại sau", "Lỗi hệ thống");
                }
            }).always(function(){});
            return false;
        },
        update : function (object)
        {
            // Add
            var data = 
            {
                field           : $(object).attr('data-field'),
                product_id      : $(object).attr('data-id'),
                value           : $(object).val(),
                action_shop_update : $('#action_shop_update').val()
            };
            
            // Validate
            if (data.product_id < 1){
                jAlert('Sản phẩm bạn chọn không tìm thấy', 'Lỗi sản phẩm');
                return false;
            }
            
            if (data.field == 'number')
            {
                data.value = parseInt(data.value);
                if (data.value < 1){
                    jAlert('Số lượng sản phẩm phải lớn hơn 0', 'Lỗi số lượng');
                    return false;
                }
            }
            else {
                 jAlert('Thông tin bạn cần sửa không tìm thấy', 'Lỗi thông tin cập nhật');
                 return false;
            }
            
            // Send
            $.ajax(
            {
                url : site.config.base_url + 'ajax/shop_update',
                data : data,
                type : "post",
                dataType : 'text',
                success : function(result)
                {
                    $(object).attr('data-init', data.value);
                    site.shop.showTotalPrice(data.product_id);
                    site.shop.showOrderPrice();
                    
                },
                error : function (){
                    $(object).val($(object).attr('data-init'));
                    jAlert("Hệ thống gửi thất bại, vui lòng thử lại sau", "Lỗi hệ thống");
                }
            }).always(function(){});
        },
        getTotalPrice : function (id){
            var number  = parseInt($.trim($('.order-row-number-'+id).val()));
            var price   = parseInt($.trim($('.order-row-price-'+id).attr('data-val')));
            return number * price;
        },
        showTotalPrice : function (id){
            var total = site.shop.getTotalPrice(id);
            $('.order-row-total-price-'+id).attr('data-val', total).html(number_format(total) + ' đ');
        },
        remove : function (id, obj)
        {
            var data = {
                product_id : parseInt(id),
                action_shop_delete : $('#action_shop_delete').val()
            };
            
            // Validate
            if (data.product_id < 1){
                jAlert('Sản phẩm bạn chọn không tìm thấy', 'Lỗi sản phẩm');
                return false;
            }
            
            // Send
            $.ajax(
            {
                url : site.config.base_url + 'ajax/shop_remove',
                data : data,
                type : "post",
                dataType : 'text',
                success : function(result)
                {
                    $(obj).parent().remove();
                    site.shop.showOrderPrice();
                },
                error : function (){
                    jAlert("Hệ thống gửi thất bại, vui lòng thử lại sau", "Lỗi hệ thống");
                }
            }).always(function(){});
        },
        order : function ()
        {
            if (site.shop.sendding){
                jAlert('Hệ thống đang gửi đơn hàng của bạn', "Vui lòng chờ ...");
                return false;
            }
            
            var data = {
                order_title     : $('#order_title').val(),
                order_phone     : $('#order_phone').val(),
                order_email     : $('#order_email').val(),
                order_address   : $('#order_address').val(),
                order_fullname  : $('#order_fullname').val(),
                order_note      : $('#order_note').val(),
                order_captcha   : $('#order_captcha').val(),
                action_shop_order   : $('#action_shop_order').val()
            };
            
            // Validate
            if (isEmpty(data.order_title)){
                jAlert("Tiêu đề không được để trống", "Lỗi tiêu đề");
                return false;
            }
            
            if (isEmpty(data.order_phone)){
                jAlert("Số điện thoại không được để trống", "Lỗi số điện thoại");
                return false;
            }
            
            if (!/^[0-9]+$/.test(data.order_phone)){ alert(data.order_phone);
                jAlert("Số điện thoại phải là các chữ số", "Lỗi số điện thoại");
                return false;
            }
            
            if (isEmpty(data.order_fullname)){
                jAlert("Tên của bạn không được để trống", "Lỗi tên của bạn");
                return false;
            }
            
            if (isEmpty(data.order_address)){
                jAlert("Địa chỉ của bạn không được để trống", "Lỗi địa chỉ");
                return false;
            }
            
            if (isEmpty(data.order_email)){
                jAlert("Email không được để trống", "Lỗi email");
                return false;
            }
            
            if (!isEmail(data.order_email)){
                jAlert("Email không đúng định dạng", "Lỗi email");
                return false;
            }
            
            if (isEmpty(data.order_captcha)){
                jAlert("Bạn chưa nhập mã bảo vệ", "Lỗi mã bảo vệ");
                return false;
            }
            
            site.shop.sendding = true;
            
            $.ajax(
            {
                url : site.config.base_url + 'ajax/shop_order',
                data : data,
                type : "post",
                dataType : 'text',
                success : function(result)
                {
                    result = $.trim(result);
                    
                    var obj = $.parseJSON(result);
                    
                    if (!obj || !obj.hasOwnProperty('type')){
                        jAlert("Dường như bạn đang tấn công website ?", "Cảnh báo");
                    }
                    else if (obj.type == 'Success'){
                        jAlert("Gửi đơn hàng thành công, chúng tôi sẽ liên hệ sớm với bạn", "Thành công", function (){
                            window.location.href = window.location.href;
                        });
                    }
                    else if (obj.type == 'Error')
                    {
                        if (obj.hasOwnProperty('bad_captcha')){
                            jAlert("Mã captcha bạn nhập không đúng", "Lỗi captcha");
                        }
                        else {
                            jAlert("Vui lòng nhập đúng dữ liệu", "Thất bại");
                        }
                    }
                },
                error : function (){
                    jAlert("Hệ thống gửi thất bại, vui lòng thử lại sau", "Lỗi hệ thống");
                }
            }).always(function(){
                site.shop.sendding = false;
            });
        },
        openOrderForm : function (){
            $("#order-open-form").click(function(){
                $("#order-form").show();
                site.helper.scrollTo("#order-form");
            });
        },
        getOrderPrice : function (){
            var ele = $('.total-price');
            var total = 0;
            for (var i = 0; i < ele.length; i++){
                total += parseInt($.trim($(ele[i]).attr('data-val')));
            }
            return total;
        },
        showOrderPrice : function (){
            $('#order-price').html(number_format(site.shop.getOrderPrice()) + ' đ');
        }
    },
    paging : {
        base_url: '',
        slug_url: '',
        current_page: 1,
        have_paging : false,
        is_max_record: false,
        sendding: false,
        element_append: '',
        loadData: function() 
        {
            if (!site.paging.have_paging){
                return false;
            }

            if (site.paging.sendding) {
                return false;
            }

            if (site.paging.is_max_record) {
                return false;
            }

            site.paging.sendding = true;
            
            $.ajax({
                url: site.config.base_url + site.paging.slug_url + '/page/' + (site.paging.current_page + 1),
                type: 'get',
                dataType: 'text',
                cache: true,
                async: true,
                success: function(result) {
                    $(site.paging.element_append).append(result);
                    site.paging.current_page = (site.paging.current_page + 1);
                },
                error: function() {
                    site.paging.is_max_record = true;
                }
            }).always(function() {
                site.paging.sendding = false;
            });
        }
    }
};

