/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        // Define changes to default configuration here. For example:    
        config.language = isEmpty(jsAdmin.ckeditor.lang) ? 'en' : jsAdmin.ckeditor.lang;
        console.log(config.protectedSource);
        //config.protectedSource = new Array();
        if (!isEmpty(jsAdmin.ckeditor.uicolor))
        {
            config.uiColor = jsAdmin.ckeditor.uicolor;
        }
        
        if (!isEmpty(jsAdmin.ckeditor.skins))
        {
            config.skins = jsAdmin.ckeditor.skins;
        }
        
        //config.enterMode = CKEDITOR.ENTER_BR;
        
        if (!isEmpty(jsAdmin.ckeditor.toolbar))
        {
            config.toolbar = jsAdmin.ckeditor.toolbar;
        }
        config.extraPlugins = jsAdmin.ckeditor.extraPlugins;
        config.entities = false;
        config.entities_latin = false;
        //config.extraPlugins='onchange';
        //config.minimumChangeMilliseconds = 100;
        // FILE 
        config.filebrowserBrowseUrl = jsAdmin.ckeditor.filebrowserBrowseUrl;
        config.filebrowserUploadUrl = jsAdmin.ckeditor.filebrowserUploadUrl;
        
        // IMAGE
        config.filebrowserImageBrowseUrl = jsAdmin.ckeditor.filebrowserImageBrowseUrl;
        config.filebrowserImageUploadUrl = jsAdmin.ckeditor.filebrowserImageUploadUrl;
        
        // FLASH
        config.filebrowserFlashBrowseUrl = jsAdmin.ckeditor.filebrowserFlashBrowseUrl;
        config.filebrowserFlashUploadUrl = jsAdmin.ckeditor.filebrowserFlashUploadUrl; 
};

