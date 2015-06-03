<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hdd_group_add extends CI_Controller 
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
            
            if ($this->security->is_action('hdd_group_add'))
            {
                // Data Form
                $data = array(
                    'hdd_group_title'            => trim((string)$this->input->post('hdd_group_title')),
                    'hdd_group_code'             => trim((string)$this->input->post('hdd_group_code')),
                    'hdd_group_size'             => trim((string)$this->input->post('hdd_group_size')),
                    'hdd_group_status'             => trim((string)(int)$this->input->post('hdd_group_status')),
                    'hdd_group_order'             => trim((string)(int)$this->input->post('hdd_group_order')),
                    'hdd_group_description'      => trim((string)$this->input->post('hdd_group_description'))
                );
                
                // More Info
                $data['hdd_group_add_date_time'] = current_date_time_mysql();
                $data['hdd_group_add_date_int'] = current_date_to_int();
                $data['hdd_group_add_date_time_int'] = current_date_time_to_int();
                $data['hdd_group_add_user_username'] = $this->auth->getItem('user_username');
                $data['hdd_group_add_user_id']       = $this->auth->getItem('user_id');
                $data['hdd_group_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['hdd_group_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('product/product_hdd_group_model');
                
                $check = $this->product_hdd_group_model->add($data);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            die ($this->load->widget('product/hdd_group_add', array($data)));
	}
}
?>
