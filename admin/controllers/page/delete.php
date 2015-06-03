<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101'); // NOT FOUND
            }
            
            if (!$this->auth->isManager()){
                die ('101'); // NOT FOUND
            }
            
            if ($this->security->is_action('page_delete'))
            {
                $list_id = $this->input->post('list_id');
                if ($list_id)
                {
                    $this->load->model('page/page_page_model');
                    
                    $check = $this->page_page_model->delete($list_id);
                    die (($check === 2) ? '102' : '100'); // Max Or Success
                }
            }
            die ('101'); // NOT FOUND
	}
}
?>
