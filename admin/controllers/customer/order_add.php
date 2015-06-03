<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_add extends CI_Controller 
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
        if ($this->security->is_action('order_add'))
        {
            // Data Form
            $data = array(
                'order_customer_username' => trim((string)$this->input->post('order_customer_username')),
                'order_title' => trim((string)$this->input->post('order_title')),
                'order_status' => trim((string)$this->input->post('order_status')),
                'order_email' => trim((string)$this->input->post('order_email')),
                'order_fullname' => trim((string)$this->input->post('order_fullname')),
                'order_note' => trim((string)$this->input->post('order_note')),
                'order_phone' => trim((string)$this->input->post('order_phone')),
                'order_address' => trim((string)$this->input->post('order_address'))
            );
            
            // More Info
            $data['order_customer_username_int'] = username_hash($data['order_customer_username']);
            $data['order_add_date_time'] = current_date_time_mysql();
            $data['order_add_date_int'] = current_date_to_int();
            $data['order_add_date_time_int'] = current_date_time_to_int();
            $data['order_add_user_username'] = $this->auth->getItem('user_username');
            $data['order_add_user_id'] = $this->auth->getItem('user_id');
            $data['order_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['order_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
            $data['order_price'] = '0'; 
            // Add
            $this->load->model('customer/customer_order_model');

            $check = $this->customer_order_model->add($data);

            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');

        }
        
        // View Form
        die ($this->load->widget('customer/order_add', array($data)));
    }
}
?>
