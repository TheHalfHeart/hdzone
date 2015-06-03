<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher_delete extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101'); // NOT FOUND
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('101'); // NOT FOUND
            }
            
            if ($this->security->is_action('voucher_delete'))
            {
                $list_id = (int)$this->input->post('list_id');
                
                if ($list_id)
                {
                    $this->load->model('customer/customer_voucher_model');
                    
                    $token = $this->customer_voucher_model->delete($list_id);
                    
                    if ($token === 2){
                        die ('102'); // Post Exists
                    }
                    else if ($token){
                        die ('100'); // Success
                    }
                }
            }
            
            die ('101'); // NOT FOUND
	}
}
?>
