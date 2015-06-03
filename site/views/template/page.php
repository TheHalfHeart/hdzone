<?php load_widget('common/header', array($metas)); ?>
<!-- C O N T E N T -->
<div class="content_wrapper">
    <div class="content_block">
        <h1><span><?php echo $page['page_title'._LANG]; ?></span></h1>
        <div class="breadcrumbs">
            <ul class="pathway">
                <li><a href="<?php echo $this->config->base_url(); ?>">Home</a></li>
                <li class="sep">:</li>
                <li><?php echo $page['page_title'._LANG]; ?></li>
            </ul>
        </div>

        <div class="contentarea">
            <div class="row">
                <div class="span_full">
                    <?php echo $page['page_content'._LANG]; ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php load_widget('common/footer'); ?>