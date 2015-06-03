<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quick_edit extends CI_Controller 
{ 
	public function index()
	{
            // Not Request Ajax
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            // Check For Token
            if (!$this->security->check_get_token()){
                die ('Bad_request');
            }
            
            // Only Manager
            if (!$this->auth->isEditor() && !$this->auth->isAdmin()){
                die ('Bad_request');
            }
            
            // Edit Action
            if ($this->security->is_action('contact_quick_edit'))
            {
                $id     = (int)$this->input->post('id');
                $field  = $this->input->post('field');
                $value  = $this->input->post('value');
                
                if ($id)
                {
                    $this->load->model('contact/contact_contact_model');
                    if ($this->contact_contact_model->quick_edit($id, $field, $value)){
                        die ('Success');
                    }
                }
            }
            
            die ('Bad_request');
	}
}
?>
