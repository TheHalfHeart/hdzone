<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_editting extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            if (!$this->auth->isAdmin()){
                die ('101');
            }
            
            $user_id = $this->input->get('user_id');
            if ($user_id){
                $this->load->model('cms/cms_user_model');
                $this->cms_user_model->updateEditting($user_id);
            }
	}
}
?>
