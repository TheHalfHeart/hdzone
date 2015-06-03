<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_add extends CI_Controller 
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

        // Only Admin
        if (!$this->auth->isAdmin()){
            die ($this->load->widget('cms/login_form'));
        }

        // Data
        $data = array();

        // Add Action
        if ($this->security->is_action('user_add'))
        {
            // Data Form
            $data = array(
                'user_username' => trim((string)$this->input->post('user_username')),
                'user_password' => trim((string)$this->input->post('user_password')),
                'user_email'    => trim((string)$this->input->post('user_email')),
                'user_fullname' => trim((string)$this->input->post('user_fullname')),
                'user_phone'    => trim((string)$this->input->post('user_phone')),
                'user_address'  => trim((string)$this->input->post('user_address')),
                'user_website'  => trim((string)$this->input->post('user_website')),
                'user_facebook_url' => trim((string)$this->input->post('user_facebook_url')),
                'user_google_plus_url'  => trim((string)$this->input->post('user_google_plus_url')),
                'user_intro'    => trim((string)$this->input->post('user_intro')),
                'user_status'   => trim((string)$this->input->post('user_status')),
                'user_level'    => trim((string)$this->input->post('user_level'))
            );
            
            // More Info
            $data['user_username_int']  = username_hash($data['user_username']);
            $data['user_email_int']     = email_hash($data['user_email']);
            $data['user_add_date_time'] = current_date_time_mysql();
            $data['user_add_date_int']  = current_date_to_int();
            $data['user_add_date_time_int'] = current_date_time_to_int();
            $data['user_add_user_username'] = $this->auth->getItem('user_username');
            $data['user_add_user_id']   = $this->auth->getItem('user_id');
            $data['user_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['user_is_root']      = '0';
            
            // Check Auth
            if ($data['user_level'] == '10' && !$this->auth->isRoot()) {
                die('101');
            }
            
            // Add
            $this->load->model('cms/cms_user_model');

            $check = $this->cms_user_model->add($data);
            
            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
        }
        
        // View Form
        die ($this->load->widget('cms/user_add', array($data)));
    }
}
?>
