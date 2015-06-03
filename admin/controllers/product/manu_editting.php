<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manu_editting extends CI_Controller 
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
            
            $manu_id = $this->input->get('manu_id');
            if ($manu_id){
                $this->load->model('product/product_manu_model');
                $this->product_manu_model->updateEditting($manu_id);
            }
	}
}
?>
