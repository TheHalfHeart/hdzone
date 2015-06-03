<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manu_edit extends CI_Controller 
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
            
            if ($this->security->is_action('manu_edit'))
            {
                $manu_id = (int)$this->input->post('manu_id');
                if (!$manu_id){
                    die('102'); // Success
                }
                
                // Data Form
                $data = array(
                    'manu_sort'             => trim((string)(int)$this->input->post('manu_sort')),
                    'manu_type'             => trim((string)(int)$this->input->post('manu_type')),
                    'manu_icon'             => trim((string)$this->input->post('manu_icon')),
                    'manu_year'             => trim((string)$this->input->post('manu_year')),
                    'manu_seo_robots'       => trim((string)$this->input->post('manu_seo_robots')),
                    'manu_seo_last_visit'   => trim((string)$this->input->post('manu_seo_last_visit'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'manu_title');
                lang_generator_field($data, 'manu_title_short');
                lang_generator_field($data, 'manu_slug');
                lang_generator_field($data, 'manu_seo_title');
                lang_generator_field($data, 'manu_seo_keywords');
                lang_generator_field($data, 'manu_seo_description');
                lang_generator_field($data, 'manu_seo_main_keyword');
                lang_generator_field($data, 'manu_country');
                lang_generator_field($data, 'manu_description');
                lang_to_slug_int($data, 'manu_slug', 'manu_slug_int');
                
                // More Info
                $data['manu_last_update_date_time'] = current_date_time_mysql();
                $data['manu_last_update_date_int'] = current_date_to_int();
                $data['manu_last_update_date_time_int'] = current_date_time_to_int();
                $data['manu_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['manu_last_update_user_id']       = $this->auth->getItem('user_id');
                $data['manu_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['manu_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Update
                $this->load->model('product/product_manu_model');
                
                $check = $this->product_manu_model->edit($data, $manu_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            
            $form = $this->load->widget('product/manu_edit', array($data));
            
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
	}
}
?>
