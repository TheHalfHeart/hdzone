<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_lists extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Manager
            if (!$this->auth->isManager()){
                die ($this->load->widget('cms/login_form'));
            }
            
            die ($this->load->widget('news/post_lists'));
	}
}
?>
