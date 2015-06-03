<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Device_add extends CI_Controller 
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
            
            if ($this->security->is_action('device_add'))
            {
                // Data Form
                $data = array(
                    'device_title'            => trim((string)$this->input->post('device_title')),
                    'device_address'             => trim((string)$this->input->post('device_address')),
                    'device_status'             => trim((string)(int)$this->input->post('device_status')),
                    'device_order'             => trim((string)(int)$this->input->post('device_order')),
                    'device_description'      => trim((string)$this->input->post('device_description'))
                );
                
                // More Info
                $data['device_add_date_time'] = current_date_time_mysql();
                $data['device_add_date_int'] = current_date_to_int();
                $data['device_add_date_time_int'] = current_date_time_to_int();
                $data['device_add_user_username'] = $this->auth->getItem('user_username');
                $data['device_add_user_id']       = $this->auth->getItem('user_id');
                $data['device_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['device_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('cms/cms_device_model');
                
                $check = $this->cms_device_model->add($data);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            die ($this->load->widget('cms/device_add', array($data)));
	}
}
?>
