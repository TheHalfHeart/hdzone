<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Editting extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            if (!$this->auth->isEditor() && !$this->auth->isAdmin()){
                die ('101');
            }
            
            $contact_id = $this->input->get('contact_id');
            if ($contact_id){
                $this->load->model('contact/contact_contact_model');
                $this->contact_contact_model->updateEditting($contact_id);
            }
	}
}
?>
