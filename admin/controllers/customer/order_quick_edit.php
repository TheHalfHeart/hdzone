<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_quick_edit extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN');
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('ERROR_AUTH');
            }
            
            $data = array();
            
            if ($this->security->is_action('order_quick_edit'))
            {
                $field = $this->input->post('field');
                $value = (int)$this->input->post('value');
                $order_id = (int)$this->input->post('id');
                
                if ($field == 'order_status' && ($value >=0) && ($value <= 4) && $order_id){
                    new_table('customer', 'order')->where('order_id', $order_id)->update(array(
                        'order_status' => $value
                    ));   
                    die ('ERROR_SUCCESS');
                }
            }
            die ('ERROR_BAD_REQUEST');
	}
}
?>
