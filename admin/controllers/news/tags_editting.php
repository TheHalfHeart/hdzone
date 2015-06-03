<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_editting extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('101');
            }
            
            $tags_id = $this->input->get('tags_id');
            if ($tags_id){
                $this->load->model('news/news_tags_model');
                $this->news_tags_model->updateEditting($tags_id);
            }
	}
}
?>
