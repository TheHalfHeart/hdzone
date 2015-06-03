<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lists extends CI_Controller 
{ 
	public function index()
	{
            // Note Ajax Request
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            // Check For Token
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Only Manager
            if (!$this->auth->isManager()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // View List
            die ($this->load->widget('page/lists'));
	}
}
?>
