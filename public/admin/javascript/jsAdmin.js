
var jsAdmin = 
{
        i18n : {
            languages : {},
            defaultLang : ""
        },
        userName    : '',
        userAvata   : '',
        userId      : '',
        isManager   : false,
        
        csrfHash    : '',
        baseUrl     : '',
        fullUrl     : '',
        linkApi     : '',
        urlBack     : 
        {
            level1  : '',
            level2  : '',
            level3  : '',
            level4  : '',
            level5  : ''
        },
        editting : false,
        ajaxCalling : false,
        loadLang : function (){
             $('div.multilang').i18n({
                languages : jsAdmin.i18n.languages,
                defaultLang : jsAdmin.i18n.defaultLang
            });
        },
        ckeditor : 
        {
            reset : function (){
                jsAdmin.ckeditor.toolbar = [
                                    ['Source','Preview','Templates'],
                                    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
                                    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                    '/',
                                    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                                    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
                                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                    ['BidiLtr', 'BidiRtl' ],
                                    ['Link','Unlink','Anchor'],
                                    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
                                    '/',
                                    ['Styles','Format','Font','FontSize'],
                                    ['TextColor','BGColor'],
                                    ['Maximize','ShowBlocks','Syntaxhighlight']
                       ];
            },
            extraPlugins : "onchange",
            lang    : "vi",
            skins   : "",
            toolbar : [],
            uicolor : "",
            filebrowserBrowseUrl      : "",
            filebrowserImageBrowseUrl : "",
            filebrowserImageUploadUrl : "",
            filebrowserUploadUrl      : "",
            filebrowserFlashBrowseUrl : "",
            filebrowserFlashUploadUrl : ""
        },
        loadCkeditor : function (listId, folder, id, start){
            jsAdmin.ckeditor.reset();
            jsAdmin.ckeditor.filebrowserBrowseUrl       = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Files?type=Files&start='+start;
            jsAdmin.ckeditor.filebrowserUploadUrl       = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Files?command=QuickUpload&type=Files&start='+start;
            jsAdmin.ckeditor.filebrowserImageBrowseUrl  = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Images/?type=Images&start='+start;
            jsAdmin.ckeditor.filebrowserImageUploadUrl  = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Images/?command=QuickUpload&type=Images&start='+start;
            jsAdmin.ckeditor.filebrowserFlashBrowseUrl  = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Flash?type=Flash&start='+start;
            jsAdmin.ckeditor.filebrowserFlashUploadUrl  = jsAdmin.linkApi+'/ckfinder/'+folder+'/html/'+id+'/Flash?command=QuickUpload&type=Flash&start='+start;
            var arr = listId.split(',');
            for (var i = 0; i < arr.length; i++){
                CKEDITOR.replace(arr[i]);
            }
        },
        loadCkeditorSort : function (listId){
            jsAdmin.ckeditor.toolbar = [
                        ['Source','-','TextColor','Bold','Italic','Underline','Strike','Link','Unlink']
            ];
            var arr = listId.split(',');
            for (var i = 0; i < arr.length; i++){
                CKEDITOR.replace(arr[i]);
            }
        },
        ckfinder : 
        {
            connectorPath : "",
            readOnly      : false,
            brownServer : function(inputID, thumnailID, startupPath)
            {
                startupPath = startupPath || 'Images:/';
                
                var finder = new CKFinder();
                
                finder.basePath = './public/ckfinder/';
                
                finder.startupPath = startupPath;

                finder.connectorPath = this.connectorPath;
                
                finder.removePlugins    = 'help';
                finder.language = 'en';
                finder.readOnly = this.readOnly;
                
                finder.selectActionFunction = function(fileUrl, data )
                {
                    $('#' + data["selectActionData"] ).val(fileUrl);
                    var html ='<img src="'+fileUrl+'" /><div><a href="#" onclick="return jsAdmin.ckfinder.remove(\''+inputID+'\', \''+thumnailID+'\');">Xóa</a></div>';
                    $('#' +thumnailID).html(html);
                };

                finder.selectActionData = inputID;

                finder.popup();
            },
            brownServer1 : function(obj, startupPath)
            {
                startupPath = startupPath || 'Images:/';
                
                var finder = new CKFinder();
                
                finder.basePath = './public/ckfinder/';
                
                finder.startupPath = startupPath;

                finder.connectorPath = this.connectorPath;
                
                finder.removePlugins    = 'help';
                finder.language = 'en';
                finder.readOnly = this.readOnly;
                
                finder.selectActionFunction = function(fileUrl, data )
                {
                    $(obj).parent().parent().find('img').attr('src', fileUrl);
                };
                
                finder.popup();
            },
            
            inputChange : function(inputID, thumnailID)
            {
                var url = trim($('#' + inputID).val());
                if (isEmpty(url)){
                    $('#' +thumnailID).html('');
                }
                else
                {
                    var html ='<img id="image-thumb-'+thumnailID+'" alt="" src="'+$('#' + inputID).val()+'" /><div><a href="#" onclick="return jsAdmin.ckfinder.remove(\''+inputID+'\', \''+thumnailID+'\');">Xóa</a></div>';
                    $('#' +thumnailID).html(html);
                    var width = $('#image-thumb-' + thumnailID).width();
                }
            },

            remove : function(inputID, thumnailID)
            {
                $('#' + inputID).val('');
                $('#' + thumnailID).html('');
                return false;
            }
        },
        parseToJson : function (name)
        {
            var jPlay = $('input[name="'+name+'"]');
            if (jPlay)
            {
                var play = {};
                for (var i = 0; i < jPlay.length; i++)
                {
                        play[$(jPlay[i]).attr('server')] = $(jPlay[i]).val();
                }
                return JSON.stringify(play);
            }
            return '';
        },
        
        init : function ()
        {
                $(document).ready(function()
                {
                        var hashStr = '';
                        if (!jsAdmin.isManager){
                                hashStr = 'cms/login';
                        }
                        else{
                                hashStr = jsAdmin.getHash();
                                if (!hashStr || hashStr == 'cms/login'){
                                        hashStr = 'cms/dashboard';
                                }
                        }
                        
                        jsAdmin.sendAjax('get', 'text', {}, hashStr, function(result){
                                jsAdmin.render(result);
                                jsAdmin.changeHash(hashStr);
                        });
                });
        },
        changeHash : function (hash){
            window.location.hash = hash;
        },
        getHash : function () 
        {
            return location.hash.hash();
        },
        changeTitle:function(title)
        {
            $('title').html(title);
        },
        changeMenu : function (hash)
        {
            hash = hash.replace(/(\?.*)/g, '');
            hash = 'm'+hash.replace('/','_');
            
            var obj = $('#'+hash.replace('/','_'));
            
            if ($('#'+hash).length == 0){
                return false;
            }
            
            $('.main-nav li').removeClass('active');
            
            if ($(obj).parent().hasClass('main-nav')){
                $(obj).addClass('active');
            }
            else if($(obj).parent().parent().hasClass('dropdown-submenu')){
                $(obj).addClass('active');
                $(obj).parent().parent().parent().parent().addClass('active');
            }
            else if($(obj).parent().hasClass('dropdown-menu')){
                $(obj).addClass('active');
                $(obj).parent().parent().addClass('active');
            }
            
            $('body').click();
        },
        loadScript : 
        {
                menu : function ()
                {
                        $(document).ready(function()
                        {
                                
                                $('.main-nav a').live('click',function ()
                                {
                                        var obj = this;
                                        if (!$(this).hasClass('dropdown-toggle')){
                                                var hash = $(this).attr('href').hash();
                                                jsAdmin.sendAjax('get', 'text', {}, hash, function (result){
                                                        jsAdmin.render(result);
                                                        jsAdmin.changeHash(hash);
                                                });
                                        }
                                        return false;
                                });
                        });
                },
                breakcrumb : function ()
                {
                        $(document).ready(function()
                        {
                                $('.breadcrumb a').live('click', function ()
                                {
                                        var hash = $(this).attr('href').hash();
                                        jsAdmin.sendAjax('get', 'text', {}, hash, function (result){
                                                jsAdmin.render(result);
                                                jsAdmin.changeHash(hash);
                                        });
                                        return false;
                                });
                        });
                },
                pagination : function ()
                {
                        $(document).ready(function(){
                                $('a.pagination-click').live('click',function ()
                                {
                                        var hash = $(this).attr('href').hash();
                                        jsAdmin.sendAjax('get', 'text', {}, hash, function (result){
                                               jsAdmin.render(result);
                                               jsAdmin.changeHash(hash);
                                        });
                                        return false;
                                });
                        });
                },
                sort: function ()
                {
                        $(document).ready(function()
                        {
                                $('a.sort-click').live('click',function ()
                                {
                                        var hash = $(this).attr('href').hash();
                                        jsAdmin.sendAjax('get', 'text', {}, hash, function (result){
                                                jsAdmin.render(result);
                                                jsAdmin.changeHash(hash);
                                        });
                                        return false;
                                });
                        });
                }
        },
        event : 
        {      
                filter : function (data, hash)
                {
                        var newData = {};
                        $.each(data, function (key, val)
                        {
                                if (!isEmpty(val))
                                {
                                        newData[key] = val;
                                }
                        });
                        
                        var href  = '';
                        $.each(newData, function (key, val)
                        {
                                href += '&' + key + '=' + val;
                        });
                        
                        href = trim(href, '&');
                        href = (!isEmpty(href)) ? hash + '?' + href : hash;
                        
                        jsAdmin.sendAjax('get', 'text', newData, hash, function (result){
                                jsAdmin.render(result);
                                jsAdmin.changeHash(href);
                        });
                }
        },
        fill : 
        {
                convertPassword  : function (string)
                {
                        string = string.toString();
                        for (var i = 0; i < 2; i++){
                                string = md5(string);
                        }
                        return string;
                }
        },
        login : function ()
        {
                var data = {
                    username    : $('#username').val(),
                    password    : $('#password').val(),
                    admin_login : $('#admin_login').val()
                };
                
                if (!data.password || !data.username){
                        jAlert('Nhập Đầy Đủ Thông Tin', 'Thông Báo');
                        return false;
                }
                data.password = this.fill.convertPassword(data.password);
                this.sendAjax('post', 'text', data, 'cms/login', function (result)
                {
                        result = trim(result);
                        if (result == '100')
                        {
                                $('body').html('');
                                jAlert('Đăng nhập thành công', 'Thành Công', function(){
                                    redirect(jsAdmin.baseUrl+'admin.php');
                                });
                        }
                        else if (result == '101'){
                                jAlert('Tài khoản của bạn đã bị khóa', 'Thất Bại');
                        }
                        else{
                                jAlert('Thông tin đăng nhập bị sai', 'Thất Bại');
                        }
                });
                return false;
        },
        logout : function ()
        {
            jConfirm('Bạn có thực sự muốn thoát không ?', 'Xác Nhận', function(r)
            {
                if (r)
                {
                    jsAdmin.sendAjax('get', 'text', {},'cms/logout', function (){
                        redirect(jsAdmin.baseUrl+'admin.php');
                    }, function(){
                        jAlert('Có lỗi, vui lòng thử lại', 'Lỗi thoát');
                    });
                }
            });
            return false;
        },
        redirect : function(hash)
        {
                jsAdmin.sendAjax('get', 'text', {}, hash, function (result){
                        jsAdmin.changeHash(hash);
                        jsAdmin.render(result);
                });
                return false;
        },
        
        render : function (result)
        {
                $('#content').html(result);
        },
        
        sendHideAjax : function (type, dataType, data, hash, success, error){
            url = jsAdmin.baseUrl+ 'admin.php/' + hash;
            data.token = jsAdmin.csrfHash;
            jQuery.ajax({
                    type        : type,
                    dataType    : dataType,
                    url         : url,
                    cache       : false,
                    async       : true,
                    data        : data,
                    timeout     : 50000,
                    success : function(result)
                    {
                            if (success){
                                    success(result);
                            }
                    },
                    error : function ()
                    {
                            if (error){
                                    error();
                            }
                    }
            });
        },
        getListCheckboxChecked : function(selector, separator)
        {
            var arr = new Array();
            var list = $(selector);
            for (var i = 0; i < list.length; i++){
                arr.push($(list[i]).val());
            }
            return arr.join(separator);
        },
        // Call Ajax Function
        sendAjax : function (type, dataType, data, hash, success, error)
        {
                if (!jsAdmin.ajaxCalling && hash)
                {
                        url = jsAdmin.baseUrl+ 'admin.php/' + hash;
                        $('.ajax_waiting').show();
                        jsAdmin.ajaxCalling = true;
                        data.token = jsAdmin.csrfHash;
                        jQuery.ajax({
                                type        : type,
                                dataType    : dataType,
                                url         : url,
                                cache       : false,
                                async       : true,
                                data        : data,
                                timeout     : 50000,
                                success : function(result)
                                {
                                        jsAdmin.ajaxCalling = false;
                                        $('.ajax_waiting').hide();
                                        if (success){
                                                success(result);
                                        }
                                },
                                error : function ()
                                {
                                        jsAdmin.ajaxCalling = false;
                                        
                                        $('.ajax_waiting').hide();
                                        if (error){
                                                error();
                                        }
                                        jAlert('Lỗi Hệ Thống Hoặc Do Mạng Quá Yếu. Vui Lòng Liên Hệ Quản Trị Website', 'Thất Bại');
                                }
                        });
                }
                else{
                    $('.ajax_waiting').hide();
                }
                return false;
        },
        sendAjaxFile : function (dataType, data, hash, success, error){
                if (!jsAdmin.ajaxCalling && hash)
                {
                        url = jsAdmin.baseUrl+ 'admin.php/' + hash;
                        $('.ajax_waiting').show();
                        jsAdmin.ajaxCalling = true;
                        data.append('token', jsAdmin.csrfHash);
                        jQuery.ajax({
                                type        : 'POST',
                                dataType    : dataType,
                                url         : url,
                                async       : true,
                                cache       : false,
                                contentType : false,
                                processData : false,
                                data        : data,
                                timeout     : 50000,
                                success : function(result)
                                {
                                        jsAdmin.ajaxCalling = false;
                                        $('.ajax_waiting').hide();
                                        if (success){
                                                success(result);
                                        }
                                },
                                error : function ()
                                {
                                        jsAdmin.ajaxCalling = false;
                                        $('.ajax_waiting').hide();
                                        if (error){
                                                error();
                                        }
                                        jAlert('Lỗi Hệ Thống Hoặc Do Mạng Quá Yếu. Vui Lòng Liên Hệ Quản Trị Website', 'Thất Bại');
                                }
                        });
                }
                else{
                    $('.ajax_waiting').hide();
                }
                return false;
        },
        loadTimer : function ()
        {
            var timer = $('input[name="timer"]:checked').val();
            if (timer == '2'){
                $('.timer').removeAttr('disabled');
            }
            else{
                $('.timer').attr('disabled', 'true');
            }

            $('input[name="timer"]').click(function(){
                if ($(this).val() == 2){
                    $('.timer').removeAttr('disabled');
                }
                else{
                    $('.timer').attr('disabled', true);
                }
            });
            
            $('#timer_date').datepicker({
                    dateFormat: 'dd-mm-yy'
            });
            $('#timer_time').timepicker({
                    timeFormat: 'hh:mm:ss'
            });
        },
        loadTabs : function (tabs){
            var arr = tabs.split(',');
            for (var i = 0; i <  arr.length; i++){
                $('#'+arr[i]+' a').tabs();
            }
        }
};

