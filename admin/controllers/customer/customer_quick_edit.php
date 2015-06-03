<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_quick_edit extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN');
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('ERROR_AUTH');
            }
            
            $data = array();
            
            if ($this->security->is_action('customer_quick_edit'))
            {
                $field = $this->input->post('field');
                $value = $this->input->post('value');
                $customer_id = $this->input->post('id');
                
                $this->load->model('customer/customer_customer_model');
                
                if ($this->customer_customer_model->quick_edit($field, $value, $customer_id)){
                    die ('SUCCESS');
                }
            }
            die ('ERROR_BAD_REQUEST');
	}
}
?>
