<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!_is_editting($filter)){ ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#news/post_lists">Tin Tức</a>
</div>
<script language="javascript">
 
function addImageSlide(){
    var html = '<div class="item">';
             html += '<h2 onclick="removeImageSlide(this);">X</h2>';
             html += '  <div class="small">';
             html += '      <img src="" class="img-small"/>';
             html += '      <span><button onclick="jsAdmin.ckfinder.brownServer1(this,\'<?php echo $ck_img_path ?>\')">Đăng Hình</button></span>';
             html += '  </div>';
             html += '</div>';

     $('#image-slider').append(html);
}

function removeImageSlide(obj){
    $(obj).parent().remove();
}

</script>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Sửa Bài Viết</h1>
        <div class="buttons">
            <?php if (!$this->auth->isContributor() || $filter['post_timer_date_time_int'] == timer_private()){ ?>
                <a class="button" id="click-save">Lưu</a>
            <?php } ?>
            <a class="button" id="click-back">Trở Lại</a>
        </div>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <div class="htabs" id="tabs">
            <a href="#tab-general">Thông Tin</a>
            <a href="#tab-ref">Liên Kết</a>
            <a href="#tab-image">Hình Ảnh</a>
            <a href="#tab-seo">SEO</a>
            <a href="#tab-other">Khác</a>
            <div id="control-language"></div>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <div id="tab-general">
                <table class="form">
                    <tbody>
                        <?php if (!$this->auth->isContributor()){ ?>
                        <tr>
                            <td>
                                <strong>Public</strong>
                                <span class="help">Hiển thị, ẩn, hẹn giờ hiển thị</span>
                            </td>
                            <td>
                                <input type="radio" name="timer" value="1" id="timer_public" <?php _timer_public($filter); ?>/> 
                                <label for="timer_public">Public</label>
                                <input type="radio" name="timer" value="0" id="timer_private" <?php _timer_private($filter); ?>/>
                                <label for="timer_private">Private</label>
                                <input type="radio" name="timer" value="2" id="timer_timer" <?php _timer_timer($filter); ?>/>
                                <label for="timer_timer"><strong>Timer</strong></label>
                                <input type="text" id="timer_date" class="timer" value="<?php _val($filter, 'timer_day'); ?>" placeholder="dd-mm-yyyy" style="width: 70px;"/>
                                <input type="text" id="timer_time" class="timer" value="<?php _val($filter, 'timer_time'); ?>" placeholder="hh:mm:ss" style="width: 60px;"/>
                                <?php showError($errors, 'post_timer_date_time_int'); ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <strong>Tiêu Đề <span class="required">(*)</span></strong>
                                <span class="help">Tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="post_slug" to-title="post_title" id="post_title" name="post_title" value="<?php _lang_val($filter, 'post_title'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'post_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Slug <span class="required">(*)</span></strong>
                                <span class="help">Slug chỉ chấp nhận số, dấu gạch ngang, chữ thường không dấu và tối đa 500 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" to-slug="post_slug" to-title="post_title" id="post_slug" name="post_slug" value="<?php _lang_val($filter, 'post_slug'); ?>" maxlength="500" size="100"></div>
                                <?php showErrorLang($errors, 'post_slug'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Giới Thiệu Ngắn</strong>
                                <span class="help">Giới thiệu ngắn sơ lược về tin, tối đa 1000 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="textarea" id="post_summary" name="post_summary" value="<?php _lang_val($filter, 'post_summary'); ?>" maxlength="1000" cols="100" rows="5"></div>
                                <?php showErrorLang($errors, 'post_summary'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nội Dung</strong>
                                <span class="help">Nội dung chi tiết của tin</span>
                            </td>
                            <td>
                                <div class="multilang" type="ckeditor" toolbar="full" ck-id="<?php echo $filter['post_id']; ?>" ck-start-path="<?php echo date('Y/m/d/',$filter['post_add_date_int']).$filter['post_id']; ?>" ck-module="news" id="post_content" name="post_content" value="<?php _lang_val($filter, 'post_content'); ?>"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <style>
                #multicate li{list-style: none}
                #multicate li ul{margin: 0 !important; padding: 0 0 0 20px !important}
                #multicate {
                    max-height: 200px;
                    overflow-y: scroll;
                    border: solid 1px #CCCCCC;
                    background:#FAFAFA;
                    padding: 10px;
                }
            </style>
            <div id="tab-ref">
                <table class="form">
                    <tbody>
                        <tr style="display: none !important">
                            <td>
                                <strong> Chuyên Mục</strong>
                                <span class="help">Chuyên mục của tin</span>
                            </td>
                            <td>
                                <select id="post_ref_cate_id"></select>
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td>
                                <strong>Tags</strong>
                                <span class="help">Nhập tìm tags có sẵn hoặc nhấn Enter để thêm một tags mới</span>
                            </td>
                            <td>
                                <div style="margin: 3px; font-weight: bold">Danh Sách Các Tags Có Sẵn</div>
                                <div id="list-all-tags"></div>
                                <div style="margin: 10px 3px 3px 3px; font-weight: bold">Thêm Tags Mới</div>
                                <input type="text" id="input_add_tags" placeholder="Nhập Tags Và Enter"  style="margin: 3px;" value="" size="30" maxlength="500"/>
                                
                                <div style="margin: 10px 3px 3px 3px; font-weight: bold">Tags Bạn Đã Chọn Cho Tin Này</div>
                                <div id="tags-list">
                                    <?php foreach ($tags as $item){ ?>
                                    <div idval="<?php echo $item['tags_id']; ?>" class="tags"><span class="nametags"><?php echo $item[lang_field('tags_title_short')]; ?></span><span class="removetags">x</span></div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td>
                                <strong> Tin Liên Quan</strong>
                                <span class="help">Nhập ID tin liên quan sau đó nhấn Enter</span>
                            </td>
                            <td>
                                <div style="margin: 3px 3px 3px 3px; font-weight: bold">Thêm Tin Related Mới</div>
                                <input type="text" id="input_add_related" style="margin: 3px;" onkeypress="return onlyNumbers(event)" placeholder="Nhập ID Tin Và Enter" value="" size="20" maxlength="500"/>
                                <div style="margin: 10px 3px 3px 3px; font-weight: bold">Danh Sách Tin Related</div>
                                <div id="related-list">
                                     <?php foreach ($related as $item){ ?>
                                    <div class="related" idval="<?php echo $item['post_id']; ?>"><span class="namerelated"><?php echo $item['post_title']; ?></span><span class="removerelated">x</span></div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-image">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Hình Đại Diện</strong>
                                <span class="help">- Tối đa 500 ký tự. Có thể nhập URL có sẵn hoặc dùng chức năng up hình lên server bằng cách bấm vào nút Server</span>
                                <span class="help">- Hãy resize hình ảnh về mức medium để website chạy nhanh hơn</span>
                            </td>
                            <td>
                                <?php _image_server($filter, 'post_image', $ck_img_path); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Hình Đại Diện Lớn</strong>
                                <span class="help">- Tối đa 500 ký tự. Có thể nhập URL có sẵn hoặc dùng chức năng up hình lên server bằng cách bấm vào nút Server</span>
                                <span class="help">- Hãy resize hình ảnh về mức medium để website chạy nhanh hơn</span>
                            </td>
                            <td>
                                <?php _image_server_large($filter, 'post_image_large', $ck_img_path); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Hình Slider</strong>
                            </td>
                            <td>
                                <style>
                                    #image-slider .item{
                                        height: 220px;
                                        float:left;
                                        width: 220px;
                                        background:#e0dfe3;
                                        position: relative;
                                        margin: 10px;
                                        border:solid 1px gray;
                                    }
                                    
                                    #image-slider .item img{
                                        width: 100%; height: 100%;
                                    }
                                    
                                    #image-slider .item .small{
                                        position: relative;
                                        float: left;
                                        margin: 10px;
                                        width: 200px;
                                        height: 200px;
                                    }
                                    
                                    #image-slider .item .large{
                                        margin: 10px;
                                        position: relative;
                                        float: left;
                                        margin-left: 10px;
                                        width: 200px;
                                        height: 200px;
                                    }
                                    #image-slider .item span{
                                        display: block;
                                        width: 200px;
                                        text-align: center;
                                        position: absolute;
                                        top: 0px;
                                        right: 0px;
                                    }
                                    #image-slider .item h2{
                                        position: absolute;
                                        top:0px;
                                        right: 0px;
                                        width: 20px;
                                        background: black;
                                        color: white;
                                        cursor: pointer;
                                        height: 20px;
                                        border:solid 1px gray;
                                        z-index: 999;
                                        margin:0px;
                                        line-height: 20px;
                                        text-align: center;
                                    }
                                </style>
                                
                                <div id="image-slider">
                                     <?php 
                                     $filter['post_image_slide_small'] = trim($filter['post_image_slide_small'], '|*|'); 
                                     
                                     if ($filter['post_image_slide_small'])
                                     {
                                        $img_small = explode('|*|', $filter['post_image_slide_small']);
                                        
                                        if (count($img_small)){

                                            foreach ($img_small as $key => $val)
                                            {
                                            ?>
                                            <div class="item">
                                                <h2 onclick="removeImageSlide(this);">X</h2>
                                                <div class="small">
                                                    <img src="<?php echo $val; ?>" class="img-small"/>
                                                    <span><button onclick="jsAdmin.ckfinder.brownServer1(this,'<?php echo $ck_img_path ?>');">Đăng Hình</button></span>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                </div>
                                <div style="clear:both"></div>
                                <a class="button" id="click-save" style="margin-left: 10px;" onclick="addImageSlide();">Thêm Hình</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-seo">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Seo Title</strong>
                                <span class="help">Tiêu đề hiển thị phía trên cùng của website, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="post_seo_title" name="post_seo_title" value="<?php _lang_val($filter, 'post_seo_title'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'post_seo_title'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Keywords</strong>
                                <span class="help">Danh sách keywords của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="post_seo_keywords" name="post_seo_keywords" value="<?php _lang_val($filter, 'post_seo_keywords'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'post_seo_keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Description</strong>
                                <span class="help">Phần mô tả ngắn của tin, tối đa 255 ký tự</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="post_seo_description" name="post_seo_description" value="<?php _lang_val($filter, 'post_seo_description'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'post_seo_description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Robots</strong>
                                <span class="help">Chế độ index của website. Ví dụ: index, noindex, follow, nofollow, noodp, noydir</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'post_seo_robots'); ?>" id="post_seo_robots" size="100" maxlength="255"/>
                                <?php showError($errors, 'post_seo_robots'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Seo Last Visit</strong>
                                <span class="help">Thời gian viếng thăm lại website. Ví dụ: 1 days, 2 days</span>
                            </td>
                            <td>
                                <input type="text" value="<?php _val($filter, 'post_seo_last_visit'); ?>" id="post_seo_last_visit" size="100" maxlength="255"/>
                                <?php showError($errors, 'post_seo_last_visit'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Main Keyword</strong>
                                <span class="help">Từ khóa chính của bài</span>
                            </td>
                            <td>
                                <div class="multilang" type="text" id="post_seo_main_keyword" name="post_seo_main_keyword" value="<?php _lang_val($filter, 'post_seo_main_keyword'); ?>" maxlength="255" size="100"></div>
                                <?php showErrorLang($errors, 'post_seo_main_keyword'); ?>
                                <div id="seo-test"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-other">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>ID</strong>
                                    <span class="help">Mỗi tin sẽ có một ID duy nhất</span>
                                </td>
                                <td>
                                    <strong><?php echo $filter['post_id']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ngày Đăng</strong>
                                    <span class="help">Thông tin ngày đăng và người đăng</span>
                                </td>
                                <td>
                                    <span>Đăng ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['post_add_date_time'])); ?></strong> 
                                    <span>Bởi</span>: <strong><?php echo $filter['post_add_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php if ($filter['post_last_update_user_id']){ ?>
                            <tr>
                                <td>
                                    <strong>Ngày Cập Nhật</strong>
                                    <span class="help">Thông tin ngày cập nhật và người cập nhật cuối cùng</span>
                                </td>
                                <td>
                                    <span>Cập nhật lần cuối ngày</span>: <strong><?php echo date('d-m-Y H:i:s', strtotime($filter['post_last_update_date_time'])); ?></strong>
                                    <span>Bởi</span>:  <strong><?php echo $filter['post_last_update_user_username']; ?></strong> <br/>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <strong>URL</strong>
                                    <span class="help">Đường link xem bài viết ngoài website</span>
                                </td>
                                <td>
                                    <?php echo $this->config->base_url('tin-tuc/'.$filter['post_slug_vi'].'-'.$filter['post_id'].'.html'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php $this->security->set_action('post_edit'); ?>
        </form>
    </div>
    <input type="hidden" id="interval-news-post-editting" value="news-cate-editting"/>
</div>
<?php $this->news_cate_model->to_js_list($cate); ?>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        // INIT MENU
        var str = '<option value="0">Kho Lưu Trữ</option>';
        function showParent(cateList, parent_id, dem, current_id)
        {
            var arrayForeach = new Array();
            var cateContinue = new Array();

            for(var i = 0; i < cateList.length; i++){
                if (cateList[i].cate_ref_parent_id == parent_id){
                    arrayForeach.push(cateList[i]);
                }
                else{
                    cateContinue.push(cateList[i]);
                }
            }

            if (arrayForeach.length > 0)
            {
                for (i = 0; i < arrayForeach.length; i++)
                {
                    str += '<option value="'+arrayForeach[i].cate_id +'"';
                    
                    if (arrayForeach[i].cate_id == current_id){
                        str += ' selected style="background:gray" ';
                    }
                    
                    str += '">';
                    for (var j = 0; j <= dem; j++){
                        str += '|---';
                    }
                    str += arrayForeach[i].<?php echo lang_field('cate_title_short'); ?>;
                    str += '</option>';
                    showParent(cateContinue, arrayForeach[i].cate_id, dem+1, current_id);
                }
            } 
        }
        
        showParent(cate, 0, 0, <?php echo (int)$filter['post_ref_cate_id']; ?>);
        
        $('#post_ref_cate_id').append(str);
        
        // Lang
        jsAdmin.loadLang();
        
        // Title Page
        jsAdmin.changeTitle('Sửa Tin Tức');
        
        // Menu
        jsAdmin.changeMenu('news/post_lists');
        
        // Ckfinder
        jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/news/connector/<?php echo $filter['post_id']; ?>/Images';
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        // Related And Tags
        jsNews.init();
        
        // Timer
        jsAdmin.loadTimer();
        
        $('#click-back').click(function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'news/post_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
        
        <?php if (!$this->auth->isContributor() || $filter['post_timer_date_time_int'] == timer_private()){ ?>
        // save
        $('#click-save').click(function()
        {
            var data = 
            {
                post_id             : <?php echo $filter['post_id']; ?>,
                post_ref_tags_id    : jsNews.getListTags().join(' '),
                post_image_large    : trim($('#image_server_large').val()),
                post_ref_related    : jsNews.getListRelated().join(' '),
                post_ref_cate_id    : trim($('#post_ref_cate_id').val()),
                post_image          : trim($('#image_server').val()),
                post_seo_robots     : trim($('#post_seo_robots').val()),
                post_seo_last_visit : trim($('#post_seo_last_visit').val()),
                post_edit            : $('#post_edit').val()
            };
            
            <?php if (!$this->auth->isContributor()){ ?>
            // Access Timer
            var timer = $('input[name="timer"]:checked').val();
            if (timer.toString() === '2')
            {
                timer = trim($('#timer_date').val()) + ' ' + trim($('#timer_time').val());
                if (!is_timer(timer)){
                    jAlert('Định dạng ngày hiển thị không đúng', 'Lỗi ngày tháng');
                    return false;
                }
            }
            else if (timer.toString() === '1'){
                var tmp = trim($('#timer_date').val()) + ' ' + trim($('#timer_time').val());
                if (!isEmpty(tmp)){
                    timer = tmp;
                }
            }
            data.post_timer = timer;
            <?php } ?>
                
            // Validate data
            if (i18n_is_empty('post_title')){
                jAlert('Bạn chưa nhập tiêu đề đầy đủ', 'Lỗi tiêu đề');
                return false;
            }
            
            if (!i18n_is_slug('post_slug')){
                jAlert('Slug chỉ chấp nhận số, dấu gạch ngang và chữ thường không dấu', 'Lỗi link slug');
                return false;
            }

            // Add Data
            i18n_val_text(data, 'post_title');
            i18n_val_text(data, 'post_slug');
            i18n_val_text(data, 'post_summary');
            i18n_val_ckeditor(data,'post_content');
            i18n_val_text(data, 'post_seo_title');
            i18n_val_text(data, 'post_seo_keywords');
            i18n_val_text(data, 'post_seo_description');
            i18n_val_text(data, 'post_seo_main_keyword');
            
            var img = $('.img-small');
            
            str = '';
            for (var i = 0; i < img.length; i++){
                str += $(img[i]).attr('src') + '|*|';
            }

            data.post_image_slide_small = str;
            
             var img = $('.img-large');
            str = '';
            for (var i = 0; i < img.length; i++){
                str += $(img[i]).attr('src') + '|*|';
            }

            data.post_image_slide_large = str;
            
            jsAdmin.sendAjax('post', 'text', data, 'news/post_edit?post_id=<?php echo $filter['post_id']; ?>', function (result)
            {
                result = trim(result);
                if (result == '100'){
                    jAlert('Sửa thành công', 'Thành công', function (){
                        jsAdmin.redirect('news/post_edit?post_id=<?php echo $filter['post_id']; ?>');
                    });
                }
                else if (result == '102'){
                    jAlert('Chuyên mục bạn chọn không tìm thấy', 'Lỗi chuyên mục');
                }
                else if (result == '101'){
                    jAlert('Lỗi xử lý hoặc do kết nối mạng quá chậm', 'Lỗi ...');
                }
                else{
                    jsAdmin.render(result);
                }
            });
            return false;
        });
        <?php } ?>
        
        // Update Editting
        clearInterval(jsAdmin.editting);
        jsAdmin.editting = setInterval(function()
        {
            if (!isEmpty($('#interval-news-post-editting').val())){
                jsAdmin.sendHideAjax('get', 'text', {post_id:<?php echo $filter['post_id']; ?>}, 'news/post_editting');
            }
            else{
                clearInterval(jsAdmin.editting);
            }
        },10000);
    });    
</script>

<?php } ?>

<?php if (_is_editting($filter)){ ?>
    <script language="javascript">
        $('#content').html('');
        jAlert('Bài viết đang được sửa bởi <?php echo $filter['editting_user_username']; ?>', 'Lỗi phiên làm việc', function(){
            var hash_back = jsAdmin.urlBack.level1.hash();
            if (!hash_back){
                    hash_back = 'news/post_lists';
            }
            jsAdmin.redirect(hash_back, 'get');
        });
    </script>
<?php }?>
