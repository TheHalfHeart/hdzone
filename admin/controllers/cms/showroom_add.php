<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Showroom_add extends CI_Controller 
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
            
            if ($this->security->is_action('showroom_add'))
            {
                // Data Form
                $data = array(
                    'showroom_title'            => trim((string)$this->input->post('showroom_title')),
                    'showroom_address'             => trim((string)$this->input->post('showroom_address')),
                    'showroom_status'             => trim((string)(int)$this->input->post('showroom_status')),
                    'showroom_order'             => trim((string)(int)$this->input->post('showroom_order')),
                    'showroom_description'      => trim((string)$this->input->post('showroom_description'))
                );
                
                // More Info
                $data['showroom_add_date_time'] = current_date_time_mysql();
                $data['showroom_add_date_int'] = current_date_to_int();
                $data['showroom_add_date_time_int'] = current_date_time_to_int();
                $data['showroom_add_user_username'] = $this->auth->getItem('user_username');
                $data['showroom_add_user_id']       = $this->auth->getItem('user_id');
                $data['showroom_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['showroom_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('cms/cms_showroom_model');
                
                $check = $this->cms_showroom_model->add($data);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            die ($this->load->widget('cms/showroom_add', array($data)));
	}
}
?>
