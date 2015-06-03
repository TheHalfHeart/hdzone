<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher_edit extends CI_Controller 
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
            
            if ($this->security->is_action('voucher_edit'))
            {
                $voucher_id = (int)$this->input->post('voucher_id');
                if (!$voucher_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'voucher_customer_id'   => trim((string)(int)$this->input->post('voucher_customer_id')),
                    'voucher_active_date_int'=> (int)strtotime(trim((string)$this->input->post('voucher_active_date'))),
                    'voucher_end_date_int'  => (int)strtotime(trim((string)$this->input->post('voucher_end_date'))),
                    'voucher_status'        => trim((string)(int)$this->input->post('voucher_status')),
                    'voucher_description'   => trim((string)$this->input->post('voucher_description'))
                );
                
                // More Info
                $data['voucher_last_update_date_time'] = current_date_time_mysql();
                $data['voucher_last_update_date_int'] = current_date_to_int();
                $data['voucher_last_update_date_time_int'] = current_date_time_to_int();
                $data['voucher_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['voucher_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['voucher_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['voucher_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('customer/customer_voucher_model');
                
                $check = $this->customer_voucher_model->edit($data, $voucher_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('customer/voucher_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
