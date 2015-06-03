<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hdd_group_editting extends CI_Controller 
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
            
            $hdd_group_id = $this->input->get('hdd_group_id');
            if ($hdd_group_id){
                $this->load->model('product/product_hdd_group_model');
                $this->product_hdd_group_model->updateEditting($hdd_group_id);
            }
	}
}
?>
