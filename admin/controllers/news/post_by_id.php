<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_by_id extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if (!$this->security->check_get_token()){
                die ('100');
            }
            
            if (!$this->auth->isManager()){
                die ('100');
            }
            
            $this->load->model('news/news_post_model');
            
            $post_id = (int)$this->input->get('post_id');
            if ($post_id){
                $post = $this->news_post_model->getDetail(array(
                    'select' => 'post_id,'.  lang_field('post_title'),
                    'post_id' => $post_id
                ));
                
                if ($post){
                    die ('<div idval="'.$post['post_id'].'" class="related">
                            <span class="namerelated">'.$post['post_title'].'</span>
                            <span class="removerelated">x</span>
                          </div>');
                }
            }
            
            die ('100');
	}
}
?>
