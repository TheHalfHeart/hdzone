<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Actor_edit extends CI_Controller 
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
            
            if ($this->security->is_action('actor_edit'))
            {
                $actor_id = (int)$this->input->post('actor_id');
                if (!$actor_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'actor_sort'             => trim((string)(int)$this->input->post('actor_sort')),
                    'actor_type'             => trim((string)(int)$this->input->post('actor_type')),
                    'actor_icon'             => trim((string)$this->input->post('actor_icon')),
                    'actor_sex'             => trim((string)(int)$this->input->post('actor_sex')),
                    'actor_birthday'             => trim((string)$this->input->post('actor_birthday')),
                    'actor_seo_robots'       => trim((string)$this->input->post('actor_seo_robots')),
                    'actor_seo_last_visit'   => trim((string)$this->input->post('actor_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'actor_title');
                lang_generator_field($data, 'actor_title_short');
                lang_generator_field($data, 'actor_slug');
                lang_generator_field($data, 'actor_seo_title');
                lang_generator_field($data, 'actor_award');
                lang_generator_field($data, 'actor_note');
                lang_generator_field($data, 'actor_history');
                lang_generator_field($data, 'actor_country');
                lang_generator_field($data, 'actor_seo_keywords');
                lang_generator_field($data, 'actor_seo_description');
                lang_generator_field($data, 'actor_seo_main_keyword');
                lang_to_slug_int($data, 'actor_slug', 'actor_slug_int');
                
                // More Info
                $data['actor_last_update_date_time'] = current_date_time_mysql();
                $data['actor_last_update_date_int'] = current_date_to_int();
                $data['actor_last_update_date_time_int'] = current_date_time_to_int();
                $data['actor_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['actor_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['actor_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['actor_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('product/product_actor_model');
                
                $check = $this->product_actor_model->edit($data, $actor_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('product/actor_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
