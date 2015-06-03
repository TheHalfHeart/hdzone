<?php load_widget('common/header', array($metas)); ?>
<div class="content_wrapper">
    <div class="content_block no-sidebar">
        <h1><span><?php echo $post['post_title'._LANG]; ?></span></h1>
        <div class="fl-container">
            <div class="posts-block">
                <div class="breadcrumbs">
                    <ul class="pathway">
                        <li><a href="<?php echo $this->config->base_url(); ?>" title="trang chủ">Home</a></li>
                        <li class="sep">:</li>
                        <li><a href="<?php echo $this->config->base_url('web-shop'); ?>" title="Mẫu Web">Web Shop</a></li>
                        <li class="sep">:</li>
                        <li><?php echo $post['post_title'._LANG]; ?></li>
                    </ul>
                </div>              
                <div class="row">
                    <div class="span_full">
                        <div class="blog_post_preview">
                            <div class="featured_image_full">
                                <?php $hinh = explode('|*|', trim($post['post_image_slide_small'], '|*|')); ?>
                                <div class="camera_slider">
                                    <div class="camera_wrap camera_azure_skin camera_slider_run">
                                        <?php foreach ($hinh as $item){ ?>
                                        <div data-thumb="<?php echo $item; ?>" data-src="<?php echo $item; ?>">
                                            <div class="camera_caption fadeFromLeft"></div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="clear"></div>
                                </div>                                
                            </div>
                            <div class="blog_info">
                                <span class="category"><strong>GIÁ TIỀN: </strong></span>
                                <strong style="font-size: 16px; color: blue">20.000.000 đ</strong>
                                <div style="height: 50px; line-height: 50px; text-align: center">
                                    <a href="#" class="shortcode_button btn_small btn_type4">DEMO</a>
                                    <a href="#" class="shortcode_button btn_small btn_type4">LIÊN HỆ</a>
                                </div>
                                <div class="clear"></div>
                                <span class="category"><strong>CHỦ ĐỀ: </strong> <a href="<?php echo $this->config->base_url('mau-web/'.$post['post_ref_cate_slug'._LANG]); ?>"><?php echo $post['post_ref_cate_title_short'._LANG]; ?></a></span>
                                <span class="blog_tags"><strong>TỪ KHÓA:</strong> 
                                    <?php foreach ($tags as $item){ ?>
                                    <a href="<?php echo $this->config->base_url('web-shop/tag/'.$post['tags_slug'._LANG]); ?>" rel="<?php echo $item['tags_title'._LANG]; ?>"><?php echo $item['tags_title'._LANG]; ?></a>  <br/>
                                    <?php } ?>
                                </span>
                            </div>                      
                            <div class="blog_post_text">
                                <article class="contentarea">
                                    <?php echo $post['post_content'._LANG]; ?>
                                </article>
                            </div>
                            <div class="clear"></div>
                        </div>      

                        <h3>Mẫu Web Mới</h3>
                        <div class="works_slider">
                            <div class="worksslider carouselslider" data-count="8">
                                <ul>
                                    <?php foreach ($related as $item){ ?>
                                    <li>
                                        <div class="item">
                                            <img src="<?php echo $item['post_image']; ?>" width="100%" height="100%" />
                                            <div class="portfolio_wrapper"></div>
                                            <a href="<?php echo $this->config->base_url('web-shop/'.$item['post_slug'._LANG].'-'.$item['post_id'].'.html'); ?>" class="wrapped_link"></a>
                                        </div>
                                    </li>  
                                    <?php } ?>
                                </ul>                        
                            </div>
                            <div class="clear"></div>
                        </div>  							
                    </div>
                    <div class="span_full">
                        <a href="javascript:history.back()" class="btn_back">Về Trang Trước</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"><!-- ClearFix --></div>
    </div>
</div>
<?php load_widget('common/footer'); ?>