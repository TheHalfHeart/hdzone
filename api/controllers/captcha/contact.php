<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller 
{
    function index() 
    {
        $this->load->library('captcha');
        $code = $this->captcha->get_and_show_image();
        $this->session->set_userdata('code_captcha_contact', $code);
    }
    
    function test(){
        echo $this->session->userdata('code_captcha_contact');
    }
}