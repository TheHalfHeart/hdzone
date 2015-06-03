/************************************************************/
/************************ACCESS STRING***********************/
/************************************************************/
function rTrim(str, ch)
{
    ch = ch || '';
    str = str || '';
    var end = str.length;
    while (end > 0 && str.charAt(end - 1) == ' ')
        end--;
    str = str.substr(0, end);
    for (var i = str.length - 1; i >= 0; i--)
    {
        if (ch != str.charAt(i))
        {
            str = str.substring(0, i + 1);
            break;
        }
    }
    return str;
}

function lTrim(str, ch)
{
    ch = ch || '';
    str = str || '';
    var start = 0;
    while (start < str.length && str.charAt(start) == ' ')
        start++;
    str = str.substr(start, str.length);
    for (var i = 0; i < str.length; i++)
    {
        if (ch != str.charAt(i))
        {
            str = str.substring(i, str.length);
            break;
        }
    }
    return str;
}

function trim(str, ch)
{
    ch = ch || '';
    str = str || '';
    return lTrim(rTrim(str, ch), ch);
}


/************************************************************/
/**********************VALIDATE (STRING)*********************/
/************************************************************/

function isListId(str)
{
    var reg = /^(([0-9]){1,},)*([0-9]){1,}$/;
    return reg.test(str);
}

function inArray(needle, haystack)
{
    var i = haystack.length;
    while (i >= 0)
    {
        if (haystack[i] === needle)
        {
            return true;
        }
        i--;
    }
    return false;
}

function isArray(object)
{
    if (object.constructor === Array)
        return true;
    else
        return false;
}

function isEmpty(str)
{
    str = str || null;
    return (typeof str == "undefined" || str == null);
}

function isInteger(n)
{
    return ((typeof n === 'number') && (n % 1 === 0));
}

function isFloat(n)
{
    return ((typeof n === 'number') && (n % 1 !== 0));
}

function isNumber(n)
{
    return (typeof n === 'number');
}

function isBoolean(G)
{
    return (typeof G === "boolean");
}
function isValidTime(timeStr) {
    var reg = /^([0-2]){1,1}([0-9]){1,1}\:([0-6]){1,1}([0-9]){1,1}\:([0-6]){1,1}([0-9]){1,1}$/;
    return reg.test(timeStr);
}
function isValidDate(dateStr, format)
{
    if (format == null) {
        format = "MDY";
    }
    format = format.toUpperCase();
    if (format.length != 3) {
        format = "MDY";
    }
    if ((format.indexOf("M") == -1) || (format.indexOf("D") == -1) ||
            (format.indexOf("Y") == -1)) {
        format = "MDY";
    }
    if (format.substring(0, 1) == "Y") { // If the year is first
        var reg1 = /^\d{2}(\-|\/)\d{1,2}\1\d{1,2}$/
        var reg2 = /^\d{4}(\-|\/)\d{1,2}\1\d{1,2}$/
    } else if (format.substring(1, 2) == "Y") { // If the year is second
        var reg1 = /^\d{1,2}(\-|\/)\d{2}\1\d{1,2}$/
        var reg2 = /^\d{1,2}(\-|\/)\d{4}\1\d{1,2}$/
    } else { // The year must be third
        // Tan :: Start : if 'd-m-Y' is invalid format (only remove -)
        var reg1 = /^\d{1,2}(\/)\d{1,2}\1\d{2}$/
        var reg2 = /^\d{1,2}(\/)\d{1,2}\1\d{4}$/
        // Tan :: End
    }

    // If it doesn't conform to the right format (with either a 2 digit year or 4 digit year), fail
    if ((reg1.test(dateStr) == false) && (reg2.test(dateStr) == false)) {
        return false;
    }
    var parts = dateStr.split(RegExp.$1); // Split into 3 parts based on what the divider was
    // Check to see if the 3 parts end up making a valid date
    if (format.substring(0, 1) == "M")
    {
        var mm = parts[0];
    }
    else if (format.substring(1, 2) == "M")
    {
        var mm = parts[1];
    }
    else
    {
        var mm = parts[2];
    }
    if (format.substring(0, 1) == "D") {
        var dd = parts[0];
    }
    else if (format.substring(1, 2) == "D")
    {
        var dd = parts[1];
    }
    else
    {
        var dd = parts[2];
    }

    if (format.substring(0, 1) == "Y")
    {
        var yy = parts[0];
    }
    else
    if (format.substring(1, 2) == "Y")
    {
        var yy = parts[1];
    }
    else
    {
        var yy = parts[2];
    }
    if (parseFloat(yy) <= 50)
    {
        yy = (parseFloat(yy) + 2000).toString();
    }
    if (parseFloat(yy) <= 99)
    {
        yy = (parseFloat(yy) + 1900).toString();
    }
    var dt = new Date(parseFloat(yy), parseFloat(mm) - 1, parseFloat(dd), 0, 0, 0, 0);
    if (parseFloat(dd) != dt.getDate())
    {
        return false;
    }
    if (parseFloat(mm) - 1 != dt.getMonth())
    {
        return false;
    }

    return true;
}

