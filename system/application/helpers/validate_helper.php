<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function is_ids($string) {
    if (preg_match('/^\d+(\s\d+)*(\s\d+)?$/', $string)) {
        return true;
    }
    return false;
}

function is_slug($string = '') {
    if (preg_match('/^([a-z0-9-])+$/', $string)) {
        return true;
    }
    return false;
}

function is_username($string = '') {
    if (preg_match('/^[\d\w_]{5,15}$/', $string)) {
        return true;
    }
    return false;
}

function is_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function is_required($str) {
    return (trim($str) == '') ? FALSE : TRUE;
}

function is_max_length($val = '', $str = '') {
    return (strlen($str) <= $val) ? TRUE : FALSE;
}

function is_min_length($val, $str) {
    return (strlen($str) >= $val) ? TRUE : FALSE;
}

function is_length_between($min, $max, $str = '') {
    $length = strlen($str);
    return (($length >= $min) && ($length <= $max)) ? TRUE : FALSE;
}

function is_exac_length($val, $str) {
    return (strlen($str) == $val);
}

function is_timer_int($val) {
    return ((int) $val > 0);
}

function is_exac_string($compare, $val) {
    return ((string) $compare == (string) $val);
}

function is_website($str) {
    return true;
}

function is_phone($str) {
    return true;
}

function is_radio($str) {
    return ($str == '0' || $str == '1') ? true : false;
}

function is_number($str) {
    return is_numeric($str);
}

function is_number_between($min, $max, $num_input) {
    $num_input = (int) $num_input;
    return ( ($num_input >= (int) $min) && ($num_input <= $max) );
}

function in_template_page($key){
    return ($key == '' || array_key_exists($key, page_list_template()));
}

function in_template_news($key){
    return ($key == '' || array_key_exists($key, news_list_template()));
}

function in_user_level ($role){
    return (in_array((int)$role, array(10,20,30,40,50,60)));
}

function in_slide_position($pos){
    return true;
}

?>
