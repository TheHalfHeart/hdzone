<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Author_edit extends CI_Controller 
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
            
            if ($this->security->is_action('author_edit'))
            {
                $author_id = (int)$this->input->post('author_id');
                if (!$author_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'author_sort'             => trim((string)(int)$this->input->post('author_sort')),
                    'author_type'             => trim((string)(int)$this->input->post('author_type')),
                    'author_icon'             => trim((string)$this->input->post('author_icon')),
                    'author_seo_robots'       => trim((string)$this->input->post('author_seo_robots')),
                    'author_seo_last_visit'   => trim((string)$this->input->post('author_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'author_title');
                lang_generator_field($data, 'author_title_short');
                lang_generator_field($data, 'author_slug');
                lang_generator_field($data, 'author_seo_title');
                lang_generator_field($data, 'author_seo_keywords');
                lang_generator_field($data, 'author_seo_description');
                lang_generator_field($data, 'author_seo_main_keyword');
                lang_to_slug_int($data, 'author_slug', 'author_slug_int');
                
                // More Info
                $data['author_last_update_date_time'] = current_date_time_mysql();
                $data['author_last_update_date_int'] = current_date_to_int();
                $data['author_last_update_date_time_int'] = current_date_time_to_int();
                $data['author_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['author_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['author_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['author_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('product/product_author_model');
                
                $check = $this->product_author_model->edit($data, $author_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('product/author_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
