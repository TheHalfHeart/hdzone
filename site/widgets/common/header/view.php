<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en" class="ie ie9"> <!--<![endif]-->
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <?php load_meta($metas); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/colors.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/base.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/base_responsive.css">
        
        <link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/fonts.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/prettyPhoto.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/portfolio_isotope.css" />
        <link rel="stylesheet" href="<?php echo $this->config->base_url('public/webcool'); ?>/css/camera.css">

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.8.2/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.tipsy.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/hoverIntent.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/superfish.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.isotope.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/sorting.js"></script>
        <script type='text/javascript' src='<?php echo $this->config->base_url('public/webcool'); ?>/js/camera.min.js'></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jflickrfeed.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.tweet.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/fakeElement-grid.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.carousel.min.js" ></script>            
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/jquery.masonry.min.js" ></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/script.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public'); ?>/javascript/jalert/jquery.alert.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url('public'); ?>/javascript/jalert/css/jalert.css" />
        <script type="text/javascript" src="<?php echo $this->config->base_url('public'); ?>/javascript/helper.common.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public'); ?>/javascript/helper.site.js"></script>
    </head>
    <body>
        <img src="<?php echo $this->config->base_url('public/webcool/img/my_preloader1.gif'); ?>" id="preloader">
        <header>
            <a href="<?php echo $this->config->base_url(); ?>" class="logo"><img src="<?php echo $this->wconfig->item('common', 'logo'); ?>" alt=""></a>
            <a href="javascript:void(0)" class="filter_toggler"></a>
            <nav>
                <ul class="menu">
                    <?php foreach ($menu as $item){ ?>
                    <li class="<?php echo $item['menu_class']; ?>"><a href="<?php echo $item['menu_link'._LANG]; ?>"><?php echo $item['menu_title'._LANG]; ?></a></li>
                    <?php } ?>
                </ul>
            </nav>
            <nav class="mobile_header">
                <select id="mobile_select"></select>
            </nav>        
            <div class="clear"></div>
        </header>
        <div class="header_filter">
            <img src="<?php echo $this->config->base_url('public/webcool/img/filter_arrow.png'); ?>" class="arrow" alt="">
            <div class="share_block">
                Chia sẽ
                <a href="#" class="share_ico share_twitter"></a>
                <a href="#" class="share_ico share_facebook"></a>
            </div>
            <div class="search">
                <form name="search_form" method="get" action="http://www.google.com/cse" class="search_form">
                    <input type="hidden" name="cx" value="015234956028119908410:a4sigadk3qi">
                    <input type="hidden" name="ie" value="UTF-8">
                    <input type="text" name="q" value="Search the Site" title="Search the Site">
                </form>
            </div>
            <div class="filter_block">
                <div class="filter_navigation" >                
                    <ul class="splitter" id="options">
                        <li>
                            <ul class="cus-optionset">
                                
                                <?php if ($type == 'mau-web'){ ?>
                                <li class="selected"><a href="<?php echo $this->config->base_url('web-shop'); ?>" title="Tất cả mẫu web">Mẫu Web ></a></li>
                                <?php }else if ($type == 'san-pham'){ ?>
                                <li class="selected"><a href="<?php echo $this->config->base_url('san-pham'); ?>" title="Tất cả sản phẩm">Sản Phẩm ></a></li>    
                                <?php } ?>
                                
                                <?php if (!empty($cate_mau_web)){ ?>
                                <?php foreach ($cate_mau_web as $item){ ?>
                                <li><a href="<?php echo $this->config->base_url('web-shop/'.$item['cate_slug'._LANG]); ?>" title="<?php echo $item['cate_title_short'._LANG]; ?>"><?php echo $item['cate_title_short'._LANG]; ?></a></li>
                                <?php } ?>
                                <?php }else if (!empty($cate_sanpham)){ ?>    
                                <?php foreach ($cate_sanpham as $item){ ?>
                                <li><a href="<?php echo $this->config->base_url('san-pham/'.$item['cate_slug'._LANG]); ?>" title="<?php echo $item['cate_title_short'._LANG]; ?>"><?php echo $item['cate_title_short'._LANG]; ?></a></li>
                                <?php } ?>
                                <?php }else if (!empty($current_cate)){echo '<li><h1>'.$current_cate['cate_title'._LANG].'</h1></li>';} else echo '<li>'.$message.'</li>'; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>