<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Edit extends CI_Controller 
{ 
	public function index()
	{
            // Not Request Ajax
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            // Check For Token
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN');
            }
            
            // Only Editor
            if (!$this->auth->isEditor() && !$this->auth->isAdmin()){
                die ('ERROR_AUTH');
            }
            
            // Data
            $data = array();
            
            // Edit Action
            if ($this->security->is_action('contact_edit'))
            {
                // Id
                $contact_id = (int)$this->input->post('contact_id');
                if (!$contact_id){
                    die('ERROR_UNSUCCESS'); // Unsuccess
                }
                
                // Can Edit Post
                $this->load->model('contact/contact_contact_model');
                
                // Data Form
                $data = array(
                    'contact_title'         => trim((string)$this->input->post('contact_title')),
                    'contact_fullname'      => trim((string)$this->input->post('contact_fullname')),
                    'contact_address'       => trim((string)$this->input->post('contact_address')),
                    'contact_email'         => trim((string)$this->input->post('contact_email')),
                    'contact_phone'         => trim((string)$this->input->post('contact_phone')),
                    'contact_status'        => trim((string)$this->input->post('contact_status')),
                    'contact_answer'        => trim((string)$this->input->post('contact_answer')),
                    'contact_content'       => trim((string)$this->input->post('contact_content'))
                );
                
                // More Info
                $data['contact_title_clear_utf8'] = clear_unicode(($data['contact_title']));
                $data['contact_last_update_date_time'] = current_date_time_mysql();
                $data['contact_last_update_date_int'] = current_date_to_int();
                $data['contact_last_update_date_time_int'] = current_date_time_to_int();
                $data['contact_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['contact_last_update_user_id'] = $this->auth->getItem('user_id');
                $data['contact_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['contact_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $check = $this->contact_contact_model->edit($data, $contact_id);
                
                if (!is_array($check)){
                    die($check ? 'ERROR_SUCCESS': 'ERROR_UNSUCCESS'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
            }
            
            // View Form
            $form = $this->load->widget('contact/edit', array($data));
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
