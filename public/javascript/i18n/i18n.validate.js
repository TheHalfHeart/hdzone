

function i18n_getLangEmpty(name)
{
    var flag = '';
    for (var i = 0; i < cf_lang.langCode.length; i++)
    {
        var new_name = name + '[' + cf_lang.langCode[i] + ']';
        var element = document.getElementsByName(new_name);
        if (element.length > 0)
        {
            if (isEmpty(element[0].value))
            {
                flag = cf_lang.langText[i];
                break;
            }
        }
    }
    return flag;
}

function i18n_getLangMax(name, max){
    var flag = '';
    for (var i = 0; i < cf_lang.langCode.length; i++)
    {
        var new_name = name + '[' + cf_lang.langCode[i] + ']';
        var element = document.getElementsByName(new_name);
        if (element.length > 0)
        {
            if (element[0].value.length > max)
            {
                flag = cf_lang.langText[i];
                break;
            }
        }
    }
    return flag;
}

function i18n_getLangMin(name, min){
    var flag = '';
    for (var i = 0; i < cf_lang.langCode.length; i++)
    {
        var new_name = name + '[' + cf_lang.langCode[i] + ']';
        var element = document.getElementsByName(new_name);
        if (element.length > 0)
        {
            if (element[0].value.length < min)
            {
                flag = cf_lang.langText[i];
                break;
            }
        }
    }
    return flag;
}

function i18n_getLangEditorEmpty(instance)
{
    var flag = '';
    for (var i = 0; i < cf_lang.langCode.length; i++)
    {
        var new_name = instance + '[' + cf_lang.langCode[i] + ']';
        if (CKEDITOR.instances.hasOwnProperty(new_name))
        {
            if (isEmpty(CKEDITOR.instances[new_name].getData()))
            {
                flag = cf_lang.langText[i];
                break;
            }
        }
    }
    return flag;
}