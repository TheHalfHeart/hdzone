<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher_editting extends CI_Controller 
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
            
            $voucher_id = $this->input->get('voucher_id');
            if ($voucher_id){
                $this->load->model('customer/customer_voucher_model');
                $this->customer_voucher_model->updateEditting($voucher_id);
            }
	}
}
?>
