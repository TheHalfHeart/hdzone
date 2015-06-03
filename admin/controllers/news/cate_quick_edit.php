<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cate_quick_edit extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('ERROR_TOKEN');
            }
            
            // Admin And Editor
            if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
                die ('ERROR_AUTH');
            }
            
            $data = array();
            
            if ($this->security->is_action('cate_quick_edit'))
            {
                $field = $this->input->post('field');
                $value = $this->input->post('value');
                $cate_id = $this->input->post('id');
                
                $this->load->model('news/news_cate_model');
                
                if ($this->news_cate_model->quick_edit($field, $value, $cate_id)){
                    die ('SUCCESS');
                }
            }
            die ('ERROR_BAD_REQUEST');
	}
}
?>
