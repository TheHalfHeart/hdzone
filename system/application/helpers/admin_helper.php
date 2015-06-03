<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// **********************************************************
// HELPER FOR DATA
// **********************************************************

// Danh sách template của page
function page_list_template(){
    return array(
        'template/page'     => 'Trang Nội Dung',
        'template/contact'  => 'Trang Liên Hệ',
        'template/service'  => 'Trang Dịch Vụ',
        'template/intro'    => 'Trang Giới Thiệu',
        'template/hosting'  => 'Trang Hosting',
        'template/domain'   => 'Trang Domain'
    );
}


// 0 => Đơn hàng mới, 1 => Xác nhận mua hàng, 2 => Đang giao hàng, 3 => Thành công, 4 => Đơn hàng bỏ, 
function order_status_title($key){
    if ($key == 0){
        return 'Đơn Hàng Mới';
    }
    if ($key == 1){
        return 'Đã Xác Nhận Mua';
    }
    if ($key == 2){
        return 'Đang Giao Hàng';
    }
    if ($key == 3){
        return 'Đã Giao Hàng';
    }
    if ($key == 4){
        return 'Đơn Hủy Bỏ';
    }
}

// **********************************************************
// HELPER FOR SLIDER
// **********************************************************

// Danh sách slide
function slide_position(){
    return array
    (
        1 => 'Home Slider'
    );
}

// Lấy tên slide
function slide_name($key){
    $slide = slide_position();
    return isset($slide[$key]) ? $slide[$key] : '';
}
// **********************************************************
// HELPER FOR DISPLAY INFO
// **********************************************************

// Hiển thị thông tin lỗi field bình thường
function showError($error = array(), $key = ''){
    if (isset($error[$key])){
        echo '<span class="error">'.$error[$key].'</span>';
    }
}

// Hiển thị thông tin lỗi field ngôn ngữ
function showErrorLang($error = array(), $key = ''){
    foreach (get_instance()->lang->lang_list as $code => $val){
        if (isset($error[$key.'_'.$code])){
            echo '<span class="error">'.$error[$key.'_'.$code].'</span>';
        }
    }
}

// Hiển thị status icon
function showStatus($time)
{
    if ($time == timer_private()){
        echo 'Ẩn';
    }
    else if ($time <= current_date_time_to_int()){
        echo 'Hiển thị';
    }
    else {
        echo 'Hẹn Giờ';
    }
}

// Hiển thị giá tri của key
function _val($filter, $key, $default = ''){
    echo isset($filter[$key]) ? $filter[$key] : $default;
}

// Thiết lập checked cho các input radio
function _checked_part($filter, $key, $value)
{
    if ($value == '0'){
        if ( !isset($filter[$key]) || $filter[$key] != '1'){
            echo ' checked ';
        }
    }
    else{
        if ( isset($filter[$key]) && $filter[$key] == '1'){
            echo ' checked ';
        }
    }
}

// Checked nếu tình trang của tin là public
function _timer_public($filter, $field = 'timer'){
    echo (!isset($filter[$field]) || $filter[$field] == '1') ? ' checked ' : '';
}

// Checked nếu tình trang của tin là private
function _timer_private($filter, $field = 'timer'){
    echo (isset($filter[$field]) && $filter[$field] == '0') ? ' checked ' : '';
}

// Checked nếu tình trang của tin là hẹn giờ
function _timer_timer($filter, $field = 'timer'){
    echo (isset($filter[$field]) && $filter[$field] == '2') ? ' checked ' : '';
}

// Kiểm tra selected cho select option
function _selected($filter, $key, $compare){
    if (isset($filter[$key]) && $filter[$key] === $compare){
        echo ' selected ';
    }
}

// Kiểm tra có đang sửa hay không
function _is_editting($item){
    $CI = get_instance();
    return (current_date_time_to_int() - $item['editting_date_time_int'] <= 12 && ($item['editting_user_username'] != $CI->auth->getItem('user_username') || $item['editting_token'] != $CI->security->get_csrf_hash()));
}

