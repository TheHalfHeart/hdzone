<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_edit extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }
            
            // Manager
            if (!$this->auth->isManager()){
                die ($this->load->widget('cms/login_form'));
            }
            
            $data = array();
            
            if ($this->security->is_action('post_edit'))
            {
                
                $post_id = (int)$this->input->post('post_id');
                if (!$post_id){
                    die ('101');
                }
                
                // Add
                $this->load->model('news/news_post_model');
                
                if (!$current_post = $this->news_post_model->canEditPost($post_id)){
                    die ('101');
                }
                
                // Data Form
                $data = array(
                    'post_image'     => trim((string)$this->input->post('post_image')),
                    'post_seo_robots'       => trim((string)$this->input->post('post_seo_robots')),
                    'post_image_large'     => trim((string)$this->input->post('post_image_large')),
                    'post_seo_last_visit'   => trim((string)$this->input->post('post_seo_last_visit')),
                    'post_image_slide_small'     => trim((string)$this->input->post('post_image_slide_small')),
                    'post_image_slide_large'     => trim((string)$this->input->post('post_image_slide_large')),
                    'post_ref_tags_id'      => trim((string)$this->input->post('post_ref_tags_id')). ' ',
                    'post_ref_cate_id'      => trim((int)$this->input->post('post_ref_cate_id')),
                    'post_ref_related'      => trim((string)$this->input->post('post_ref_related'))
                );
                
                // Timer
                if ($this->auth->isContributor()){
                    $data['post_timer_date_time_int'] = '4000000000';
                }
                else{
                    $timer = $this->input->post('post_timer');
                    if ($timer == '0'){
                        $data['post_timer_date_time_int'] = '4000000000';
                        $data['post_timer_date_int'] = '4000000000';
                    }
                    else if ($timer == '1'){
                        $data['post_timer_date_time_int']   = current_date_time_to_int();
                        $data['post_timer_date_int'] = current_date_to_int();
                        $data['post_timer_date_time']       = current_date_time_mysql();
                    }
                    else{
                        $data['post_timer_date_time_int'] = (int)strtotime($timer);
                        $data['post_timer_date_int'] = (int)strtotime(date('Y-m-d', $data['post_timer_date_time_int']));
                        $data['post_timer_date_time'] = date('Y-m-d H:i:s', $data['post_timer_date_time_int']);
                    }
                }
                
                // General Field Lang
                lang_generator_field($data, 'post_title');
                lang_generator_field($data, 'post_slug');
                lang_generator_field($data, 'post_summary');
                lang_generator_field($data, 'post_content');
                lang_generator_field($data, 'post_seo_title');
                lang_generator_field($data, 'post_seo_keywords');
                lang_generator_field($data, 'post_seo_description');
                lang_generator_field($data, 'post_seo_main_keyword');
                lang_first_char_ascii($data, 'post_title', 'post_title_first_char_ascii');
                lang_clear_unicode($data, 'post_title', 'post_title_clear_utf8');
                
                // More Info
                $data['post_last_update_date_time'] = current_date_time_mysql();
                $data['post_last_update_date_int'] = current_date_to_int();
                $data['post_last_update_date_time_int'] = current_date_time_to_int();
                $data['post_last_update_user_username'] = $this->auth->getItem('user_username');
                $data['post_last_update_user_id'] = $this->auth->getItem('user_id');
                $data['post_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
                $data['post_last_update_user_add_date_int'] = $this->auth->getItem('user_add_date_int');
                $data['post_search_by_day']         = date('d');
                $data['post_search_by_month']       = date('m');
                $data['post_search_by_year']        = date('Y');
                $data['post_search_by_day_month']   = date('dm');
                $data['post_search_by_day_year']    = date('dY');
                $data['post_search_by_month_year']  = date('mY');
                $data['post_search_by_day_month_year'] = date('dmY');
                $check = $this->news_post_model->edit($data, $post_id, $current_post);
                
                if (!is_array($check)){
                    if ($check === 1){
                        die ('102'); // Cate Not Found
                    }
                    die ($check ? '100' : '101'); // Success Or Error
                }
                
                $this->message->setError($check);
                $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
                
            }
            $form = $this->load->widget('news/post_edit', array($data));
            die ($form ? $form : $this->load->widget('cms/message', array('Bài viết bạn chọn không tìm thấy')));
	}
}
?>
