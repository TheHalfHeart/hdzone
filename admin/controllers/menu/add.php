<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Add extends CI_Controller 
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
            
            if ($this->security->is_action('menu_add'))
            {
                $data = array(
                    'menu_position' => trim((string)(int)$this->input->post('menu_position')),
                    'menu_class'    => trim($this->input->post('menu_class')),
                    'menu_ref_parent_id' => trim((string)(int)$this->input->post('menu_ref_parent_id')),
                    'menu_target'   => trim($this->input->post('menu_target')),
                    'menu_sort'     => trim($this->input->post('menu_sort'))
                );
                
                lang_generator_field($data, 'menu_title');
                lang_generator_field($data, 'menu_link');
                
                $this->load->model('menu/menu_menu_model');
                
                $token = $this->menu_menu_model->add($data);
                
                if (!is_array($token)){
                    die ('100'); // SUCCESS
                }
                
                $this->message->setError($token);
                $this->message->setMessage('Kiểm tra lại thông tin bị lỗi ở form bên dưới', false);
            }
            
            die ($this->load->widget('menu/add', array($data)));
	}
}
?>