// Hiển thị nội dung đang edit nếu đang sửa
function _editting_message($item){
    $CI = get_instance();
    if (current_date_time_to_int() - $item['editting_date_time_int'] <= 12 && ($item['editting_user_username'] != $CI->auth->getItem('user_username') || $item['editting_token'] != $CI->security->get_csrf_hash())){
        echo '<br/><span class="help">Đang sửa bởi '.$item['editting_user_username'].'</span>';
    }
}

// **********************************************************
// HELPER FOR MULTI LANGUAGE
// **********************************************************

// Hiển thị URL của một tin ở bên ngoài
function lang_url_front($filter = array(), $key = array(), $slug = ''){
    $CI = & get_instance();
     foreach (get_instance()->lang->lang_list as $code => $val){
         $url = $CI->config->base_url($code.'/'.$slug);
         foreach ($key as $k){
             $url = str_replace('{'.$k.'}', $filter[$k."_".$code], $url);
         }
         echo '<strong>'.$val.'</strong> <a href="'.$url.'" target="_blank">'.$url.'</a> <br/>';
     }
}

// Dùng trong trường hợp liên hệ gữa category và news
function lang_field_data(&$datareturn, $datainput, $fieldreturn, $fieldinput){
    foreach (get_instance()->lang->lang_list as $code => $val){
        if (isset($datainput[$fieldinput.'_'.$code])){
            $datareturn[$fieldreturn.'_'.$code] = $datainput[$fieldinput.'_'.$code];
        }
    }
}

// Tạo field theo ngôn ngữ hiện tại
function lang_field($key){
    $CI = get_instance();
    $lang = $CI->input->get('lang');
    return $key.'_'. (isset($CI->lang->lang_list[$lang]) ? $lang : $CI->lang->lang_default);
}

// Lấy field theo ngôn ngữ mặc định
function lang_default_field($key){
    return $key.'_'.get_instance()->lang->lang_default;
}

// Hiển thị language multilange dạng markup
function _lang_val($filter, $field, $echo = true)
{
    $text = '';
    foreach (get_instance()->lang->lang_list as $code => $val){
        if (isset($filter[$field.'_'.$code])){
            $text .= '&lt;'.$code.'&gt;';
            $text .= $filter[$field.'_'.$code];
            $text .= '&lt;/'.$code.'&gt;';
        }
    }
    
    if (!$echo) return $text;
    echo $text;
}

// Lấy giá trị các field multilang
function lang_generator_field(&$data, $field){
    $CI = get_instance();
    foreach ($CI->lang->lang_list as $key => $val){
        $data[$field.'_'.$key] = (trim((string)$CI->input->post($field.'_'.$key)));
    }
}

// Chuyển dữ liệu sang firse char ascii
function lang_first_char_ascii(&$data, $title_key, $first_char_key){
    $CI = get_instance();
    foreach ($CI->lang->lang_list as $key => $val){
        $data[$first_char_key.'_'.$key] = first_char_ascii($data[$title_key.'_'.$key]);
    }
}

// Chuyển dữ liệu sang slug
function lang_to_slug_int(&$data, $slug_key, $slug_int_key){
    $CI = get_instance();
    foreach ($CI->lang->lang_list as $key => $val){
        $data[$slug_int_key.'_'.$key] = to_slug_int($data[$slug_key.'_'.$key]);
    }
}

// Chuyển dữ liệu sang dạng clear unicode
function lang_clear_unicode(&$data, $title_key, $clear_utf8_key){
    $CI = get_instance();
    foreach ($CI->lang->lang_list as $key => $val){
        $data[$clear_utf8_key.'_'.$key] = clear_unicode($data[$title_key.'_'.$key]);
    }
}

