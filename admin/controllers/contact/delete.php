<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN'); // NOT FOUND
            }
            
            if (!$this->auth->isEditor() && !$this->auth->isAdmin()){
                die ('ERROR_AUTH'); // NOT FOUND
            }
            
            if ($this->security->is_action('contact_delete'))
            {
                $list_id = $this->input->post('list_id');
                if ($list_id)
                {
                    $this->load->model('contact/contact_contact_model');
                    
                    $check = $this->contact_contact_model->delete($list_id);
                    die (($check === 2) ? 'ERROR_MAX' : 'ERROR_SUCCESS'); // Max Or Success
                }
            }
            die ('ERROR_ERROR'); // NOT FOUND
	}
}
?>
