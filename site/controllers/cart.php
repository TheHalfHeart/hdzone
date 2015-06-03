<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cart extends CI_Controller {

    function index($slug = '')
    {
        $this->lang->check('vi');
        
        $this->lang->load('site', LANG);
        
        $metas = array(
            'title'         => 'Giỏ Hàng'
        );
        
        $this->load->view('cart', array(
            'metas' => $metas
        )); 
    }

}