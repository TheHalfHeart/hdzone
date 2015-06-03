<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_add extends CI_Controller 
{ 
    public function index()
    {
        if (!$this->input->is_ajax_request()){
            show_404();
        }

        if (!$this->security->check_get_token()){
            die ($this->load->widget('cms/login_form'));
        }

        if (!$this->auth->isManager()){
            die ($this->load->widget('cms/login_form'));
        }

        $data = array();

        if ($this->security->is_action('post_add'))
        {
            // Data Form
            $data = array();
            
            // General Field Lang
            lang_generator_field($data, 'post_title');
            lang_generator_field($data, 'post_slug');
            lang_generator_field($data, 'post_summary');
            lang_first_char_ascii($data, 'post_title', 'post_title_first_char_ascii');
            lang_clear_unicode($data, 'post_title', 'post_title_clear_utf8');
            
            // Timer
            $data['post_timer_date_time_int']   = timer_private();
            $data['post_timer_date_int']        = timer_private();

            // More Info
            $data['post_view'] = '0';
            $data['post_add_date_time'] = current_date_time_mysql();
            $data['post_add_date_int'] = current_date_to_int();
            $data['post_add_date_time_int'] = current_date_time_to_int();
            $data['post_add_user_username'] = $this->auth->getItem('user_username');
            $data['post_add_user_id'] = $this->auth->getItem('user_id');
            $data['post_add_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            $data['post_add_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
            $data['post_search_by_day']         = date('d');
            $data['post_search_by_month']       = date('m');
            $data['post_search_by_year']        = date('Y');
            $data['post_search_by_day_month']   = date('dm');
            $data['post_search_by_day_year']    = date('dY');
            $data['post_search_by_month_year']  = date('mY');
            $data['post_search_by_day_month_year'] = date('dmY');

            // Add
            $this->load->model('news/news_post_model');

            $check = $this->news_post_model->add($data);

            if (!is_array($check)){
                die($check ? (string)$check: '101'); // Success | Error
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');

        }

        die ($this->load->widget('news/post_add', array($data)));
    }
}
?>
