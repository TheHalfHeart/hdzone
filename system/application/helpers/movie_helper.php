<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Danh sách tem của phim
function movie_get_tems(){
    return array(
        1 => 'Phim bộ',
        2 => 'Phim 3D'
    );
}

// Lấy tiêu đề  tem theo key 
function movie_get_tem($key){
    $tem = movie_get_tem();
    return isset($tem[$key]) ? $tem[$key] : false;
}

// Danh sách icon của phim
function movie_get_icons(){
    return array(
        'ipad' => ''
    );
}

// Lấy icon theo key
function movie_get_icon($key){
    $tem = movie_get_icons();
    return isset($tem[$key]) ? $tem[$key] : false;
}

// Danh sách ngôn ngữ
function move_get_languages(){
    return array(
        '0' => array('key' => 'tm','title' => 'Thuyết Minh','image' => ''),
        '1' => array('key' => 'vi','title' => 'Tiếng Việt','image' => ''),
        '2' => array('key' => 'en','title' => 'Tiếng Anh','image' => '')
    );
}

// Lấy ngôn ngữ theo key
function movie_get_language($key){
    $tem = movie_get_language();
    return isset($tem[$key]) ? $tem[$key] : false;
}


?>
