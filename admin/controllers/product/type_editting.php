<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type_editting extends CI_Controller 
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
            
            $type_id = $this->input->get('type_id');
            if ($type_id){
                $this->load->model('product/product_type_model');
                $this->product_type_model->updateEditting($type_id);
            }
	}
}
?>
