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

        // Only Admin And Editor
        if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
            die ($this->load->widget('cms/login_form'));
        }

        // Data
        $data = array();

        // Add Action
        if ($this->security->is_action('slide_add'))
        {
            // Data Form
            $data = array(
                'slide_position'        => trim((string)$this->input->post('slide_position'))
            );
            
            // General Field Lang
            lang_generator_field($data, 'slide_title');
            lang_generator_field($data, 'slide_link');
            lang_generator_field($data, 'slide_content');
            
            // Timer
            $data['slide_timer_date_time_int']   = timer_private();
            $data['slide_timer_date_int']        = timer_private();
            
            // More Info
            $data['slide_add_date_time']    = current_date_time_mysql();
            $data['slide_add_date_int']     = current_date_to_int();
            $data['slide_add_date_time_int']= current_date_time_to_int();
            $data['slide_add_user_username']= $this->auth->getItem('user_username');
            $data['slide_add_user_id']      = $this->auth->getItem('user_id');
            $data['slide_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['slide_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
            
            // Add
            $this->load->model('slide/slide_slide_model');
            
            $check = $this->slide_slide_model->add($data);

            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
        }
        
        // View Form
        die ($this->load->widget('slide/add', array($data)));
    }
}
?>
