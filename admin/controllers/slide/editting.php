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
            
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('101');
            }
            
            $slide_id = $this->input->get('slide_id');
            if ($slide_id){
                $this->load->model('slide/slide_slide_model');
                $this->slide_slide_model->updateEditting($slide_id);
            }
	}
}
?>
