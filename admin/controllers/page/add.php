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
            die ($this->load->widget('cms/login_form'));
        }

        // Only Manager
        if (!$this->auth->isManager()){
            die ($this->load->widget('cms/login_form'));
        }

        // Data
        $data = array();

        // Add Action
        if ($this->security->is_action('page_add'))
        {
            // Data Form
            $data = array(
                'page_template'         => trim((string)$this->input->post('page_template'))
            );
            
            // General Field Lang
            lang_generator_field($data, 'page_title');
            lang_generator_field($data, 'page_slug');
            lang_generator_field($data, 'page_summary');
            lang_first_char_ascii($data, 'page_title', 'page_title_first_char_ascii');
            lang_to_slug_int($data, 'page_slug', 'page_slug_int');
            lang_clear_unicode($data, 'page_title', 'page_title_clear_utf8');
            
            // Timer
            $data['page_timer_date_time_int']   = timer_private();
            $data['page_timer_date_int']        = timer_private();

            // More Info
            $data['page_add_date_time'] = current_date_time_mysql();
            $data['page_add_date_int'] = current_date_to_int();
            $data['page_add_date_time_int'] = current_date_time_to_int();
            $data['page_add_user_username'] = $this->auth->getItem('user_username');
            $data['page_add_user_id'] = $this->auth->getItem('user_id');
            $data['page_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['page_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
            $data['page_can_edit'] = '1';

            // Add
            $this->load->model('page/page_page_model');

            $check = $this->page_page_model->add($data);

            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');

        }
        
        // View Form
        die ($this->load->widget('page/add', array($data)));
    }
}
?>
