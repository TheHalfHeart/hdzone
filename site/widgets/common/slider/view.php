<div class="span_full">
    <div class="camera_slider">
        <div class="camera_wrap camera_azure_skin camera_slider_run">
            <?php foreach ($slide as $item){ ?>
            <div data-thumb="<?php echo $item['slide_image']; ?>" data-src="<?php echo $item['slide_image']; ?>">
                <div class="camera_caption fadeFromLeft">
                    <h3><?php echo $item['slide_title'._LANG]; ?></h3>
                    <p><?php echo $item['slide_content'._LANG]; ?></p>
                </div>
            </div>
            <?php } ?>
        </div><!-- .camera_slider_run -->
        <div class="clear"><!-- ClearFix --></div>
    </div><!-- .camera_slider -->
    <!--//Slider-->                                                            
</div>
<div class="clear"><!-- ClearFix --></div> 