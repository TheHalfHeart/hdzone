<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_edit extends CI_Controller 
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
        if (!$this->auth->isAdmin()){
            die ($this->load->widget('cms/login_form'));
        }

        // Data
        $data = array();
        
        // Add Action
        if ($this->security->is_action('user_edit'))
        {
            $user_id = $this->input->post('user_id');
            if (!$user_id){
                die ('101');
            }
            
            // Data Form
            $data = array(
                'user_password' => trim((string)$this->input->post('user_password')),
                'user_email'    => trim((string)$this->input->post('user_email')),
                'user_fullname' => trim((string)$this->input->post('user_fullname')),
                'user_phone'    => trim((string)$this->input->post('user_phone')),
                'user_address'  => trim((string)$this->input->post('user_address')),
                'user_website'  => trim((string)$this->input->post('user_website')),
                'user_facebook_url' => trim((string)$this->input->post('user_facebook_url')),
                'user_google_plus_url'  => trim((string)$this->input->post('user_google_plus_url')),
                'user_intro'    => trim((string)$this->input->post('user_intro')),
                'user_status'   => trim((string)$this->input->post('user_status')),
                'user_level'    => trim((string)$this->input->post('user_level'))
            );
            
            // More Info
            $data['user_email_int']     = email_hash($data['user_email']);
            $data['user_last_update_date_time'] = current_date_time_mysql();
            $data['user_last_update_date_int']  = current_date_to_int();
            $data['user_last_update_date_time_int'] = current_date_time_to_int();
            $data['user_last_update_user_username'] = $this->auth->getItem('user_username');
            $data['user_last_update_user_id']   = $this->auth->getItem('user_id');
            $data['user_last_update_user_username_int'] = username_hash($this->auth->getItem('user_username'));
            if (empty($data['user_password'])){
                unset($data['user_password']);
            }
            
            // Load lib
            $this->load->model('cms/cms_user_model');
            
            // Get Need Update User
            $user_update = $this->cms_user_model->getDetail(array(
                'select' => 'user_username,user_level,user_id,user_is_root,user_add_date_int',
                'user_id' => $user_id
            ));
            
            if (!$user_update){
                die ('101');
            }
            
            if (!can_edit_user($user_update['user_id'], $user_update['user_level'], $user_update['user_is_root'])){
                die ('101');
            }
            
            if ($user_update['user_is_root'] || $user_update['user_id'] == $this->auth->getItem('user_id')){
                unset($data['user_status']);
                unset($data['user_level']);
            }
            
            $check = $this->cms_user_model->edit($data, $user_id);
            
            if (!is_array($check)){
                if ($check){
                    // Avatar
                    $this->load->library('avatar');
                    $upload = $this->avatar->upload($user_update['user_username'], $user_update['user_add_date_int'], 'user_avatar');
                    if (is_array($upload)){
                        $mes = 'Cập nhật thành công nhưng Avatar thất bại. ';
                        foreach ($upload as $val){
                            $mes .= ' '.$val.',';
                        }
                        $this->message->setMessage(trim($mes, ','));
                    }
                    
                    die ('100');
                }
                else{
                    die ('101');
                }
            }
            
            $this->message->setError($check);
            $this->message->setMessage('Vui lòng kiểm tra lại thông tin bên dưới');
        }
        
        // View Form
        $form = $this->load->widget('cms/user_edit', array($data));
        
        die ($form ? $form : $this->load->widget('cms/message', array('Trang bạn cần sửa không thấy')));
    }
}
?>