// Hiển thị control chọn ngôn ngữ ở form danh sách
function lang_show_list_page()
{
    $CI = get_instance();
    $lang_active = $CI->lang->get_lang($CI->input->get('lang'));
    
    echo '<div class="lang-wrapper-field">';
    foreach ($CI->lang->lang_list as $key => $val){
        echo '<span class="vi multilang '.(($lang_active == $key) ? 'active' : '' ).'" langcode="'.$key.'">';
        echo '<img src="public/javascript/i18n/flags/'.$key.'.png">';
        echo '</span>';
    }
    echo '</div>';
}


// **********************************************************
// HELPER FOR CKFINDER AND CKEDITOR
// **********************************************************

// Tạo folder upload cho module
function createFolderUpload($type, $module, $subs){
    $path = 'upload/'.$module.'/'.$type;
    if (!is_dir($path)){
        mkdir($path);
    }
    foreach (explode('/', $subs) as $sub){
        $path .= '/'.$sub;
        if (!is_dir($path)){
            @mkdir($path);
        }
    };
}

// Tạo input upload hình cho config
function _image_config($filter, $key, $id){
    echo '<input type="text" id="'.$id.'" onchange="jsAdmin.ckfinder.inputChange(\''.$id.'\', \'image_thumnails_'.$id.'\');" value="'; _val($filter, $key); echo '" size="100" maxlength="500"/>';
    echo '<button onclick="jsAdmin.ckfinder.brownServer(\''.$id.'\',\'image_thumnails_'.$id.'\')">Server</button>';
    echo '<br/><br/>
          <div class="thumnails" id="image_thumnails_'.$id.'">';
    if (isset($filter[$key]) && $filter[$key]){
        echo '<img src="'.$filter[$key].'" />
             <div><a href="#" onclick="return jsAdmin.ckfinder.remove(\''.$id.'\', \'image_thumnails_'.$id.'\');">Xóa</a></div>';
    }
    echo '</div>';
}

// Tạo input upload hình lên server
function _image_server($filter, $key, $startup_image_path){
    echo '<input type="text" id="image_server" onchange="jsAdmin.ckfinder.inputChange(\'image_server\', \'image_thumnails_server\');" value="'; _val($filter, $key); echo '" size="100"/>';
    echo '<button onclick="jsAdmin.ckfinder.brownServer(\'image_server\',\'image_thumnails_server\', \''.$startup_image_path.'\')">Server</button>';
    echo '<br/><br/>
          <div class="thumnails" id="image_thumnails_server">';
    if (isset($filter[$key]) && $filter[$key]){
        echo '<img src="'.$filter[$key].'" />
             <div><a href="#" onclick="return jsAdmin.ckfinder.remove(\'image_server\', \'image_thumnails_server\');">Xóa</a></div>';
    }
    echo '</div>';
}
function _image_server_large($filter, $key, $startup_image_path){
    echo '<input type="text" id="image_server_large" onchange="jsAdmin.ckfinder.inputChange(\'image_server_large\', \'image_thumnails_server_large\');" value="'; _val($filter, $key); echo '" size="100"/>';
    echo '<button onclick="jsAdmin.ckfinder.brownServer(\'image_server_large\',\'image_thumnails_server_large\', \''.$startup_image_path.'\')">Server</button>';
    echo '<br/><br/>
          <div class="thumnails" id="image_thumnails_server_large">';
    if (isset($filter[$key]) && $filter[$key]){
        echo '<img src="'.$filter[$key].'" />
             <div><a href="#" onclick="return jsAdmin.ckfinder.remove(\'image_server_large\', \'image_thumnails_server_large\');">Xóa</a></div>';
    }
    echo '</div>';
}
// Tạo input upload hình lên service khác
function _image_service($filter, $key)
{
    echo '<input type="text" id="image_service" onchange="jsAdmin.ckfinder.inputChange(\'image_service\', \'image_thumnails_service\');"  value="'; _val($filter, $key); echo '" size="100"/> ';
    echo '<button id="render_avatar">Get Link</button>';
    echo '<br/><br/><div class="thumnails" id="image_thumnails_service">';
    if (isset($filter[$key]) && $filter[$key]){
        echo '<img src="'.$filter[$key].'" />
             <div><a href="#" onclick="return jsAdmin.ckfinder.remove(\'image_service\', \'image_thumnails_service\');">Xóa</a></div>';
    }
    echo '</div>';
}