var jsNews = 
{
    listTags: new Array(),
    init : function ()
    {
        $(document).ready(function()
        {
            $('.removerelated').live('click',function(){
                $(this).parent().remove();
            });
            $('.removetags').live('click',function(){
                $(this).parent().remove();
            });
            $('#list-all-tags div').live('click',function(){
                var id = $(this).attr('idval');
                var title = $(this).html();
                if (!inArray(id, jsNews.getListTags())){
                    var html = '<div class="tags" idval="'+id+'"><span class="nametags">'+title+'</span><span class="removetags">x</span></div>';
                    $('#tags-list').append(html);
                }
            });
            
            jQuery.ajax({
                    type        : 'get',
                    dataType    : 'text',
                    url         : jsAdmin.baseUrl+ 'admin.php/news/tags_lists_quickly',
                    cache       : true,
                    async       : true,
                    data        : {token:jsAdmin.csrfHash},
                    timeout     : 50000,
                    success : function(result)
                    {
                        $('#list-all-tags').html(result);
                        var tags = $('#list-all-tags div');
                        jsNews.listTags = new Array();
                        for (var i = 0; i < tags.length; i++){
                            jsNews.listTags.push({
                                idval : $(tags[i]).attr('idval'),
                                title : $(tags[i]).html()
                            });
                        }
                    }
            });
            
            $('#input_add_tags').keyup(function(e){
                jsNews.showTagsSearch();
            });
            $('#input_add_tags').keypress(function(e)
            {
                var obj = this;
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13)
                {
                    var tags_title = $(this).val();
                    if (tags_title)
                    {
                        jsAdmin.sendAjax('get', 'text', {tags_title : tags_title}, 'news/tags_add_quickly', function (result){
                            result = trim(result);
                            if (result != '101'){
                                var html = '<div idval="'+result+'">'+tags_title+'</div>';
                                $('#list-all-tags').html(html+$('#list-all-tags').html());
                                jsNews.listTags.push({
                                    idval : result,
                                    title : tags_title
                                });
                            }
                            else{
                                jAlert('Tags này đã tồn tại, vui lòng kiểm tra trong danh sách', 'Tags đã tồn tại');
                            }
                        });
                    }
                } 
            });
            jsNews.getRelated();
        });
    },
    showTagsSearch : function (){
        var input_html = to_slug($('#input_add_tags').val());
        var html = '';
        for (var i = 0; i < jsNews.listTags.length; i++){
            if (to_slug(jsNews.listTags[i].title).indexOf(input_html) >= 0){
                html += '<div idval="'+jsNews.listTags[i].idval+'">'+jsNews.listTags[i].title+'</div>';
            }
        }
        $('#list-all-tags').html(html);
    },
    getListTags : function()
    {
        var arr = new Array();
        var list = $('.tags');
        for (var i = 0; i < list.length; i++){
            arr.push($(list[i]).attr('idval'));
        }
        return arr;
    },
    getListRelated : function()
    {
        var arr = new Array();
        var list = $('.related');
        for (var i = 0; i < list.length; i++){
            arr.push($(list[i]).attr('idval'));
        }
        return arr;
    },
    getRelated : function ()
    {
        $('#input_add_related').keypress(function(e){
            var obj = this;
            var keyCode = (e.which) ? e.which : e.keyCode;
            if (keyCode == 13)
            {
                var post_id = $(this).val();
                if (inArray(post_id, jsNews.getListRelated())){
                    jAlert('Tin này đã có trong danh sách lựa chọn', 'Tin này đã chọn');
                    return false;
                }
                else{
                    jsAdmin.sendAjax('get', 'text', {post_id : post_id}, 'news/post_by_id', function (result){
                        if (result != '100'){
                            $('#related-list').append(result);
                        }
                        else{
                            jAlert('Tin bạn chọn không tồn tại', 'Không tồn tại');
                        }
                        $(obj).val('');
                    });
                }
            } 
        });
    }
};


