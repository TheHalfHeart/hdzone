<?php load_widget('common/header', array($metas)); ?>
<!-- C O N T E N T -->
<div class="content_wrapper">
    <div class="content_block no-sidebar">
        <h1><span><?php echo $page['page_title' . _LANG]; ?></span></h1>
        <div class="fl-container">
            <div class="posts-block">
                <div class="breadcrumbs">
                    <ul class="pathway">
                        <li><a href="<?php echo $this->config->base_url(); ?>">Home</a></li>
                        <li class="sep">:</li>
                        <li><?php echo $page['page_title' . _LANG]; ?></li>
                    </ul>
                </div>             
                <div class="contentarea">
                    <div class="row">
                        <div class="span_full">
                            <?php echo $page['page_content' . _LANG]; ?>
                            <hr>
                        </div>
                        <div class="span_full">
                            <h3>NHẬP THÔNG TIN LIÊN HỆ!</h3>
                            <form name="feedback_form" method="post" action="" class="feedback_form">
                                <input type="text" id="contact_title" value="" placeholder="Tiêu đề*" class="field-name form_field">
                                <input type="text" id="contact_phone" value="" placeholder="Điện thoại*"  class="field-name form_field">
                                <input type="text" id="contact_fullname" value="" placeholder="Tên của bạn*" class="field-name form_field">
                                <input type="text" id="contact_email" value="" placeholder="Email*"  class="field-email form_field">
                                <input type="text" id="contact_address" value="" placeholder="Địa chỉ*" class="field-name form_field">
                                <img src="<?php echo $this->config->base_url('api.php/captcha/contact'); ?>" />
                                <input type="text" id="contact_captcha" value="" placeholder="Mã bảo vệ*"  class="field-name form_field">
                                <textarea id="contact_content" cols="45" rows="5" title="Message*" class="field-message form_field" placeholder="Tin Nhắn"></textarea>
                                <a href="#" class="shortcode_button btn_small btn_type4" id="send-contact">Gửi Liên Hệ</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php $this->security->set_action('action_contact_add'); ?>
<script language="javascript">
    $('#send-contact').click(function(){
        site.contact.send();
        return false;
    });
</script>
<?php load_widget('common/footer'); ?>