<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cate_editting extends CI_Controller 
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
            
            $cate_id = $this->input->get('cate_id');
            if ($cate_id){
                $this->load->model('product/product_cate_model');
                $this->product_cate_model->updateEditting($cate_id);
            }
	}
}
?>
