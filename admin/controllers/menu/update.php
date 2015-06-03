<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Update extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101'); // NOT FOUND
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('101'); // NOT FOUND
            }
            
            if ($this->security->is_action('menu_update'))
            {
                $menu_id = $this->input->post('menu_id');
                
                if ($menu_id)
                {
                    $data = array(
                        'menu_class'    => $this->input->post('menu_class'),
                        'menu_sort'     => $this->input->post('menu_sort'),
                        'menu_ref_parent_id' => $this->input->post('menu_ref_parent_id'),
                        'menu_target'   => $this->input->post('menu_target')
                    );
                    
                    lang_generator_field($data, 'menu_title');
                    lang_generator_field($data, 'menu_link');
                    
                    $this->load->model('menu/menu_menu_model');
                    
                    if ($this->menu_menu_model->update($data, $menu_id)){
                        die ('100'); // SUCCESS
                    }
                }
            }
            die ('101'); // NOT FOUND
	}
}
?>
