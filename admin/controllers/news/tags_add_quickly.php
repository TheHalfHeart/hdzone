<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_add_quickly extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            // Manager
            if (!$this->auth->isManager()){
                die ('101');
            }
            
            $title = trim((string)$this->input->get('tags_title'));
            
            if ($title)
            {
                // Data from form
                $data = array(
                    'tags_title_short' => $title,
                    'tags_title' => $title
                );
                
                // More Info
                $data['tags_slug']          = to_slug($title);
                $data['tags_slug_int']      = to_slug_int($data['tags_slug']);
                $data['tags_total_post']    = '0';
                $data['tags_add_date_time'] = current_date_time_mysql();
                $data['tags_add_date_int']  = current_date_to_int();
                $data['tags_add_date_time_int'] = current_date_time_to_int();
                $data['tags_add_user_username'] = $this->auth->getItem('user_username');
                $data['tags_add_user_id']   = $this->auth->getItem('user_id');
                $data['tags_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['tags_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                $this->load->model('news/news_tags_model');
                
                $check = $this->news_tags_model->add($data);
                if (!is_array($check) && $check){
                    die ((string)$check);
                }
            }
            
            
            die ('101');
	}
}
?>
