<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_add extends CI_Controller {

    function index()
    {
        if ($this->security->is_action('action_contact_add'))
        {
            $captcha_init = $this->session->userdata('code_captcha_contact');
            
            if (!$captcha_init || $captcha_init != $this->input->post('contact_captcha')){
                die (json_encode(array(
                    'type' => 'Error',
                    'bad_captcha' => true
                )));
            }
            
            $data = array(
                'contact_title'     => $this->input->post('contact_title'),
                'contact_fullname'  => $this->input->post('contact_name'),
                'contact_address'   => $this->input->post('contact_address'),
                'contact_email'     => $this->input->post('contact_email'),
                'contact_phone'     => $this->input->post('contact_phone'),
                'contact_content'   => $this->input->post('contact_content'),
                'contact_add_date_int'      => current_date_to_int(),
                'contact_add_date_time_int' => current_date_time_to_int(),
                'contact_add_date_time'     => current_date_time_mysql()
            );
            
            $this->load->model('contact/contact_contact_model');
            
            if ($this->contact_contact_model->add($data)){
                die (json_encode(array(
                    'type' => 'Success'
                )));
            }
            
            die (json_encode(array(
                'type' => 'Error',
                'bad_data' => true
            )));
        }
        
        die (json_encode(array(
            'type' => 'Error',
            'bad_request' => true
        )));
    }

}