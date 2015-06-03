<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Showroom_edit extends CI_Controller 
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
            
            if ($this->security->is_action('showroom_edit'))
            {
                $showroom_id = (int)$this->input->post('showroom_id');
                if (!$showroom_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'showroom_title'            => trim((string)$this->input->post('showroom_title')),
                    'showroom_address'             => trim((string)$this->input->post('showroom_address')),
                    'showroom_status'             => trim((string)(int)$this->input->post('showroom_status')),
                    'showroom_order'             => trim((string)(int)$this->input->post('showroom_order')),
                    'showroom_description'      => trim((string)$this->input->post('showroom_description'))
                );
                
                // More Info
                $data['showroom_last_update_date_time'] = current_date_time_mysql();
                $data['showroom_last_update_date_int'] = current_date_to_int();
                $data['showroom_last_update_date_time_int'] = current_date_time_to_int();
                $data['showroom_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['showroom_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['showroom_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['showroom_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('cms/cms_showroom_model');
                
                $check = $this->cms_showroom_model->edit($data, $showroom_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('cms/showroom_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
