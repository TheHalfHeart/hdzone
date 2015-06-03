<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cate_edit extends CI_Controller 
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
            
            if ($this->security->is_action('cate_edit'))
            {
                $cate_id = (int)$this->input->post('cate_id');
                if (!$cate_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'cate_sort'             => trim((string)$this->input->post('cate_sort')),
                    'cate_ref_parent_id'             => trim((string)(int)$this->input->post('cate_ref_parent_id')),
                    'cate_seo_robots'       => trim((string)$this->input->post('cate_seo_robots')),
                    'cate_seo_last_visit'   => trim((string)$this->input->post('cate_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'cate_title');
                lang_generator_field($data, 'cate_title_short');
                lang_generator_field($data, 'cate_slug');
                lang_generator_field($data, 'cate_seo_title');
                lang_generator_field($data, 'cate_seo_keywords');
                lang_generator_field($data, 'cate_seo_description');
                lang_generator_field($data, 'cate_seo_main_keyword');
                lang_to_slug_int($data, 'cate_slug', 'cate_slug_int');
                
                // More Info
                $data['cate_last_update_date_time'] = current_date_time_mysql();
                $data['cate_last_update_date_int'] = current_date_to_int();
                $data['cate_last_update_date_time_int'] = current_date_time_to_int();
                $data['cate_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['cate_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['cate_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['cate_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('news/news_cate_model');
                
                $check = $this->news_cate_model->edit($data, $cate_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('news/cate_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
