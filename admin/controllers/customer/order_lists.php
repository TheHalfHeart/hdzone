<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_lists extends CI_Controller 
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
            
            // Only Admin, Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // View List
            die ($this->load->widget('customer/order_lists'));
	}
}
?>
