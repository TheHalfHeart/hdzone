// Pluggin lấy tất cả các thuộc tính của một thẻ 
(function($)
{
    // Attrs
    $.fn.attrs = function(attrs) {
        var t = $(this);
        if (attrs) {
            // Set attributes
            t.each(function(i, e) {
                var j = $(e);
                for (var attr in attrs) {
                    j.attr(attr, attrs[attr]);
                }
                ;
            });
            return t;
        } else {
            // Get attributes
            var a = {},
                    r = t.get(0);
            if (r) {
                r = r.attributes;
                for (var i in r) {
                    var p = r[i];
                    if (typeof p.value !== 'undefined')
                        a[p.nodeName] = p.value;
                }
            }
            return a;
        }
    };
})(jQuery);

/*--------------------------------------*/
/*
 * Author: Nguyễn Văn Cường
 * Author Email : thehalfheart@gmail.com
 *
 /*--------------------------------------*/
// - Plugin Multi Lang
(function($)
{
    $.fn.i18n = function(options)
    {
        var settings = {
            languages: {
                vi: 'Tiếng Việt',
                en: 'Tiếng Anh'
            },
            defaultLang: 'vi'
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
            string = string.replace(/(\r\n|\n|\r)/gm, "");
            var exp = new RegExp("<" + language_code + ">(.*?)<\/" + language_code + ">");
            var matches = string.match(exp);
            if (matches) {
                return matches[1];
            }
            return '';
        };

        generalElementMultilang = function(obj)
        {
            // Nếu số ngôn ngữ bé hơn 1 thì ẩn đi
            var count = 0;
            
            for (var langCode in settings.languages){
                count++;
            }
            
            // Lặp qua từng thẻ
            obj.each(function()
            {
                // Đại diện cho div wrapper hiện tại
                var obWrap = this;

                // Danh sách thuộc tính của div hiện tại
                var attrs = $(obWrap).attrs();

                // Kiểm tra thông số thẻ div có đầy đủ hay không
                if (!attrs.hasOwnProperty('id') || !attrs.hasOwnProperty('name') || !attrs.hasOwnProperty('type') || !attrs.hasOwnProperty('value')) {
                    alert('Vui lòng điền đẩy đủ id, name, type và value cho các div miltilanguage');
                    return;
                }

                // Xóa tất cả các thuộc tính của div cha
                for (var prop in attrs) {
                    $(obWrap).removeAttr(prop);
                }


                // Lặp qua từng ngôn ngữ và thêm thẻ span điều kiển
                for (var langCode in settings.languages)
                {
                    // Khai báo thẻ span
                    var span = document.createElement('span');
                    $(span).addClass(langCode).addClass('multilang');
                    $(span).attr('langcode', langCode);

                    // Thiết lập active cho thẻ span
                    if (langCode == settings.defaultLang) {
                        $(span).addClass('active');
                    }

                    // Thêm hình vào thẻ span
                    $(span).html('<img src="public/javascript/i18n/flags/' + langCode + '.png"/>');

                    // Đưa sự kiện click vào thẻ span
                    $(span).click(function()
                    {
                        // Thiết lập active
                        $(this).parent().children('span').removeClass('active');
                        $(this).addClass('active');

                        // Ngôn ngữ của span đang click
                        var lang = $(this).attr('langcode');

                        // Lặp tùy vào từng kiểu input mà có những xử lý khác nhau
                        switch (attrs['type'])
                        {
                            case "text" :
                                {
                                    $(this).parent().children('input[type="text"]').hide();
                                    $('#' + attrs['id'] + '_' + lang).show();
                                }
                            case "textarea" :
                                {
                                    $(this).parent().children('textarea').hide();
                                    $('#' + attrs['id'] + '_' + lang).show();
                                }
                            case "ckeditor" :
                                {
                                    $('.ckeditor-wrapper-miltilang' + attrs['id']).hide();
                                    $('#cke_div_' + attrs['id'] + '_' + lang).show();
                                }
                        }
                    });

                    // Đưa span vào div wrapper
                    $(obWrap).append(span);
                }

                // Thêm thẻ xuống hàng
                if (count > 1){
                    $(obWrap).append('<br/>');
                }
                // Khởi tạo input
                switch (attrs['type'])
                {
                    case "text" :
                        {
                            for (var langCode in settings.languages)
                            {
                                // Tạo input Text
                                var input = document.createElement('input');
                                $(input).attr('type', 'text');

                                // Lấy thuộc tính vào input
                                for (var prop in attrs)
                                {
                                    if (prop == 'name') {
                                        $(input).attr('name', attrs[prop] + '[' + langCode + ']');
                                    }
                                    else if (prop == 'id') {
                                        $(input).attr(prop, attrs[prop] + '_' + langCode);
                                    }
                                    else if (prop == 'value') {
                                        $(input).val(getI18n(attrs[prop], langCode));
                                    }
                                    else {
                                        $(input).attr(prop, attrs[prop]);
                                    }
                                }
                                
                                // Title To Slug And Slug To Title
                                if (attrs.hasOwnProperty('to-slug') && attrs.hasOwnProperty('to-title')){
                                    var toslug = attrs['to-slug'] + '_'+langCode;
                                    var totitle = attrs['to-title'] + '_'+langCode;
                                    $(input).attr('onchange', "fill_to_slug('"+totitle+"', '"+toslug+"');");
                                }

                                // Thiết lập trạng thái ẩn hay hiện cho input
                                if (langCode != settings.defaultLang) {
                                    $(input).hide();
                                }

                                // Thiết lập sự kiện onchange cho input
                                $(input).change(function()
                                {
                                    var value = '';
                                    for (var langCodeOnChange in settings.languages) {
                                        value += '<' + langCodeOnChange + '>';
                                        value += $('#' + attrs['id'] + '_' + langCodeOnChange).val();
                                        value += '</' + langCodeOnChange + '>';
                                    }
                                    $('#' + attrs['id']).val(value);
                                });

                                // Truyền input vào thẻ div
                                $(this).append(input);
                            }
                            break;
                        }
                    case "textarea" :
                        {
                            for (var langCode in settings.languages)
                            {
                                // Tạo input Text
                                var textarea = document.createElement('textarea');

                                // Lấy thuộc tính vào input
                                for (var prop in attrs)
                                {
                                    if (prop == 'name') {
                                        $(textarea).attr('name', attrs[prop] + '[' + langCode + ']');
                                    }
                                    else if (prop == 'id') {
                                        $(textarea).attr(prop, attrs[prop] + '_' + langCode);
                                    }
                                    else if (prop == 'value') {
                                        $(textarea).val(getI18n(attrs[prop], langCode).replace('<br>', "\n"));
                                    }
                                    else {
                                        $(textarea).attr(prop, attrs[prop]);
                                    }
                                }

                                // Thiết lập trạng thái ẩn hay hiện cho input
                                if (langCode != settings.defaultLang) {
                                    $(textarea).hide();
                                }

                                // Thiết lập sự kiện onchange cho input
                                $(textarea).change(function()
                                {
                                    var value = '';
                                    for (var langCodeOnChange in settings.languages) {
                                        value += '<' + langCodeOnChange + '>';
                                        value += $('#' + attrs['id'] + '_' + langCodeOnChange).val();
                                        value += '</' + langCodeOnChange + '>';
                                    }
                                    $('#' + attrs['id']).val(value);
                                });

                                // Truyền input vào thẻ div
                                $(this).append(textarea);
                            }
                            break;
                        }
                    case "ckeditor" :
                        {
                            for (var langCode in settings.languages)
                            {
                                // toolbar = full or short
                                if (!attrs['toolbar'] || !(attrs['toolbar'] == 'full' || attrs['toolbar'] == 'short')){
                                    alert('Bạn chưa chọn toolbar cho ckeditor là full hoặc short');
                                    return false;
                                }
                                
                                if ( (attrs['toolbar'] == 'full') && (!attrs['ck-module'] || !attrs['ck-id'] || !attrs['ck-start-path'])) {
                                    alert('Vui lòng chọn ck-module và ck-id cho ck-start-path');
                                    return false;
                                }
                                
                                // Tạo input Text
                                var textarea = document.createElement('textarea');

                                // Lấy thuộc tính vào input
                                for (var prop in attrs)
                                {
                                    if (prop == 'name') {
                                        $(textarea).attr('name', attrs[prop] + '[' + langCode + ']');
                                    }
                                    else if (prop == 'id') {
                                        $(textarea).attr(prop, attrs[prop] + '_' + langCode);
                                    }
                                    else if (prop == 'value') {
                                        $(textarea).val(getI18n(attrs[prop], langCode));
                                    }
                                    else if (prop != 'type') {
                                        $(textarea).attr(prop, attrs[prop]);
                                    }
                                }

                                // Hide Textarea
                                $(textarea).hide();

                                // Truyền input vào thẻ div
                                var div = document.createElement('div');
                                $(div).attr('id', 'cke_div_' + attrs['id'] + '_' + langCode).addClass('ckeditor-wrapper-miltilang' + attrs['id']).append(textarea);
                                $(this).append(div);

                                // Load Ckeditor
                                if (attrs['toolbar'] == 'full'){
                                    jsAdmin.loadCkeditor(attrs['id'] + '_' + langCode, attrs['ck-module'], attrs['ck-id'], attrs['ck-start-path']);
                                }
                                else{
                                    jsAdmin.loadCkeditorSort(attrs['id'] + '_' + langCode);
                                }
                                
                                // Thiết lập trạng thái ẩn hay hiện cho Ckeditor
                                if (langCode != settings.defaultLang) {
                                    $('#cke_div_' + attrs['id'] + '_' + langCode).hide();
                                }
                                
                                // Lang Change Event
                                CKEDITOR.instances[attrs['id'] + '_' + langCode].on('change', function() {
                                    var value = '';
                                    for (var langCodeOnChange in settings.languages) {
                                        value += '<' + langCodeOnChange + '>';
                                        value += CKEDITOR.instances[attrs['id'] + '_' + langCodeOnChange].getData();
                                        value += '</' + langCodeOnChange + '>';
                                    }
                                    $('#' + attrs['id']).val(value);
                                });
                            }
                            break;
                        }
                }

                // Thêm input hidden, là giá trị của các input ngôn ngữ trên
                var hidden = document.createElement('input');
                $(hidden).attr('type', 'hidden').attr('name', attrs['name']).attr('id', attrs['id']).val(attrs['value']);
                $(obWrap).append(hidden);

                // Thêm Class Wrapper
                $(this).addClass('lang-wrapper-field');
            });
            
            // Nếu có 1 ngôn ngữ thì ẩn
            if (count <= 1){
                $('span.multilang').hide();
            }
        };

        generalControl = function() 
        {
            for (var langCode in settings.languages)
            {
                var span = document.createElement('span');
                $(span).addClass('multilang');
                if (langCode == settings.defaultLang) {
                    $(span).addClass('active');
                }
                $(span).html('<img src="public/javascript/i18n/flags/' + langCode + '.png"/>');
                $(span).attr('langcode', langCode);
                $(span).click(function() {
                    var lang = $(this).attr('langcode');
                    $(this).parent().children('span').removeClass('active');
                    $(this).addClass('active');
                    $('.' + lang).click();
                });
                $('#control-language').append(span);
            }
            $('#control-language').addClass('main-control').addClass('lang-wrapper-field');
        };


        // Run
        generalElementMultilang(this);
        generalControl();
    };
})(jQuery);

// Get Input Lang
function i18n_val_text(data, key, field)
{
    field = field || key;
    var lang = jsAdmin.i18n.languages;
    for (code in lang){
        var value = $('#'+field+'_'+code).val();
        data[key+'_'+code] = value;
    }
    return true;
}

// Get Input Lang
function i18n_val_ckeditor(data, key, field)
{
    field = field || key;
    var lang = jsAdmin.i18n.languages;
    for (code in lang){
        var value = CKEDITOR.instances[field + '_'+code].getData();
        data[key+'_'+code] = value;
    }
    return true;
}

// Validate Input Lang
function i18n_is_empty(field)
{
    var lang = jsAdmin.i18n.languages;
    for (code in lang){
        var value = $('#'+field+'_'+code).val();
        if (isEmpty(value)){
            return true;
        }
    }
    return false;
}


// Validate Input Lang
function i18n_is_slug(field)
{
    var lang = jsAdmin.i18n.languages;
    for (code in lang){
        var value = $('#'+field+'_'+code).val();
        if (!is_slug(value)){
            return false;
        }
    }
    return true;
}
