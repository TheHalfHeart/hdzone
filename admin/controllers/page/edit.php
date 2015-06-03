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
                die ($this->load->widget('cms/login_form'));
            }
            
            // Only Manager
            if (!$this->auth->isManager()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Data
            $data = array();
            
            // Edit Action
            if ($this->security->is_action('page_edit'))
            {
                // Id
                $page_id = (int)$this->input->post('page_id');
                if (!$page_id){
                    die('101'); // Success
                }
                
                // Can Edit Post
                $this->load->model('page/page_page_model');
                if (!$this->page_page_model->canEditPage($page_id)){
                    die ('101'); // Permission
                }
                
                // Data Form
                $data = array(
                    'page_template'         => trim((string)$this->input->post('page_template')),
                    'page_image'     => trim((string)$this->input->post('page_image')),
                    'page_seo_robots'       => trim((string)$this->input->post('page_seo_robots')),
                    'page_seo_last_visit'   => trim((string)$this->input->post('page_seo_last_visit'))
                );
                
                // Timer
                if ($this->auth->isContributor()){
                    $data['page_timer_date_time_int'] = timer_private();
                }
                else {
                    $timer = $this->input->post('page_timer');
                    if ($timer == '0'){
                        $data['page_timer_date_time_int']   = timer_private();
                        $data['page_timer_date_int']        = timer_private();
                    }
                    else if ($timer == '1'){
                        $data['page_timer_date_time_int']   = current_date_time_to_int();
                        $data['page_timer_date_int']        = current_date_to_int();
                        $data['page_timer_date_time']       = current_date_time_mysql();
                    }
                    else{
                        $data['page_timer_date_time_int'] = (int)strtotime($timer);
                        $data['page_timer_date_int'] = (int)strtotime(date('Y-m-d', $data['page_timer_date_time_int']));
                        $data['page_timer_date_time'] = date('Y-m-d H:i:s', $data['page_timer_date_time_int']);
                    }
                }
                
                // General Field Lang
                lang_generator_field($data, 'page_title');
                lang_generator_field($data, 'page_slug');
                lang_generator_field($data, 'page_summary');
                lang_generator_field($data, 'page_content');
                lang_generator_field($data, 'page_seo_title');
                lang_generator_field($data, 'page_seo_keywords');
                lang_generator_field($data, 'page_seo_description');
                lang_generator_field($data, 'page_seo_main_keyword');
                lang_first_char_ascii($data, 'page_title', 'page_title_first_char_ascii');
                lang_to_slug_int($data, 'page_slug', 'page_slug_int');
                lang_clear_unicode($data, 'page_title', 'page_title_clear_utf8');
                
                // More Info
                $data['page_last_update_date_time'] = current_date_time_mysql();
                $data['page_last_update_date_int'] = current_date_to_int();
                $data['page_last_update_date_time_int'] = current_date_time_to_int();
                $data['page_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['page_last_update_user_id'] = $this->auth->getItem('user_id');
                $data['page_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['page_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                $data['page_can_edit'] = '1';
                
                // Add
                $check = $this->page_page_model->edit($data, $page_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
            }
            
            // View Form
            $form = $this->load->widget('page/edit', array($data));
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
