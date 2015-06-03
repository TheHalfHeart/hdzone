<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher_add extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ($this->load->widget('cms/login_form'));
            }
            
            $data = array();
            
            if ($this->security->is_action('voucher_add'))
            {
                // Data Form
                $data = array(
                    'voucher_code'          => trim((string)$this->input->post('voucher_code')),
                    'voucher_price'         => trim((string)$this->input->post('voucher_price')),
                    'voucher_customer_id'   => trim((string)(int)$this->input->post('voucher_customer_id')),
                    'voucher_active_date_int'=> (int)strtotime(trim((string)$this->input->post('voucher_active_date'))),
                    'voucher_end_date_int'  => (int)strtotime(trim((string)$this->input->post('voucher_end_date'))),
                    'voucher_status'        => trim((string)(int)$this->input->post('voucher_status')),
                    'voucher_description'   => trim((string)$this->input->post('voucher_description'))
                );
                $data['voucher_price_current'] = $data['voucher_price'];
                // More Info
                $data['voucher_add_date_time'] = current_date_time_mysql();
                $data['voucher_add_date_int'] = current_date_to_int();
                $data['voucher_add_date_time_int'] = current_date_time_to_int();
                $data['voucher_add_user_username'] = $this->auth->getItem('user_username');
                $data['voucher_add_user_id']       = $this->auth->getItem('user_id');
                $data['voucher_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['voucher_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('customer/customer_voucher_model');
                
                $check = $this->customer_voucher_model->add($data);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            die ($this->load->widget('customer/voucher_add', array($data)));
	}
}
?>
