<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common_slider_widget extends MY_Widget {

    function index()
    {
        $this->load->model('slide/slide_slide_model');
        
        $this->load->view('view', array(
            'slide' => $this->slide_slide_model->getList(1)
        ));
    }

}