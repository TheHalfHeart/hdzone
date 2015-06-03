<?php load_widget('common/header', array($metas, $cate, array(), $current_cate, 'mau-web')); ?>
<!-- C O N T E N T -->
<div class="content_wrapper">
    <div class="gallery_block">
        <div class="portfolio_block image-grid columns-grid" id="list">
            <?php foreach ($post as $item){ ?>
            <div data-category="else" class="portraits element">
                <div class="filter_img">
                    <img src="<?php echo $item['post_image']; ?>" alt="<?php echo $item['post_title'._LANG]; ?>" >
                    <div class="portfolio_wrapper"></div>
                    <div class="portfolio_content">
                        <h5><?php echo $item['post_title'._LANG]; ?></h5>
                        <p>
                            <?php echo $item['post_summary'._LANG]; ?>
                        </p>
                        <span class="ico_block">
                            <a href="<?php echo $item['post_image_large']; ?>" class="ico_zoom prettyPhoto"><span></span></a>
                            <a href="<?php echo $this->config->base_url('web-shop/'.$item['post_slug'._LANG].'-'.$item['post_id'].'.html'); ?>" class="ico_link" title="<?php echo $item['post_title'._LANG]; ?>"><span></span></a>                                                                                
                        </span>
                    </div>
                    <span class="post_type post_type_video"></span>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <?php echo $this->pagination->html(); ?>
        <script type="text/javascript" src="<?php echo $this->config->base_url('public/webcool'); ?>/js/grid_portfolio.js"></script>
    </div>
</div>
<?php load_widget('common/footer'); ?>