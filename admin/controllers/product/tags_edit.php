<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_edit extends CI_Controller 
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
            
            if ($this->security->is_action('tags_edit'))
            {
                $tags_id = (int)$this->input->post('tags_id');
                if (!$tags_id){
                    die('100'); // Success
                }
                
                // Data Form
                $data = array(
                    'tags_seo_robots'       => trim((string)$this->input->post('tags_seo_robots')),
                    'tags_seo_last_visit'   => trim((string)$this->input->post('tags_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'tags_title');
                lang_generator_field($data, 'tags_title_short');
                lang_generator_field($data, 'tags_slug');
                lang_generator_field($data, 'tags_seo_title');
                lang_generator_field($data, 'tags_seo_keywords');
                lang_generator_field($data, 'tags_seo_description');
                lang_generator_field($data, 'tags_seo_main_keyword');
                lang_to_slug_int($data, 'tags_slug', 'tags_slug_int');
                
                // More Info
                $data['tags_last_update_date_time'] = current_date_time_mysql();
                $data['tags_last_update_date_int'] = current_date_to_int();
                $data['tags_last_update_date_time_int'] = current_date_time_to_int();
                $data['tags_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['tags_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['tags_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['tags_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('product/product_tags_model');
                
                $check = $this->product_tags_model->edit($data, $tags_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('product/tags_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Tags bạn cần sửa không thấy')));
	}
}
?>
