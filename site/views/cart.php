<?php load_widget('common/header', array($metas)); ?>
<link rel="stylesheet" href="<?php echo $this->config->base_url('public/shop'); ?>/css/pages/cart.css" type="text/css">
        <section class="page-content">
            <div class="page-block page-block-top light-bg grid-container">
                <div class="breadcrumbs grid-100 middle-color">
                    <a href="<?php echo $this->config->base_url(); ?>" class="dark-color active-hover">Trang Chủ</a>
                    <strong class="active-color">Đơn Hàng</strong>
                </div>
            </div>
            <div class="page-block page-block-bottom cream-bg grid-container">

                <div class="content-holder grid-100">
                    <div class="cart-header well-shadow well-table light-bg margin-bottom hide-on-mobile">
                        <div class="well-box-middle grid-60 tablet-grid-60">Tên Sản Phẩm</div>
                        <div class="well-box-middle align-center grid-10 tablet-grid-10">Số Lượng</div>
                        <div class="well-box-middle align-center grid-15 tablet-grid-15">Giá</div>
                        <div class="well-box-middle align-center last grid-15 tablet-grid-15 active-color">Tổng Giá</div>
                    </div>
                    <div class="cart-product-list well-shadow">
                        <?php $total = 0; ?>
                        <?php foreach ($this->my_cart->product as $item){ ?>
                        <?php
                        $total += $item['number']*$item['post_price'];
                        ?>
                        
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle cart-product-image align-center grid-10 tablet-grid-10">
                                <a href="<?php echo $this->config->base_url($item['post_slug'._LANG].'-'.$item['post_id'].'.html'); ?>" title="Tommy Mancini">
                                    <img src="<?php echo $item['post_image']; ?>" alt="" width="50px" height="50px"/>
                                </a>
                            </div>
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <strong><?php echo $item['post_title'._LANG]; ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-10 tablet-grid-10">
                                <input onkeypress="return onlyNumbers(event);" type="text" name="" class="text-input product-quantity dark-color light-bg edit-number-order order-row-number-<?php echo $item['post_id']; ?>" data-field="number" data-id="<?php echo $item['post_id']; ?>" data-init="<?php echo $item['number']; ?>" value="<?php echo $item['number']; ?>" />
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-15 tablet-grid-15 middle-color order-row-price-<?php echo $item['post_id']; ?> " data-val="<?php echo $item['post_price']; ?>">
                                <strong><?php echo number_format($item['post_price']); ?> đ</strong>
                            </div>
                            <div class="well-box-middle align-center last grid-15 tablet-grid-15 active-color">
                                <strong class="total-price order-row-total-price-<?php echo $item['post_id']; ?>" data-val="<?php echo $item['post_price']*$item['number']; ?>"><?php echo number_format($item['post_price']*$item['number']); ?> đ</strong>
                            </div>
                            <a class="cart-product-remove circle-button dark-bg active-bg-hover hide-on-desktop delete-product-order" href="#" data-val="<?php echo $item['post_id']; ?>"><span class="cancel"></span></a>
                        </div> 
                        <?php } ?>
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle cart-product-image align-center grid-10 tablet-grid-10"></div>
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50"></div>
                            <div class="well-box-middle well-border-gradient align-center grid-10 tablet-grid-10"></div>
                            <div class="well-box-middle well-border-gradient align-center grid-15 tablet-grid-15 middle-color" style="font-weight: bold; color:blue">
                                TỔNG GIÁ
                            </div>
                            <div class="well-box-middle align-center last grid-15 tablet-grid-15 active-color" style="color:blue">
                                <strong id="order-price"><?php echo number_format($total); ?> đ</strong>
                            </div>
                        </div> 
                        <div style="padding: 20px; float:right">
                            <a id="order-open-form" class="button-normal button-with-icon light-color active-gradient dark-gradient-hover" style="padding-right: 15px;">Đặt Hàng</a>
                        </div>
                    </div>
                    <script language="javascript">
                        $('.edit-number-order').change(function(){
                            site.shop.update(this);
                        });
                    </script>
                    <div class="content-with-sidebar grid-100" id="order-form" style="display: none">
                        <div class="with-shadow grid-100 light-bg">
                            <div class="content-page grid-100">
                                <h2 class="bigger-header with-border subheader-font">
                                    Nhập thông tin liên hệ
                                </h2>
                                <form class="content-form margin-bottom" action="#" method="POST">
                                    <div class="form-input">
                                        <label for="subject" class="middle-color">Tiêu đề</label>
                                        <input type="text" class="text-input dark-color light-bg" name="subject" id="order_title" value=""/>
                                    </div>
                                    <div class="form-input">
                                        <label for="name" class="middle-color">Tên đầy đủ</label>
                                        <input type="text" class="text-input dark-color light-bg" name="name" id="order_fullname" value=""/>
                                    </div>
                                    <div class="form-input">
                                        <label for="email" class="middle-color">E-mail</label>
                                        <input type="email" class="text-input dark-color light-bg" name="email" id="order_email" value=""/>
                                    </div>
                                    <div class="form-input">
                                        <label for="location" class="middle-color">Điện thoại</label>
                                        <input type="text" class="text-input dark-color light-bg" name="location" id="order_phone" value=""/>
                                    </div>
                                    <div class="form-input">
                                        <label for="location" class="middle-color">Địa chỉ</label>
                                        <input type="text" class="text-input dark-color light-bg" name="location" id="order_address" value=""/>
                                    </div>
                                    <div class="form-input">
                                        <label for="message" class="middle-color">Tin nhắn</label>
                                        <textarea class="textarea-input dark-color light-bg" name="message" id="order_note"></textarea>
                                    </div>
                                    <div class="form-input">
                                        <label for="subject" class="middle-color">Captcha</label>
                                        <input type="text" class="text-input dark-color light-bg" name="subject" id="order_captcha" value="" style="width: 100px;"/>
                                        <img src="<?php echo $this->config->base_url('api.php/captcha/order'); ?>" />
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" id="send-order" class="button-normal uppercase light-color middle-gradient dark-gradient-hover">Đặt Hàng</button>
                                    </div>
                                    <?php $this->security->set_action('action_shop_order'); ?>
                                </form>
                            </div>
                        </div>
                        <?php $this->security->set_action('action_shop_update'); ?>
                        <?php $this->security->set_action('action_shop_delete'); ?>
                        <?php $this->security->set_action('action_shop_order'); ?>
                        <script language="javascript">
                            $('.delete-product-order').click(function(){
                                var id = $(this).attr('data-val');
                                site.shop.remove(id, this);
                                return false;
                            });
                            
                            site.shop.openOrderForm();
                            
                            $('#send-order').click(function(){
                                site.shop.order();
                                return false;
                            });
                        </script>
                    </div> 
                </div> 
            </div> 
        </section>
        <script language="javascript">
            site.paging.slug_url = '';
            site.paging.element_append = '#paging';
            site.paging.have_paging = true;
        </script>
<?php load_widget('common/footer'); ?>