<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common_footer_widget extends MY_Widget {

    function index()
    {
        $this->load->model('slide/slide_slide_model');
        
        $this->load->view('view', array(
            'menu_1' => $this->menu_menu_model->getList(2),
            'menu_2' => $this->menu_menu_model->getList(3),
            'menu_3' => $this->menu_menu_model->getList(4)
        ));
    }

}