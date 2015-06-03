<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type_quick_edit extends CI_Controller 
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
            
            if ($this->security->is_action('type_quick_edit'))
            {
                $field = $this->input->post('field');
                $value = $this->input->post('value');
                $type_id = $this->input->post('id');
                
                $this->load->model('product/product_type_model');
                
                if ($this->product_type_model->quick_edit($field, $value, $type_id)){
                    die ('SUCCESS');
                }
            }
            die ('ERROR_BAD_REQUEST');
	}
}
?>
