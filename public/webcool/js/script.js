var ie = false;
var mobileDevice = false;
var smallDevice = false;
var androidDevice = false;
if(
	navigator.userAgent.match(/Android/i) ||
	navigator.userAgent.match(/webOS/i) ||
	navigator.userAgent.match(/iPhone/i) ||
	navigator.userAgent.match(/iPad/i) ||
	navigator.userAgent.match(/iPod/i))
{
	mobileDevice = true;
}
if ($.browser.msie && $.browser.version < 9) { 
    ie = true;	
	var e = ("article,aside,figcaption,figure,footer,header,hgroup,nav,section,time").split(',');
	for (var i = 0; i < e.length; i++) {
		document.createElement(e[i]);
	}	
}
if (navigator.userAgent.match(/Android/i)) {
	var androidDevice = true;
	$('html').addClass('android');
}
if (navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i)) {
	var smallDevice = true;
	$('html').addClass('smallDevice');
}

$(document).ready(function() {
	
	//Filter
	if ($('.gallery_block').html()) {
		$('.filter_toggler').addClass('toggled');
		$('.header_filter').slideDown();
	}
	
	//Menu SetUp and animation
	$('.menu').find('li:has(ul)').addClass('has-menu');
	$('.menu').children('li.has-menu').addClass('level1');
	$('.menu').find('li.level1').find('ul.sub-menu').children('li.has-menu').addClass('level2');
	$('ul.menu').superfish();
	
	//MobileMenu
	$('.menu').find('li').each(function(){
		cur_link = $(this).children("a");
		if (!$(this).parent('ul').hasClass('sub-menu')) {
			if ($(this).hasClass('current-menu-item')) {
				$('#mobile_select').append('<option selected value="'+cur_link.attr("href")+'">'+cur_link.text().toUpperCase()+'</option>');
			} else {
				$('#mobile_select').append('<option value="'+cur_link.attr("href")+'">'+cur_link.text().toUpperCase()+'</option>');
			}			
		}
		else {
			if ($(this).hasClass('current-menu-item')) {			
				$('#mobile_select').append('<option selected value="'+cur_link.attr("href")+'"> -- '+cur_link.text()+'</option>');
			} else {
				$('#mobile_select').append('<option value="'+cur_link.attr("href")+'"> -- '+cur_link.text()+'</option>');
			}
		}
	});
	
	$('#mobile_select').change(function(){
		select_val = $(this).val();
		window.location = select_val;
	});
	
	//Input and Textarea Click-Clear
	$('input[type=text]').focus(function() {
		if($(this).attr('readonly') || $(this).attr('readonly') == 'readonly') return false;
		if ($(this).val() === $(this).attr('title')) {
				$(this).val('');
		}   
		}).blur(function() {
		if($(this).attr('readonly') || $(this).attr('readonly') == 'readonly') return false;
		if ($(this).val().length === 0) {
			$(this).val($(this).attr('title'));
		}                        
	});	
	$('textarea').focus(function() {
		if ($(this).text() === $(this).attr('title')) {
				$(this).text('');
			}        
		}).blur(function() {
		if ($(this).text().length === 0) {
			$(this).text($(this).attr('title'));
		}                        
	});	
	//FeedBack Form
	$('.content_block').find('.form_field').each(function(){
		$(this).width($(this).parent('form').width()-12);				
	});	
	$('.feedback_go').click(function(){
		var par = $(this).parents(".feedback_form");
		var name = par.find(".field-name").val();
		var email = par.find(".field-email").val();
		var message = par.find(".field-message").val();
		var subject = par.find(".field-subject").val();
		if (email.indexOf('@') < 0) {			
			email = "mail_error";
		}
		if (email.indexOf('.') < 0) {			
			email = "mail_error";
		}
		$.ajax({
			url: "mail.php",
			type: "POST",
			data: { name: name, email: email, message: message, subject: subject },
			success: function(data) {
				$('.ajaxanswer').hide().empty().html(data).show("slow");
		  }
		});
	});
	
	//MapToggler
	
	//Portfolio
	$('.portfolio_content').each(function(){
		$(this).css('margin-top', -($(this).height()/2)+'px');	
	});
	var $container = $('.portfolio_block');
	$('.btn_load_more').click(function() {
		var count = $(this).attr('data-count');
		var $newEls = $(fakeElement.getGroup(count));
		$container.isotope('insert', $newEls, function() {
			//console.log('shyt');
			$container.isotope('reLayout');
			$('.portfolio_content').each(function(){
				$(this).css('margin-top', -($(this).height()/2)+'px');
				$('.prettyPhotoLoaded').prettyPhoto({
                                    changepicturecallback : function(){
                                        var twitterDiv = jQuery('.pp_social');
                                        twitterDiv.remove();
                                    }
                                });
			});			
		});
		return false;
	});	
	
	//FilterToggler
	$('.filter_toggler').click(function(){
		$(this).toggleClass('toggled');
		$('.header_filter').slideToggle(400);
	});		
});	