function isEmail(emailStr)
{
    var emailPat = /^(.+)@(.+)$/
    var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
    var validChars = "\[^\\s" + specialChars + "\]"
    var quotedUser = "(\"[^\"]*\")"
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
    var atom = validChars + '+'
    var word = "(" + atom + "|" + quotedUser + ")"
    var userPat = new RegExp("^" + word + "(\\." + word + ")*$")
    var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$")
    var matchArray = emailStr.match(emailPat)
    if (matchArray == null) {
        return false
    }
    var user = matchArray[1]
    var domain = matchArray[2]

    // See if "user" is valid
    if (user.match(userPat) == null) {
        return false
    }
    var IPArray = domain.match(ipDomainPat)
    if (IPArray != null) {
        // this is an IP address
        for (var i = 1; i <= 4; i++) {
            if (IPArray[i] > 255) {
                return false
            }
        }
        return true
    }
    var domainArray = domain.match(domainPat)
    if (domainArray == null) {
        return false
    }

    var atomPat = new RegExp(atom, "g")
    var domArr = domain.match(atomPat)
    var len = domArr.length

    if (domArr[domArr.length - 1].length < 2 ||
            domArr[domArr.length - 1].length > 3) {
        return false
    }

    // Make sure there's a host name preceding the domain.
    if (len < 2)
    {
        return false
    }

    // If we've gotten this far, everything's valid!
    return true;
}

function isURL(url) {
    if (url == "" || url == null)
        return false;

    url = trim(url);

    if (url.indexOf(" ") != -1)
        return false;

    var RegExp = /^http(s)?:\/\/[\w|\-]+(\.[^\.]+)+$/i;

    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}

/************************************************************/
/**********************VALIDATE (HTML)***********************/
/************************************************************/
function isNoOptionSelected(control)
{
    for (var i = 0; i < control.options.length; i++)
    {
        if (control.options[ i ].selected)
        {
            return false;
        }
    }
    return true;
}


/************************************************************/
/**********************OTHER ********************************/
/************************************************************/

function redirect(url)
{
    window.location.href = url;
}

function isAjaxSuccess(result)
{
    return !(typeof result === "boolean");
}

function callAjax(url, params, type, dataType, successCallback, errorCallback, async, cache)
{
    type = type || 'POST';
    params = params || {};
    dataType = dataType || 'text';
    cache = cache || false;
    async = async || true;
    var ret = false;

    jQuery.ajax({
        type: type,
        url: url,
        data: params,
        dataType: dataType,
        cache: cache,
        async: async,
        timeout: 10000,
        success: function(result, status, xhr)
        {
            if (successCallback) {
                successCallback(result, status, xhr);
            }
            ret = result;
        },
        error: function(xhr, status, error) {
            if (errorCallback) {
                errorCallback(xhr, status, error);
            }
        }
    });

    return ret;
}

function is_slug(val) {
    var reg = /^[a-z0-9-]+$/;
    return reg.test(val);
}

function is_number(val) {
    var reg = /^[0-9]+$/;
    return reg.test(trim(val));
}

/************************************************************/
/**********************FILTER DATA **************************/
/************************************************************/

function toInteger(n, re)
{
    re = re || false;
    n = parseInt(n);
    if (isNaN(n))
    {
        if (re) {
            return 0;
        }
        return false;
    }
    return n;
}

