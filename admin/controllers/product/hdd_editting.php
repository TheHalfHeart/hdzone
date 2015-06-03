<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hdd_editting extends CI_Controller 
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
            
            $hdd_id = $this->input->get('hdd_id');
            if ($hdd_id){
                $this->load->model('product/product_hdd_model');
                $this->product_hdd_model->updateEditting($hdd_id);
            }
	}
}
?>
