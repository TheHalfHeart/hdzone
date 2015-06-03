<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_editting extends CI_Controller 
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
            
            $post_id = $this->input->get('post_id');
            if ($post_id){
                $this->load->model('news/news_post_model');
                $this->news_post_model->updateEditting($post_id);
            }
	}
}
?>
