<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Quản trị freetuts.net</title>
        <base href="<?php echo $this->config->base_url(); ?>" />
        <link rel="stylesheet" type="text/css" href="public/_backend/stylesheet/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="public/_backend/stylesheet/icons-sprite.css" />
        <link rel="stylesheet" type="text/css" href="public/_backend/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="public/_backend/javascript/jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="public/_backend/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="public/_backend/javascript/jquery/tabs.js"></script>
        <script type="text/javascript" src="public/_backend/javascript/jquery/superfish/js/superfish.js"></script>
        <script type="text/javascript" src="public/_backend/custom/start1.js"></script>
        
        <script type="text/javascript" src="public/js_helper/helper.common.js"></script>
        
        <script type="text/javascript" src="public/js_helper/jalert/jquery.alert.js"></script>
        
        <link rel="stylesheet" type="text/css" href="public/js_helper/jalert/css/jalert.css" />
        
        <script type="text/javascript" src="public/_backend/javascript/jsAdmin.js"></script>
        
        <script language="javascript" src="public/ckfinder/ckfinder.js" type="text/javascript"></script>
        
        <script language="javascript" src="public/ckeditor/ckeditor.js" type="text/javascript"></script>
        
        <script language="javascript">
            jsAdmin.baseUrl     = '<?php echo $this->config->base_url($this->config->item('index_page')); ?>/';
            jsAdmin.base_url    = '<?php echo $this->config->base_url(); ?>/';
            jsAdmin.csrfHash    = '<?php echo $this->security->get_csrf_hash(); ?>';
            jsAdmin.isManager   = '<?php echo $this->auth->isManager() ? 'true' : 'false'; ?>';
            jsAdmin.init();
        </script>
    </head>
    <body>
        <div class="ajax_waiting"><div>Waitting ...</div></div>
        <div id="container">
            <?php  if ($this->auth->isManager()){ ?>
            <div id="header">
                <div class="div1">
                    <div class="div2"><img src="public/_backend/image/logo.png" title="Administration" onclick="" /></div>
                    <div class="div3"><img src="public/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;You are logged in as <span>admin</span></div>
                </div>
                <div id="menu">
                    <ul class="left" style="display: none;">
                        <li id="catalog">
                            <a class="top menu-click" href="<?php echo get_link_ajax('common/dashboard'); ?>">Dashboard</a>
                        </li>
                        <li id="catalog">
                            <a class="top menu-click" href="<?php echo get_link_ajax('cate/lists'); ?>">Category</a>
                        </li>
                        <li id="catalog">
                            <a class="top" href="<?php echo get_link_admin(); ?>" onclick="return false;">Series</a>
                        </li>
                        <li id="catalog">
                            <a class="top" href="<?php echo get_link_admin(); ?>" onclick="return false;">Post</a>
                        </li>
                    </ul>
                    <ul class="right">
                        <li><a class="top">TheHalfHeart@gmail.com</a></li>
                        <li><a class="top" onclick="return jsAdmin.logout();">Logout</a></li>
                    </ul>
                </div>
            </div>
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    jsAdmin.loadScript.menu();
                });
            </script>
            <?php } ?>
            <div id="content"></div>
        </div>
        <div id="footer">
            <a href="http://www.freetuts.net">Freetuts.net</a> 
            &copy; 2013 At OpenCart<br />Version 1.0
        </div>
    </body>
</html>