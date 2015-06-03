<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_edit extends CI_Controller 
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
            if (!$this->auth->isManager()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Data
            $data = array();
            
            // Edit Action
            if ($this->security->is_action('customer_edit'))
            {
                // Id
                $customer_id = (int)$this->input->post('customer_id');
                if (!$customer_id){
                    die('101'); // Success
                }
                
                // Data Form
                $data = array(
                    'customer_fullname' => trim((string)$this->input->post('customer_fullname')),
                    'customer_password' => trim((string)$this->input->post('customer_password')),
                    'customer_group' => trim((string)$this->input->post('customer_group')),
                    'customer_birthday' => trim((string)$this->input->post('customer_birthday')),
                    'customer_status' => trim((string)$this->input->post('customer_status')),
                    'customer_email' => trim((string)$this->input->post('customer_email')),
                    'customer_phone' => trim((string)$this->input->post('customer_phone')),
                    'customer_address' => trim((string)$this->input->post('customer_address'))
                );
                
                if (empty($data['customer_password'])){
                    unset($data['customer_password']);
                }
                else {
                    $data['customer_password'] = password_hash($data['customer_password']);
                }
                
                // More Info
                if ($data['customer_birthday']){
                    $data['customer_birthday_int'] = strtotime($data['customer_birthday']);
                }
                
                if ($data['customer_email']){
                    $data['customer_email_int'] = email_hash($data['customer_email']);
                }
                
                // More Info
                $data['customer_last_update_date_time'] = current_date_time_mysql();
                $data['customer_last_update_date_int'] = current_date_to_int();
                $data['customer_last_update_date_time_int'] = current_date_time_to_int();
                $data['customer_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['customer_last_update_user_id'] = $this->auth->getItem('user_id');
                $data['customer_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['customer_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('customer/customer_customer_model');
                $check = $this->customer_customer_model->edit($data, $customer_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
            }
            
            // View Form
            $form = $this->load->widget('customer/customer_edit', array($data));
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
