<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Director_editting extends CI_Controller 
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
            
            $director_id = $this->input->get('director_id');
            if ($director_id){
                $this->load->model('product/product_director_model');
                $this->product_director_model->updateEditting($director_id);
            }
	}
}
?>
