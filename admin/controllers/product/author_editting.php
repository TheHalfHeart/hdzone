<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Author_editting extends CI_Controller 
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
            
            $author_id = $this->input->get('actor_id');
            if ($author_id){
                $this->load->model('product/product_author_model');
                $this->product_author_model->updateEditting($author_id);
            }
	}
}
?>