// Xóa danh sách folder, file và subfolder
function removeMedia($dir) 
{
    if (is_dir($dir))
    {
        $structure = glob(rtrim($dir, "/").'/*');
        if (is_array($structure)) {
            foreach($structure as $file) {
                if (is_dir($file)) recursiveRemove($file);
                elseif (is_file($file)) @unlink($file);
            }
        }
    }
    return false;
}

// Xóa tất cả các file của dir
function removeAllMedia($dir, $root, $sub)
{
        removeMedia($dir);
        
        $fol = explode('/', $sub);
        
        if (is_dir("$root".$fol[0].'/'.$fol[1].'/'.$fol[2].'/'.$fol[3]) && count(glob("$root".$fol[0].'/'.$fol[1].'/'.$fol[2].'/'.$fol[3].'/*')) == 0){
            @rmdir("$root".$fol[0].'/'.$fol[1].'/'.$fol[2].'/'.$fol[3]);
        }
        if (is_dir("$root/".$fol[0].'/'.$fol[1].'/'.$fol[2]) && count(glob("$root/".$fol[0].'/'.$fol[1].'/'.$fol[2].'/*')) == 0){
            @rmdir("$root".$fol[0].'/'.$fol[1].'/'.$fol[2]);
        }
        if (is_dir("$root/".$fol[0].'/'.$fol[1]) && count(glob("$root/".$fol[0].'/'.$fol[1].'/*')) == 0){
            @rmdir("$root".$fol[0].'/'.$fol[1]);
        }
        if (is_dir("$root".$fol[0]) && count(glob("$root".$fol[0].'/*')) == 0){
            @rmdir("$root".$fol[0]);
        }
}

// **********************************************************
// HELPER FOR ROLE
// **********************************************************

// Kiểm tra xem có quyền edit user ha không
function can_edit_user($user_id, $user_level, $user_is_root)
{
    // Show button edit cho user
    $CI = get_instance();
    
    // Trường hợp người edit không phải admin
    if (!$CI->auth->isAdmin()){
        return false;
    }
    
    // Lấy thông tin người sửa
    $current_id     = $CI->auth->getItem('user_id');
    $current_level  = $CI->auth->getItem('user_level');
    $current_is_root= $CI->auth->isRoot();
    
    // Trường hợp người edit sửa chính mình
    if ($user_id == $current_id){
        return true;
    }
    
    // Trường hợp người sửa không phải root, chỉ edit cấp độ thấp
    if (!$current_is_root && $user_level <= $current_level){
        return false;
    }
    
    return true;
}

// Kiểm tra có quyền lưu dữ liệu ha không
function can_edit_user_status($user_id, $user_is_root)
{
    // Show button edit cho user
    $CI = get_instance();
    
    // Trường hợp người edit không phải admin
    if (!$CI->auth->isAdmin()){
        return false;
    }
    
    // Trường hợp sửa chính mình
    if ($user_id == $CI->auth->getItem('user_id')){
        return false;
    }
    
    // Trường hợp sửa root
    if ($user_is_root){
        return false;
    }
    
    return true;
}

// Kiểm rta có quyền edit người dùng theo level hay không
function can_edit_user_level($level)
{
    $CI = get_instance();
    
    // Nếu Root
    if ($CI->auth->isRoot()){
        return true;
    }
    
    // Không phải root thì chỉ được sửa cấp dưới
    if ($level > 10){
        return true;
    }
    
    return false;
}
?>
