<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function new_table($database, $table) 
{
    if (!file_exists('./system/database/' . $database . '/' . $table . EXT)) {
        die('This file ' . './system/database/' . $database . '/' . $table . EXT . ' not found');
    }
    require_once('./system/application/core/MY_Table' . EXT);
    require_once('./system/database/' . $database . '/' . $table . EXT);
    $classname = ucfirst(str_replace('/', '_', $database) . '_' . $table . '_table');
    return new $classname();
}

function load_widget($widget, $parameter = array()){
    $CI = & get_instance();
    echo $CI->load->widget($widget, $parameter);
}

function boolean_mode($str, $plus = '+'){
    return preg_replace('/[^a-z0-9\+\s]/', '', preg_replace("/\s/", " $plus", ' '.clear_unicode($str, ' ')));
}

function current_date_time_mysql() {
    return date('Y-m-d H:i:s');
}

function current_date_to_int() {
    return strtotime(date('Y-m-d'));
}

function current_date_time_to_int() {
    return strtotime(date('Y-m-d H:i:s'));
}

function first_char_ascii($char) {
    return ord(clear_unicode($char));
}

function lower_string_to_int($str) {
    return sprintf("%u", crc32(mb_strtolower($str)));
}

function to_slug($slug){
    return preg_replace('/-+/','-' , clear_unicode($slug, '-'));
}

function to_slug_int($str){
   return lower_string_to_int($str); 
}

function email_hash($email) {
    return sprintf("%u", crc32(mb_strtolower($email)));
}

function username_hash($username) {
    return sprintf("%u", crc32(mb_strtolower($username)));
}

function title_clear_utf8($str){
    return clear_unicode($str, ' ');
}

function timer_private(){
    return '4000000000';
}

function password_hash($password, $num_md5 = 5){ // Before Use You Have To Md5 Password 5th
    for ($i = 0; $i < $num_md5; $i++){
        $password = md5($password);
    }
    return md5(md5('!@#$%^&*<>?_+=').$password);
}

function string_to_int($str) {
    return sprintf("%u", crc32($str));
}

function clear_unicode($str, $seperator = ' ') {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = str_replace(' ', $seperator, $str);
    return $str;
}

// MULTILANG
function lang_folder($code){
    $CI = & get_instance();
    return isset($CI->lang->lang_folder[$code]) ? $CI->lang->lang_folder[$code] : '';
}
?>
