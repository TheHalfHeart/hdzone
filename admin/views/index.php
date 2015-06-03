<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Đang Kế Nối Vào Hệ Thống</title>
        <base href="<?php echo $this->config->base_url(); ?>" />
        <link rel="stylesheet" type="text/css" href="public/admin/stylesheet/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="public/admin/stylesheet/icons-sprite.css" />
        <link rel="stylesheet" type="text/css" href="public/javascript/i18n/style.css" />
        <script type="text/javascript" src="public/admin/javascript/jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="public/admin/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
        <link type="text/css" href="public/admin/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="public/admin/javascript/jquery/tabs.js"></script>
        <script type="text/javascript" src="public/admin/javascript/jquery/superfish/js/superfish.js"></script>
        <script type="text/javascript" src="public/admin/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
        <script type="text/javascript" src="public/admin/javascript/bootstrap.min.js"></script>
        <?php if ($this->auth->isManager()){ ?>
        <script type="text/javascript" src="public/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="public/ckfinder/ckfinder.js"></script>
        <?php } ?>
        <script type="text/javascript" src="public/javascript/helper.common.js"></script>
        <script type="text/javascript" src="public/javascript/jalert/jquery.alert.js"></script>
        <link rel="stylesheet" type="text/css" href="public/javascript/jalert/css/jalert.css" />
        <script type="text/javascript" src="public/admin/javascript/jsAdmin.js"></script>
        <?php if ($this->auth->isManager()){ ?>
        <script type="text/javascript" src="public/javascript/i18n/i18n.js"></script>
        <?php } ?>
        <script language="javascript">
            jsAdmin.csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            jsAdmin.baseUrl = '<?php echo $this->config->base_url(); ?>';
            jsAdmin.isManager = <?php echo ($this->auth->isManager()) ? 'true' : 'false' ?>;
            jsAdmin.linkApi = '<?php echo $this->config->base_url('api.php'); ?>';
            jsAdmin.i18n.languages = {
                <?php $index = 0; foreach ($this->lang->lang_list as $key => $val){ ?>
                <?php echo $key; ?>: '<?php echo $val; ?>'
                <?php if ($index < (count($this->lang->lang_list) - 1)) echo ','; ?>
                <?php $index++; } ?>
            };            
            jsAdmin.i18n.defaultLang = "vi";
            jsAdmin.loadScript.menu();
            jsAdmin.loadScript.breakcrumb();
            jsAdmin.loadScript.sort();
            jsAdmin.loadScript.pagination();
            jsAdmin.init();
        </script>
    </head>
    <body>
        <input type="hidden" value="" id="hash"/>
        <div class="ajax_waiting"><div>Waitting ...</div></div>
        <div id="container">
        <?php if ($this->auth->isManager()) { ?>
                <div id="navigation">
                    <div class="container-fluid">
                        <a target="_blank" href="http://hungphong.net" id="brand">
                            ADMINISTRATOR
                        </a>
                        <ul class="main-nav">
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Hệ Thống</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">  
                                    <li id="mpage_lists">
                                        <a href="admin.php#page/lists">Trang nội dung</a>
                                    </li>
                                    <li id="mmenu_lists">
                                        <a href="admin.php#menu/lists">Menus</a>
                                    </li>
                                    <li id="mcontact_lists">
                                        <a href="admin.php#contact/lists">Liên Hệ</a>
                                    </li>
                                    <li id="mslide_lists">
                                        <a href="admin.php#slide/lists">Slider</a>
                                    </li>
                                    <li id="mcms_config">
                                        <a href="admin.php#cms/config">Cấu Hình</a>
                                    </li>
                                    <li id="mcms_user_lists">
                                        <a href="admin.php#cms/user_lists">Thành Viên</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Phim</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="mproduct_post_lists">
                                        <a href="admin.php#product/post_lists">Danh sách phim</a>
                                    </li>
                                    <li id="mproduct_cate_lists">
                                        <a href="admin.php#product/cate_lists">Chuyên Mục phim</a>
                                    </li>
                                    <li id="mproduct_manu_lists">
                                        <a href="admin.php#product/manu_lists">Nhà Sản Xuất</a>
                                    </li>
                                    <li id="mproduct_type_lists">
                                        <a href="admin.php#product/type_lists">Thể Loại phim</a>
                                    </li>
                                    <li id="mproduct_author_lists">
                                        <a href="admin.php#product/author_lists">Tác Giả Kịch Bản</a>
                                    </li>
                                    <li id="mproduct_director_lists">
                                        <a href="admin.php#product/director_lists">Đạo Diễn</a>
                                    </li>
                                    <li id="mproduct_actor_lists">
                                        <a href="admin.php#product/actor_lists">Diễn Viên</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Ổ cứng</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="mproduct_hdd_lists">
                                        <a href="admin.php#product/hdd_lists">Ổ cứng chứa phim</a>
                                    </li>
                                    <li id="mproduct_hdd_group_lists">
                                        <a href="admin.php#product/hdd_group_lists">Loại ổ cứng</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Khách hàng</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="mcustomer_customer_lists">
                                        <a href="admin.php#customer/customer_lists">Danh sách khách hàng</a>
                                    </li>   
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Đơn + Phiếu</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="mcustomer_order_lists">
                                        <a href="admin.php#customer/order_lists">Đơn Hàng</a>
                                    </li>
                                    <li id="mcustomer_customer_lists">
                                        <a href="admin.php#cms/receive_lists">Phiếu nhận copy</a>
                                    </li>
                                    <li id="mcustomer_customer_lists">
                                        <a href="admin.php#customer/customer_lists">Phiếu bảo hành</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <span>Thẻ + Showroom</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="mcustomer_voucher_lists">
                                        <a href="admin.php#customer/voucher_lists">Thẻ copy</a>
                                    </li>
                                    <li id="mcms_showroom_lists">
                                        <a href="admin.php#cms/showroom_lists">Showroom</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div class="user">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo $this->auth->getItem('user_username'); ?>
                                    <img width="25px" height="25px" src="<?php echo $this->auth->getAvatar(); ?>" alt=""></a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="" onclick="return jsAdmin.logout();">Sign out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
                <div id="content"></div>
            </div>
            <?php if ($this->auth->isManager()) { ?>
                <div id="footer"><a target="_blank" href="http://freetuts.net">Phát triển bởi Freetuts.net</a> &copy; 2009-2014 All Rights Reserved.<br />Version 1.0</div>
            <?php } ?>
    </body>
</html>