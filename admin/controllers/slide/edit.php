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
            
            // Only Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Data
            $data = array();
            
            // Edit Action
            if ($this->security->is_action('slide_edit'))
            {
                // Id
                $slide_id = (int)$this->input->post('slide_id');
                if (!$slide_id){
                    die('101'); // Success
                }
                
                // Data Form
                $data = array(
                    'slide_position'        => trim((string)$this->input->post('slide_position')),
                    'slide_image'    => trim((string)$this->input->post('slide_image'))
                );
                
                // General Field Lang
                lang_generator_field($data, 'slide_title');
                lang_generator_field($data, 'slide_link');
                lang_generator_field($data, 'slide_content');
                
                $timer = $this->input->post('slide_timer');
                if ($timer == '0'){
                    $data['slide_timer_date_time_int']   = timer_private();
                    $data['slide_timer_date_int']        = timer_private();
                }
                else if ($timer == '1'){
                    $data['slide_timer_date_time_int']   = current_date_time_to_int();
                    $data['slide_timer_date_int']        = current_date_to_int();
                    $data['slide_timer_date_time']       = current_date_time_mysql();
                }
                else{
                    $data['slide_timer_date_time_int'] = (int)strtotime($timer);
                    $data['slide_timer_date_int'] = (int)strtotime(date('Y-m-d', $data['slide_timer_date_time_int']));
                    $data['slide_timer_date_time'] = date('Y-m-d H:i:s', $data['slide_timer_date_time_int']);
                }
                
                // More Info
                $data['slide_last_update_date_time'] = current_date_time_mysql();
                $data['slide_last_update_date_int'] = current_date_to_int();
                $data['slide_last_update_date_time_int'] = current_date_time_to_int();
                $data['slide_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['slide_last_update_user_id'] = $this->auth->getItem('user_id');
                $data['slide_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['slide_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                
                // Add
                $this->load->model('slide/slide_slide_model');
                
                $check = $this->slide_slide_model->edit($data, $slide_id);
                
                if (!is_array($check)){
                    die($check ? '100': '101'); // Success | Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
            }
            
            // View Form
            $form = $this->load->widget('slide/edit', array($data));
            die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không tìm thấy')));
	}
}
?>
