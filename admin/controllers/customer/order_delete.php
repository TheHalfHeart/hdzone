<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_delete extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101'); // NOT FOUND
            }
            
            if (!$this->auth->isManager()){
                die ('101'); // NOT FOUND
            }
            
            if ($this->security->is_action('order_delete'))
            {
                $list_id = $this->input->post('list_id');
                if ($list_id)
                {
                    $this->load->model('customer/customer_order_model');
                    
                    $check = $this->customer_order_model->delete($list_id);
                    if ($check === 0){
                        die ('100'); // Success
                    }
                    else {
                        die ('102'); // Max
                    }
                }
            }
            die ('101'); // NOT FOUND
	}
}
?>
