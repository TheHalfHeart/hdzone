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
            
            if (!$this->auth->isManager()){
                die ('101');
            }
            
            $page_id = $this->input->get('page_id');
            if ($page_id){
                $this->load->model('page/page_page_model');
                $this->page_page_model->updateEditting($page_id);
            }
	}
}
?>