function toString(str)
{
    return str.toString();
}

function addslashes(str)
{
    return(str + '').replace(/([\\"'])/g, "\\$1").replace(/\0/g, "\\0");
}

function getI18n(string, language_code)
{
    if (!string) {
        string = '';
    }

    if (!language_code || language_code == '') {
        language_code = 'en';
    }

    if (language_code.length == 2) {
        language_code = language_code.toLowerCase();
    }

    string = string.replace(/(\r\n|\n|\r)/gm, "");
    //string = string.replace("&lt;"+language_code+"&gt;", "<"+language_code+">");
    //string = string.replace("&lt;/"+language_code+"&gt;", "</"+language_code+">");
    var exp = new RegExp("<" + language_code + ">(.*?)<\/" + language_code + ">");
    var matches = string.match(exp);

    if (matches) {
        return matches[1];
    }

    return '';
}

// SECURITY FUNCTION 
var md5 = function(string) {

    function RotateLeft(lValue, iShiftBits) {
        return (lValue << iShiftBits) | (lValue >>> (32 - iShiftBits));
    }

    function AddUnsigned(lX, lY) {
        var lX4, lY4, lX8, lY8, lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF) + (lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
            return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
            if (lResult & 0x40000000) {
                return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            } else {
                return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
            }
        } else {
            return (lResult ^ lX8 ^ lY8);
        }
    }

    function F(x, y, z) {
        return (x & y) | ((~x) & z);
    }
    function G(x, y, z) {
        return (x & z) | (y & (~z));
    }
    function H(x, y, z) {
        return (x ^ y ^ z);
    }
    function I(x, y, z) {
        return (y ^ (x | (~z)));
    }

    function FF(a, b, c, d, x, s, ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    ;

    function GG(a, b, c, d, x, s, ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    ;

    function HH(a, b, c, d, x, s, ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    ;

    function II(a, b, c, d, x, s, ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    ;

    function ConvertToWordArray(string) {
        var lWordCount;
        var lMessageLength = string.length;
        var lNumberOfWords_temp1 = lMessageLength + 8;
        var lNumberOfWords_temp2 = (lNumberOfWords_temp1 - (lNumberOfWords_temp1 % 64)) / 64;
        var lNumberOfWords = (lNumberOfWords_temp2 + 1) * 16;
        var lWordArray = Array(lNumberOfWords - 1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while (lByteCount < lMessageLength) {
            lWordCount = (lByteCount - (lByteCount % 4)) / 4;
            lBytePosition = (lByteCount % 4) * 8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount) << lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount - (lByteCount % 4)) / 4;
        lBytePosition = (lByteCount % 4) * 8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80 << lBytePosition);
        lWordArray[lNumberOfWords - 2] = lMessageLength << 3;
        lWordArray[lNumberOfWords - 1] = lMessageLength >>> 29;
        return lWordArray;
    }
    ;

    function WordToHex(lValue) {
        var WordToHexValue = "", WordToHexValue_temp = "", lByte, lCount;
        for (lCount = 0; lCount <= 3; lCount++) {
            lByte = (lValue >>> (lCount * 8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length - 2, 2);
        }
        return WordToHexValue;
    }
    ;

    function Utf8Encode(string) {
        string = string.replace(/\r\n/g, "\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if ((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    }
    ;

    var x = Array();
    var k, AA, BB, CC, DD, a, b, c, d;
    var S11 = 7, S12 = 12, S13 = 17, S14 = 22;
    var S21 = 5, S22 = 9, S23 = 14, S24 = 20;
    var S31 = 4, S32 = 11, S33 = 16, S34 = 23;
    var S41 = 6, S42 = 10, S43 = 15, S44 = 21;

    string = Utf8Encode(string);

    x = ConvertToWordArray(string);

    a = 0x67452301;
    b = 0xEFCDAB89;
    c = 0x98BADCFE;
    d = 0x10325476;

    for (k = 0; k < x.length; k += 16) {
        AA = a;
        BB = b;
        CC = c;
        DD = d;
        a = FF(a, b, c, d, x[k + 0], S11, 0xD76AA478);
        d = FF(d, a, b, c, x[k + 1], S12, 0xE8C7B756);
        c = FF(c, d, a, b, x[k + 2], S13, 0x242070DB);
        b = FF(b, c, d, a, x[k + 3], S14, 0xC1BDCEEE);
        a = FF(a, b, c, d, x[k + 4], S11, 0xF57C0FAF);
        d = FF(d, a, b, c, x[k + 5], S12, 0x4787C62A);
        c = FF(c, d, a, b, x[k + 6], S13, 0xA8304613);
        b = FF(b, c, d, a, x[k + 7], S14, 0xFD469501);
        a = FF(a, b, c, d, x[k + 8], S11, 0x698098D8);
        d = FF(d, a, b, c, x[k + 9], S12, 0x8B44F7AF);
        c = FF(c, d, a, b, x[k + 10], S13, 0xFFFF5BB1);
        b = FF(b, c, d, a, x[k + 11], S14, 0x895CD7BE);
        a = FF(a, b, c, d, x[k + 12], S11, 0x6B901122);
        d = FF(d, a, b, c, x[k + 13], S12, 0xFD987193);
        c = FF(c, d, a, b, x[k + 14], S13, 0xA679438E);
        b = FF(b, c, d, a, x[k + 15], S14, 0x49B40821);
        a = GG(a, b, c, d, x[k + 1], S21, 0xF61E2562);
        d = GG(d, a, b, c, x[k + 6], S22, 0xC040B340);
        c = GG(c, d, a, b, x[k + 11], S23, 0x265E5A51);
        b = GG(b, c, d, a, x[k + 0], S24, 0xE9B6C7AA);
        a = GG(a, b, c, d, x[k + 5], S21, 0xD62F105D);
        d = GG(d, a, b, c, x[k + 10], S22, 0x2441453);
        c = GG(c, d, a, b, x[k + 15], S23, 0xD8A1E681);
        b = GG(b, c, d, a, x[k + 4], S24, 0xE7D3FBC8);
        a = GG(a, b, c, d, x[k + 9], S21, 0x21E1CDE6);
        d = GG(d, a, b, c, x[k + 14], S22, 0xC33707D6);
        c = GG(c, d, a, b, x[k + 3], S23, 0xF4D50D87);
        b = GG(b, c, d, a, x[k + 8], S24, 0x455A14ED);
        a = GG(a, b, c, d, x[k + 13], S21, 0xA9E3E905);
        d = GG(d, a, b, c, x[k + 2], S22, 0xFCEFA3F8);
        c = GG(c, d, a, b, x[k + 7], S23, 0x676F02D9);
        b = GG(b, c, d, a, x[k + 12], S24, 0x8D2A4C8A);
        a = HH(a, b, c, d, x[k + 5], S31, 0xFFFA3942);
        d = HH(d, a, b, c, x[k + 8], S32, 0x8771F681);
        c = HH(c, d, a, b, x[k + 11], S33, 0x6D9D6122);
        b = HH(b, c, d, a, x[k + 14], S34, 0xFDE5380C);
        a = HH(a, b, c, d, x[k + 1], S31, 0xA4BEEA44);
        d = HH(d, a, b, c, x[k + 4], S32, 0x4BDECFA9);
        c = HH(c, d, a, b, x[k + 7], S33, 0xF6BB4B60);
        b = HH(b, c, d, a, x[k + 10], S34, 0xBEBFBC70);
        a = HH(a, b, c, d, x[k + 13], S31, 0x289B7EC6);
        d = HH(d, a, b, c, x[k + 0], S32, 0xEAA127FA);
        c = HH(c, d, a, b, x[k + 3], S33, 0xD4EF3085);
        b = HH(b, c, d, a, x[k + 6], S34, 0x4881D05);
        a = HH(a, b, c, d, x[k + 9], S31, 0xD9D4D039);
        d = HH(d, a, b, c, x[k + 12], S32, 0xE6DB99E5);
        c = HH(c, d, a, b, x[k + 15], S33, 0x1FA27CF8);
        b = HH(b, c, d, a, x[k + 2], S34, 0xC4AC5665);
        a = II(a, b, c, d, x[k + 0], S41, 0xF4292244);
        d = II(d, a, b, c, x[k + 7], S42, 0x432AFF97);
        c = II(c, d, a, b, x[k + 14], S43, 0xAB9423A7);
        b = II(b, c, d, a, x[k + 5], S44, 0xFC93A039);
        a = II(a, b, c, d, x[k + 12], S41, 0x655B59C3);
        d = II(d, a, b, c, x[k + 3], S42, 0x8F0CCC92);
        c = II(c, d, a, b, x[k + 10], S43, 0xFFEFF47D);
        b = II(b, c, d, a, x[k + 1], S44, 0x85845DD1);
        a = II(a, b, c, d, x[k + 8], S41, 0x6FA87E4F);
        d = II(d, a, b, c, x[k + 15], S42, 0xFE2CE6E0);
        c = II(c, d, a, b, x[k + 6], S43, 0xA3014314);
        b = II(b, c, d, a, x[k + 13], S44, 0x4E0811A1);
        a = II(a, b, c, d, x[k + 4], S41, 0xF7537E82);
        d = II(d, a, b, c, x[k + 11], S42, 0xBD3AF235);
        c = II(c, d, a, b, x[k + 2], S43, 0x2AD7D2BB);
        b = II(b, c, d, a, x[k + 9], S44, 0xEB86D391);
        a = AddUnsigned(a, AA);
        b = AddUnsigned(b, BB);
        c = AddUnsigned(c, CC);
        d = AddUnsigned(d, DD);
    }

    var temp = WordToHex(a) + WordToHex(b) + WordToHex(c) + WordToHex(d);

    return temp.toLowerCase();
}
/************************************************************/
/**********************GET DATA HTML*************************/
/************************************************************/

function get_list_input_id(name, space) {
    space = space || ',';
    var checkbox = $('input[name="' + name + '"]:checked');
    var str = '';
    for (var i = 0; i < checkbox.length; i++) {
        str += space + $(checkbox[i]).val();
    }
    return trim(str, space);
}

function get_input_value_by_id(element)
{
    var value = document.getElementById(element);
    if (typeof value === "undefined" || value === null)
    {
        return '';
    }
    return value.value;
}

function get_input_value_by_name(element)
{

    var value = document.getElementsByName(element);
    if (typeof value === "undefined" || value === null)
    {
        return '';
    }
    return value[0].value;
}

function get_radio_value_checked(name)
{
    var radio = $('input[name="' + name + '"]');
    for (var i = 0; i < radio.length; i++)
    {
        if ($(radio[i]).is(':checked'))
        {
            return jQuery(radio[i]).val();
        }
    }
    return '';
}

(function($) {
    $.QueryString = (function(a) {
        if (a == "")
            return {};
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p = a[i].split('=');
            if (p.length != 2)
                continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'));
})(jQuery);

Array.prototype.getUnique = function() {
    var o = {}, a = [];
    for (var i = 0; i < this.length; i++)
        o[this[i]] = 1;
    for (var e in o)
        a.push(e);
    return a;
};

String.prototype.hash = function() {
    var index = this.indexOf('#', 0);
    index = index + 1 | 0;
    return this.substring(index);
};

function to_slug(str, saperator)
{
    saperator = saperator || '-';
    str = str.toLowerCase();
    str = str.replace(/[^a-zA-Z0-9\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/g, '');
    str = trim(str);
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/ /g, '-');
    str = str.replace(/(-+)/g, saperator);
    return str;
}


function fill_to_slug(id_title, id_slug) {
    if (isEmpty($('#' + id_slug).val())) {
        $('#' + id_slug).val(to_slug($('#' + id_title).val()));
    }
}


function onlyNumbers(event) {
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function is_year(year) {
    year = toInteger(year, true);
    return (year >= 1970 && year < 2100);
}

function is_timer(str) {
    var regex = /^([0-9]){2,2}-([0-9]){2,2}-([0-9]){4,4} ([0-9]){2,2}:([0-9]){2,2}:([0-9]){2,2}$/g;
    return regex.test(str);
}

// so lan xuat hien cua chuoi
String.prototype.count = function(s1) {
    return (this.length - this.replace(new RegExp(s1, "g"), '').length) / s1.length;
};

// replace all
function replaceAll(string, find, replace) {
    return string.replace(new RegExp(find, 'g'), replace);
}


function is_username(str) {
    var regex = /([a-zA-Z0-9]{5,15})/;
    return regex.test(str);
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}