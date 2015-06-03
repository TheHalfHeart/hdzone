<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_add extends CI_Controller 
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

        // Only Admin, Editor
        if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
            die ($this->load->widget('cms/login_form'));
        }

        // Data
        $data = array();

        // Add Action
        if ($this->security->is_action('customer_add'))
        {
            // Data Form
            $data = array(
                'customer_username' => trim((string)$this->input->post('customer_username')),
                'customer_password' => trim((string)$this->input->post('customer_password')),
                'customer_group'    => trim((string)$this->input->post('customer_group')),
                'customer_email'    => trim((string)$this->input->post('customer_email')),
                'customer_fullname' => trim((string)$this->input->post('customer_fullname')),
                'customer_birthday' => trim((string)$this->input->post('customer_birthday')),
                'customer_phone'    => trim((string)$this->input->post('customer_phone')),
                'customer_address'  => trim((string)$this->input->post('customer_address'))
            );
            
            // More Info
            if ($data['customer_birthday']){
                $data['customer_birthday_int'] = strtotime($data['customer_birthday']);
            }
            
            if ($data['customer_email']){
                $data['customer_email_int'] = email_hash($data['customer_email']);
            }
            
            $data['customer_username_int'] = username_hash($data['customer_username']);
            $data['customer_password'] = password_hash($data['customer_password']);
            $data['customer_add_date_time'] = current_date_time_mysql();
            $data['customer_add_date_int'] = current_date_to_int();
            $data['customer_add_date_time_int'] = current_date_time_to_int();
            $data['customer_add_user_username'] = $this->auth->getItem('user_username');
            $data['customer_add_user_id'] = $this->auth->getItem('user_id');
            $data['customer_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['customer_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
            $data['customer_status'] = '0';
            $data['customer_total_order'] = '0';
            
            // Add
            $this->load->model('customer/customer_customer_model');

            $check = $this->customer_customer_model->add($data);

            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');

        }
        
        // View Form
        die ($this->load->widget('customer/customer_add', array($data)));
    }
}
?>
