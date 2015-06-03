<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Actor_editting extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('101');
            }
            
            $actor_id = $this->input->get('actor_id');
            if ($actor_id){
                $this->load->model('product/product_actor_model');
                $this->product_actor_model->updateEditting($actor_id);
            }
	}
}
?>
