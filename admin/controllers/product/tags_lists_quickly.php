<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_lists_quickly extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('101');
            }
            
            // Manager
            if (!$this->auth->isManager()){
                die ('101');
            }
            
            $this->load->model('product/product_tags_model');
            
            $tags = $this->product_tags_model->getList();
            
            foreach ($tags as $item){
                echo '<div idval="'.$item['tags_id'].'">'.$item[lang_field('tags_title')].'</div>';
            }
	}
}
?>
