<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_quick_edit extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                die ('ERROR_BAD_REQUEST');
            }
            
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN');
            }
            
            // Manager
            if (!$this->auth->isManager()){
                die ('ERROR_AUTH');
            }
            
            $data = array();
            
            if ($this->security->is_action('post_quick_edit'))
            {
                $post_id = (int)$this->input->post('id');
                if (!$post_id){
                    die ('ERROR');
                }
                
                // Add
                $this->load->model('news/news_post_model');
                
                if (!$current_post = $this->news_post_model->canEditPost($post_id)){
                    die ('ERROR');
                }
                
                $field = $this->input->post('field');
                $value = $this->input->post('value');
                
                $this->load->model('news/news_post_model');
                
                if ($this->news_post_model->quick_edit($field, $value, $post_id)){
                    die ('SUCCESS');
                }
            }
            die ('ERROR_BAD_REQUEST');
	}
}
?>
