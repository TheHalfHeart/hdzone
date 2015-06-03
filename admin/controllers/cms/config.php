<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config extends CI_Controller 
{ 
	public function index()
	{
            // Not Request Ajax
            if (!$this->input->is_ajax_request()){
                show_404();
            }

            // Check For Token
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }

            // Only Manager
            if (!$this->auth->isAdmin()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // View Form
            die ($this->load->widget('cms/config'));
	}
}
?>
