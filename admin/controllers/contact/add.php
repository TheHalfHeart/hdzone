<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Add extends CI_Controller 
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

        // Add Action
        if ($this->security->is_action('contact_add'))
        {
            // Data Form
            $data = array(
                'contact_title'         => trim((string)$this->input->post('contact_title')),
                'contact_fullname'      => trim((string)$this->input->post('contact_fullname')),
                'contact_address'       => trim((string)$this->input->post('contact_address')),
                'contact_email'         => trim((string)$this->input->post('contact_email')),
                'contact_phone'         => trim((string)$this->input->post('contact_phone')),
                'contact_content'       => trim((string)$this->input->post('contact_content'))
            );
            
            // More Info
            $data['contact_title_clear_utf8']       = clear_unicode(($data['contact_title']));
            $data['contact_add_date_time']          = current_date_time_mysql();
            $data['contact_add_date_int']           = current_date_to_int();
            $data['contact_add_date_time_int']      = current_date_time_to_int();
            $data['contact_add_user_username']      = $this->auth->getItem('user_username');
            $data['contact_add_user_id']            = $this->auth->getItem('user_id');
            $data['contact_add_user_username_int']  = username_hash($this->auth->getItem('user_username'));
            $data['contact_add_user_add_date_int']  = $this->auth->getItem('user_add_date_int');
            $data['contact_status']                 = '0';
            $data['contact_answer']                 = '0';

            // Add
            $this->load->model('contact/contact_contact_model');

            $check = $this->contact_contact_model->add($data);

            if (!is_array($check)){
                die($check ? 'ERROR_SUCCESS': 'ERROR_UNSUCCESS'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');

        }
        
        // View Form
        die ($this->load->widget('contact/add', array($data)));
    }
}
?>
