<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_delete extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101'); // NOT FOUND
            }
            
            if (!$this->auth->isRoot()){
                die ('101'); // NOT FOUND
            }
            
            if ($this->security->is_action('user_delete'))
            {
                $list_id = $this->input->post('list_id');
                if ($list_id && $this->auth->getItem('user_id') != $list_id)
                {
                    $this->load->model('cms/cms_user_model');
                    
                    $check = $this->cms_user_model->delete($list_id);
                    
                    die (($check) ? '100' : '101');
                }
            }
            
            die ('101'); // NOT FOUND
	}
}
?>
