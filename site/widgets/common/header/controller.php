<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common_header_widget extends MY_Widget {

    function index($metas = array(), $cate_mau_web = array(), $cate_sanpham = array(), $current_cate = array(), $type = '', $message = '')
    {
        $this->load->model('menu/menu_menu_model');
        $this->load->view('view', array(
            'metas' => $metas,
            'cate_mau_web' => $cate_mau_web,
            'cate_sanpham' => $cate_sanpham,
            'message' => $message,
            'type' => $type,
            'current_cate' => $current_cate,
            'menu' => $this->menu_menu_model->getList(1)
        ));
    }

}