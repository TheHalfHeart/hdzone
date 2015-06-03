/*--------------------------------------*/
/*
 * Author: Nguyễn Văn Cường
 * Author Email : thehalfheart@gmail.com
 *
/*--------------------------------------*/
// - Plugin Multi Lang
(function ($){
    $.fn.i18n = function (options)
    {    
        var settings = 
        {
            // class của div bao quanh nơi bạn muốn
            wrapperInputLang : 'wrapperInputLang',
            
            // - Class của div bao quanh bạn muốn đặt sau khi general,
            // - Bạn thường sử dụng để chỉnh css cho các button
            // - Public
            wrapperClass : "multilangWrapper",
            
            // - Danh sách code của ngôn ngữ
            // - public
            langCode : new Array(),
            
            // - Danh sách tên của ngôn ngữ tương ứng với code
            // - public
            langText : new Array(),
            
            // - Ngôn ngữ mặc định nó sẽ load lúc đầu
            // - public
            defaultLangCode : "vi",
            
            // - Đường dẫn đến thư mục hình ảnh những ngôn ngữ
            // - public
            imageBasePath  : "./public/javascript/i18n/flags",
            
            // - Thiết lập class cho hình ảnh
            // - public
            imageClass : "flag-icon",
            
            // - Thiết lập class cho button bao quanh hình ảnh
            // - public
            buttonClass : "",
            
            // - Bảng tạm lưu các input
            // - private
            input : new Array(),
            
            // - Bảng tạm lưu các button 
            // - private
            button : new Array(),
            
            // - Bảng tạm lưu Tên các đối tượng
            // - private
            hidden : new Array(),
            
            // - Vị trí của button bạn muốn hiển thị 
            // - public
            // - Don't support
            buttonPosition : "top",
            
            // - Bảng tạm lưu các controllers lang
            // - private
            controller : new Array(),
            
            // - Id mà bạn muốn đặt các trình controller
            // - Public
            idWrapperController : "",
            
            // - Class của button (contrroller)
            // - public
            buttonControllerClass : "",
            
            // - Class của hình ảnh (controller), nó nằm trong button
            // - public
            imageControllerClass : "",
            
            // - Kiểm tra xem có sử dụng ckeditor hay không
            haveCkeditor : false
        };
        
        settings = $.extend(settings, options);
        
        // - Lấy ra nội dung theo ngôn ngữ
        getI18n = function(string, language_code)
        {
                string = string || '';
                language_code = language_code || settings.defaultLangCode;
                if (language_code.length == 2) {
                    language_code = language_code.toLowerCase();
                }
                string = string.replace(/(\r\n|\n|\r)/gm,"");
                var exp = new RegExp("<"+language_code+">(.*?)<\/"+language_code+">");
                var matches = string.match(exp);
                if (matches) {
                    return matches[1];
                }
                return '';
        };
        
        quotes_to_entities = function(str){
                return str.replace(/'/g, '&#39;').replace(/"/g, '&quot;');
        };
        
        // - Lặp qua từng thẻ đa ngôn ngữ để xử lý
        // - Khởi tạo input
        // - Khởi tạo button
        // - Xóa attr của thẻ đa ngôn ngữ
        generalLanguage = function(obj)
        {
            obj.each(function ()
            {
                // - Khởi tạo danh sách button theo ngôn ngữ
                // - Hiển thị ra ngoài
                settings.button.push(new Array());
                for (i = 0; i < settings.langCode.length; i++) 
                {
                    var a = document.createElement('a');
                    $(a).attr('name'   , 'i18n-btn-' + settings.langCode[i]);
                    $(a).attr('class'   , settings.buttonClass + ' lang-' + settings.langCode[i] + ((settings.langCode[i] == settings.defaultLangCode) ? ' active ' : '') );
                    $(a).attr('title', settings.langText[i]);
                    //$(a).attr('style'   , (settings.langCode[i] == settings.defaultLangCode) ? 'opacity:1;' : 'opacity:0.3;  filter: alpha(opacity = 30);');
                    $(a).html('<img class="'+settings.imageClass+'" src="'+settings.imageBasePath+'/'+settings.langCode[i]+'.png"/>');
                    settings.button[settings.button.length-1].push(a);
                    $(this).append(a);
                }   
                
                $(this).append('<span style="height: 3px; display:block" />');
                
                // - Dựa vào type để
                // - Khởi tạo các input
                settings.input.push(new Array());
                switch ($(this).attr('type'))
                {
                    case "text-multilang" :{
                            for (var i = 0; i < settings.langCode.length; i++) 
                            {
                                var input = document.createElement('input');
                                $(input).attr('name'    , $(this).attr('name') ? $(this).attr('name') + "[" + settings.langCode[i] + "]" : "");
                                $(input).attr('type'    , 'textbox');
                                $(input).attr('class'   , $(this).attr('class') ? $(this).attr('class') : "");
                                $(input).attr('title', settings.langText[i]);
                                $(input).attr('size'    , $(this).attr('size') ? $(this).attr('size') : "");
                                $(input).attr('value'   , $(this).attr('value') ? getI18n($(this).attr('value'), settings.langCode[i]) : "");
                                $(input).attr('style'   , 'display:'+(settings.langCode[i] == settings.defaultLangCode ? 'block;' : 'none;'));
                                settings.input[settings.input.length-1].push(input);
                                $(this).append(input);
                            }
                            $(this).append('<input type="hidden" name="'+$(this).attr('name')+'" value="'+quotes_to_entities($(this).attr('value'))+'" />');
                            settings.hidden.push({
                                hidden_name : $(this).attr('name'),
                                hidden_type : 'input'
                            });
                            break;
                    }
                    case "textarea-multilang" : {
                            for (i = 0; i < settings.langCode.length; i++) 
                            {
                                var input = document.createElement('textarea');
                                $(input).attr('name'    , $(this).attr('name')  ? $(this).attr('name')  + "[" + settings.langCode[i] + "]"  : "");
                                $(input).attr('cols'   , $(this).attr('cols') ? $(this).attr('cols') : "");
                                $(input).attr('rows'    , $(this).attr('rows') ?  $(this).attr('rows') : "");
                                $(input).attr('class'   , $(this).attr('class') ? $(this).attr('class') : "");
                                $(input).attr('title', settings.langText[i]);
                                $(input).html($(this).attr('value') ? getI18n($(this).attr('value'), settings.langCode[i]) : "");
                                $(input).attr('style'   , 'display:'+(settings.langCode[i] == settings.defaultLangCode ? 'block;' : 'none;'));
                                settings.input[settings.input.length-1].push(input);
                                $(this).append(input);
                            }
                            $(this).append('<input type="hidden" name="'+$(this).attr('name')+'" value="'+quotes_to_entities($(this).attr('value'))+'" />');
                            settings.hidden.push({
                                hidden_name : $(this).attr('name'),
                                hidden_type : 'input'
                            });
                            break;
                    }
                    case "ckeditor-multilang" : {
                            for (i = 0; i < settings.langCode.length; i++) 
                            {
                                var input = document.createElement('div');
                                var content = $(this).attr('value') ? getI18n($(this).attr('value'), settings.langCode[i]) : "";
                                var name    = $(this).attr('name')  ? $(this).attr('name')  + "[" + settings.langCode[i] + "]": "";
                                var classname = $(this).attr('class') ? $(this).attr('class') : "";
                                var title   = settings.langText[i];

                                $(input).html('<textarea  name="'+name+'" class="'+classname+'" title="'+title+'">'+content+'</textarea>');
                                $(input).attr('style'   , 'display:'+(settings.langCode[i] == settings.defaultLangCode ? 'block;' : 'none;'));
                                
                                settings.input[settings.input.length-1].push(input);
                                
                                $(this).append(input);

                                if ($(this).attr('width'))
                                {
                                    CKEDITOR.config.width = $(this).attr('width');
                                }
                                if ($(this).attr('height'))
                                {
                                    CKEDITOR.config.height = $(this).attr('height');
                                }
                                CKEDITOR.replace(name);
                                CKEDITOR.instances[name].config.i_index = (settings.input.length - 1);
                            }
                            $(this).append('<input type="hidden" name="'+$(this).attr('name')+'" value="'+quotes_to_entities($(this).attr('value'))+'" />');
                            settings.hidden.push({
                                hidden_name : $(this).attr('name'),
                                hidden_type : 'ckeditor'
                            });
                            settings.haveCkeditor = true;
                            break;
                    }
                }
            });
        };
        
        setIndex = function(){
            for (var i = 0; i < settings.button.length; i++)
            {
                for (var j = 0; j < settings.button[i].length; j++)
                {
                    $(settings.button[i][j]).attr('i', i);
                    $(settings.button[i][j]).attr('j', j);
                    $(settings.input[i][j]).attr('i', i);
                    $(settings.input[i][j]).attr('j', j);
                }
            }
        };
        
        // - Đổi ngôn ngữ
        // - Khi click vào các button
        switchLang = function(){
            for (var i = 0; i < settings.button.length; i++)
            {
                for (var j = 0; j < settings.button[i].length; j++)
                {
                    $(settings.button[i][j]).click(function()
                    {
                        for (var t = 0; t < settings.langCode.length; t++)
                        {
                            $(settings.input[$(this).attr('i')][t]).hide();
                            //$(settings.button[$(this).attr('i')][t]).removeClass('active').attr('style', 'opacity:0.3; filter: alpha(opacity = 30);');
                            $(settings.button[$(this).attr('i')][t]).removeClass('active');
                        }
                        $(settings.input[$(this).attr('i')][$(this).attr('j')]).show();
                        //$(this).addClass('active').attr('style', 'opacity:1');
                        $(this).addClass('active');
                    });
                }
            }
        };
        
        // - Lấy tất cả các ngôn ngữ lưu vào một file hidden
        // - Khi nhập liệu vào các ô textbox
        // - Function này đặt sau function switchLang
        changeText = function(){
            for (var i = 0; i < settings.input.length; i++)
            {
                for (var j = 0; j < settings.input[i].length; j++)
                {
                    if (settings.hidden[i].hidden_type == 'input')
                    {
                        $(settings.input[i][j]).change(function()
                        {
                            var text = '';
                            var i_index = $(this).attr('i');
                            for (var n = 0; n < settings.langCode.length; n++)
                            {
                                text += '<' + settings.langCode[n] + '>';
                                text += $(settings.input[i_index][n]).val();
                                text += '</' + settings.langCode[n] + '>';
                            }
                            $('input[name='+settings.hidden[i_index].hidden_name+']').val(text);
                        });
                    }
                }
            }
            
            if (settings.haveCkeditor)
            {
                for (ins in CKEDITOR.instances)
                {
                    CKEDITOR.instances[ins].on('change', function(){
                        var text = '';
                        var i = this.config.i_index;
                        for (var j = 0; j < settings.langCode.length; j++)
                        {
                            var ins_tmp = settings.hidden[i].hidden_name + '[' + settings.langCode[j] + ']';
                            if (CKEDITOR.instances.hasOwnProperty(ins_tmp))
                            {
                                text += '<' + settings.langCode[j] +'>';
                                text += CKEDITOR.instances[ins_tmp].getData();
                                text += '</' + settings.langCode[j] + '>';
                            }
                        }
                        $('input[name='+settings.hidden[i].hidden_name+']').val(text);
                    });
                }
            }
            
        };
        
        // - Sau khi thực hiện general xong
        // - Xóa tất cả các thông tin của thẻ đa ngôn ngữ để khỏi bị trùng id, trùng tên
        cleanAttr = function(obj){
            $(obj).each(function() {
                var tmpDivRemove = new Array();
                $.each(this.attributes, function() {
                    tmpDivRemove.push(this.name);
                });
                for (var i = 0; i < tmpDivRemove.length; i++)
                {
                    $(this).removeAttr(tmpDivRemove[i]);
                }
            });
            $(obj).css('overflow', 'hidden').attr('class', settings.wrapperClass);
        };
        
        // - Tạo các trình điều khiển ngôn ngữ
        setupController  = function()
        {
            var controller = $('#' + settings.idWrapperController);
            for (var i = 0; i < settings.langCode.length; i++) 
            {
                var a = document.createElement('a');
                $(a).attr('id', settings.langCode[i]);
                $(a).attr('title', settings.langText[i]);
                $(a).attr('class'   , settings.buttonControllerClass);
                $(a).html('<img class="'+settings.imageControllerClass+' flag-icon" src="'+settings.imageBasePath+'/'+settings.langCode[i]+'.png"/>');
                settings.controller.push(a);
                controller.append(a);
            }
            for (i = 0 ; i < settings.controller.length; i++)
            {
                $(settings.controller[i]).click(function(){
                    $('*[name=i18n-btn-' + $(this).attr('id') + "]").click();
                });
            }
        };
        
        setupInputLangList = function (){
            var html = '';
            for (var i = 0; i < settings.langCode.length; i++){
                html += '<input type="checkbox" value="1" name="'+settings.langCode[i]+'"/> ' + settings.langText[i] + ' ';
            }
            $('#' + settings.wrapperInputLang).html(html);
        };
        
        generalLanguage(this);
        setIndex();
        switchLang();
        changeText();
        cleanAttr(this);
        setupController();
        setupInputLangList();
    };
})(jQuery);