var jsProduct = 
{
    listTags: new Array(),
    init : function ()
    {
        $(document).ready(function()
        {
            $('.removerelated').live('click',function(){
                $(this).parent().remove();
            });
            $('.removetags').live('click',function(){
                $(this).parent().remove();
            });
            $('#list-all-tags div').live('click',function(){
                var id = $(this).attr('idval');
                var title = $(this).html();
                if (!inArray(id, jsProduct.getListTags())){
                    var html = '<div class="tags" idval="'+id+'"><span class="nametags">'+title+'</span><span class="removetags">x</span></div>';
                    $('#tags-list').append(html);
                }
            });
            
            jQuery.ajax({
                    type        : 'get',
                    dataType    : 'text',
                    url         : jsAdmin.baseUrl+ 'admin.php/product/tags_lists_quickly',
                    cache       : true,
                    async       : true,
                    data        : {token:jsAdmin.csrfHash},
                    timeout     : 50000,
                    success : function(result)
                    {
                        $('#list-all-tags').html(result);
                        var tags = $('#list-all-tags div');
                        jsProduct.listTags = new Array();
                        for (var i = 0; i < tags.length; i++){
                            jsProduct.listTags.push({
                                idval : $(tags[i]).attr('idval'),
                                title : $(tags[i]).html()
                            });
                        }
                    }
            });
            
            $('#input_add_tags').keyup(function(e){
                jsProduct.showTagsSearch();
            });
            $('#input_add_tags').keypress(function(e)
            {
                var obj = this;
                var keyCode = (e.which) ? e.which : e.keyCode;
                if (keyCode == 13)
                {
                    var tags_title = $(this).val();
                    if (tags_title)
                    {
                        jsAdmin.sendAjax('get', 'text', {tags_title : tags_title}, 'product/tags_add_quickly', function (result){
                            result = trim(result);
                            if (result != '101'){
                                var html = '<div idval="'+result+'">'+tags_title+'</div>';
                                $('#list-all-tags').html(html+$('#list-all-tags').html());
                                jsProduct.listTags.push({
                                    idval : result,
                                    title : tags_title
                                });
                            }
                            else{
                                jAlert('Tags này đã tồn tại, vui lòng kiểm tra trong danh sách', 'Tags đã tồn tại');
                            }
                        });
                    }
                } 
            });
            jsProduct.getRelated();
        });
    },
    showTagsSearch : function (){
        var input_html = to_slug($('#input_add_tags').val());
        var html = '';
        for (var i = 0; i < jsProduct.listTags.length; i++){
            if (to_slug(jsProduct.listTags[i].title).indexOf(input_html) >= 0){
                html += '<div idval="'+jsProduct.listTags[i].idval+'">'+jsProduct.listTags[i].title+'</div>';
            }
        }
        $('#list-all-tags').html(html);
    },
    getListTags : function()
    {
        var arr = new Array();
        var list = $('.tags');
        for (var i = 0; i < list.length; i++){
            arr.push($(list[i]).attr('idval'));
        }
        return arr;
    },
    getListRelated : function()
    {
        var arr = new Array();
        var list = $('.related');
        for (var i = 0; i < list.length; i++){
            arr.push($(list[i]).attr('idval'));
        }
        return arr;
    },
    getRelated : function ()
    {
        $('#input_add_related').keypress(function(e){
            var obj = this;
            var keyCode = (e.which) ? e.which : e.keyCode;
            if (keyCode == 13)
            {
                var post_id = $(this).val();
                if (inArray(post_id, jsProduct.getListRelated())){
                    jAlert('Tin này đã có trong danh sách lựa chọn', 'Tin này đã chọn');
                    return false;
                }
                else{
                    jsAdmin.sendAjax('get', 'text', {post_id : post_id}, 'product/post_by_id', function (result){
                        if (result != '100'){
                            $('#related-list').append(result);
                        }
                        else{
                            jAlert('Tin bạn chọn không tồn tại', 'Không tồn tại');
                        }
                        $(obj).val('');
                    });
                }
            } 
        });
    }
};

