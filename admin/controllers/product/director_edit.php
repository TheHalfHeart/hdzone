<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Director_edit extends CI_Controller 
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
            
            if ($this->security->is_action('director_edit'))
            {
                $director_id = (int)$this->input->post('director_id');
                if (!$director_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'director_sort'             => trim((string)(int)$this->input->post('director_sort')),
                    'director_type'             => trim((string)(int)$this->input->post('director_type')),
                    'director_icon'             => trim((string)$this->input->post('director_icon')),
                    'director_sex'             => trim((string)(int)$this->input->post('director_sex')),
                    'director_birthday'             => trim((string)$this->input->post('director_birthday')),
                    'director_seo_robots'       => trim((string)$this->input->post('director_seo_robots')),
                    'director_seo_last_visit'   => trim((string)$this->input->post('director_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'director_title');
                lang_generator_field($data, 'director_title_short');
                lang_generator_field($data, 'director_slug');
                lang_generator_field($data, 'director_seo_title');
                lang_generator_field($data, 'director_award');
                lang_generator_field($data, 'director_note');
                lang_generator_field($data, 'director_history');
                lang_generator_field($data, 'director_country');
                lang_generator_field($data, 'director_seo_keywords');
                lang_generator_field($data, 'director_seo_description');
                lang_generator_field($data, 'director_seo_main_keyword');
                lang_to_slug_int($data, 'director_slug', 'director_slug_int');
                
                // More Info
                $data['director_last_update_date_time'] = current_date_time_mysql();
                $data['director_last_update_date_int'] = current_date_to_int();
                $data['director_last_update_date_time_int'] = current_date_time_to_int();
                $data['director_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['director_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['director_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['director_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('product/product_director_model');
                
                $check = $this->product_director_model->edit($data, $director_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('product/director_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