$(window).load(function(){
	/*Landing*/
	if ($('.landing_logo').html()) {
		setTimeout("$('.landing_logo').removeClass('hided')",500);
		setTimeout("$('.landing_enter').removeClass('hided')",1500);
	}
	
	setTimeout("$('#preloader').animate({'opacity' : '0'},300,function(){$('#preloader').hide()})",800);
	setTimeout("$('footer').animate({'opacity' : '1'},500)",800);
	setTimeout("$('.content_wrapper').animate({'opacity' : '1'},500)",800);
	setTimeout("$('.gallery_block').animate({'opacity' : '1'},500)",1800);
	
	footer_setup();
	$('.carouselslider').each(function(){
		dispNum = parseInt($(this).attr('data-count'));
		if ($(window).width()< 485) {
			dispNum = 1;
		}
		$(this).addClass('items'+dispNum);
		$(this).carousel({
			dispItems: dispNum,
			showEmptyItems: 0			
		});				
	});
	if (!mobileDevice) {
		$('.socials').find('a').tipsy({gravity: 's', fade: true});
	}
	//temp form HTML
	$('.accordion').accordion({
		autoHeight: false,
		active: -1,
		collapsible: true
	});
	$('.shortcode_toggles_item_title').click(function(){
		$(this).next().slideToggle();
		$(this).toggleClass('ui-state-active');
	});
	$('.commentlist').find('.stand_comment').each(function(){
		set_width = $(this).width() - $(this).find('.commentava').width() - 25;
		$(this).find('.thiscommentbody').width(set_width);
	});	
	//End Of Temp
	//SideBar Scripts
	if($('aside.sidebar').html()) {
		$('aside.sidebar').find('img').each(function(){
			$(this).wrap('<div class="img_wrapper"></div>')
			$(this).after('<div class="img_fadder" />');
		});
	}
	
	//Portfolio
	$('.prettyPhoto').prettyPhoto({
            changepicturecallback : function(){
                                        var twitterDiv = jQuery('.pp_social');
                                        twitterDiv.remove();
                                    }
        });
	
	if ($('.columns1').html()) {
		$('.portfolio_block').isotope('reLayout');
	}
		
	$('.camera_slider_run').each(function(){
		$(this).camera({
			alignment: 'center',
			height: '38.61%',
			fx: 'scrollHorz',
			navigationHover: false,
			loader: 'none' /*pie, bar, none*/,
			mobileNavHover: true,
			time: 4000
		});
		//$(this).cameraStop();		
	});
	
	//Masonry Blog
	$('.masonry_blog_slider').each(function(){
		$(this).camera({
			alignment: 'center',
			height: '50%',
			fx: 'scrollLeft',
			navigationHover: false,
			loader: 'none' /*pie, bar, none*/,
			mobileNavHover: true,
			time: 4000
		});
		//$(this).cameraStop();
	});
//	if ($(window).width() > 485) {
//		$('.blog-audio').each(function(){
//			selector = '#'+$(this).next('.jp-audio').attr('id');
//			$(selector).find('.jp-progress').width($(selector).width()-144);
//			$('#'+$(this).attr('id')).jPlayer({
//				ready: function (event) {
//					$('#'+$(this).attr('id')).jPlayer("setMedia", {
//						mp3: $(this).attr("data-mp3"),
//						oga: $(this).attr("data-ogg")
//					});						
//				},
//				play: function() { // To avoid both jPlayers playing together.
//					$('#'+$(this).attr('id')).jPlayer("pauseOthers");
//				},					
//				swfPath: "js",
//				supplied: "mp3, oga",
//				cssSelectorAncestor: selector,
//				wmode: "window"		
//			});
//		});		
//	}
});
$(window).resize(function(){
	footer_setup(); 
	//$('.blog-audio').find('.jp-progress').width($('.blog-audio').find('.jp-audio').width()-144);
});

function footer_setup() {
	$('.content_wrapper').css('min-height', $(window).height()-$('header').height()-$('footer').height()-$('.header_filter').height()-parseInt($('header').css('border-top-width'))-parseInt($('header').css('border-bottom-width'))+'px');
}
jQuery.fn.TabScroll = function() {
	var scrollStartPos = 0;
	max_scroll = -1*($(this).width()-$('.filter_navigation').width());
	$(this).css('right', max_scroll+'px');
    $(this).bind('touchstart', function(event) {										
        var e = event.originalEvent;
        scrollStartPos = parseInt($(this).css('right')) + e.touches[0].pageX;
    });
    $(this).bind('touchmove', function(event) {										   	
        var e = event.originalEvent;			
        $(this).css('right', (scrollStartPos - e.touches[0].pageX)+'px');
		if (parseInt($(this).css('right')) > 0) {
			$(this).css('right', '0px');
		}
		if (parseInt($(this).css('right')) < max_scroll) {
			$(this).css('right', max_scroll+'px');
		}
        e.preventDefault();
    });
    return this;	
};
    
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
        loadData: function(obj) 
        {
            if (!site.paging.have_paging){
                return false;
            }

            if (site.paging.sendding) {
                return false;
            }

            if (site.paging.is_max_record) {
                $(obj).parent().remove();
                return false;
            }

            site.paging.sendding = true;
            
            $(obj).addClass('loadding');

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
                $(obj).removeClass('loadding');
                site.paging.sendding = false;
            });
        }
    }
};