<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete extends CI_Controller 
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
            
            if ($this->security->is_action('menu_delete'))
            {
                $menu_id = $this->input->post('menu_id');
                
                if ($menu_id)
                {
                    $this->load->model('menu/menu_menu_model');
                    
                    if ($this->menu_menu_model->delete($menu_id)){
                        die ('100'); // SUCCESS
                    }
                }
            }
            die ('101'); // NOT FOUND
	}
}
?>
