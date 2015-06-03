<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends CI_Controller {

    function index($slug_post = '', $id = '')
    { 
        $this->lang->check('vi');
        
        $this->lang->load('site', LANG);
        
        $this->load->model('product/product_post_model');
        $this->load->model('product/product_cate_model');
        $this->load->model('product/product_tags_model');
        
        $post = $this->product_post_model->getDetail(array(
            'select' => '*',
            'post_id' => (int)$id
        ));
        
        if (!$post){
            redirect_404();
        }
        
        $current_cate = $this->product_cate_model->getDetail(array(
            'cate_id' => $post['post_ref_cate_id']
        ));
        
        if (!$current_cate){
            redirect_404();
        }
        
        $cate_parent = array();
        if (isset($current_cate['cate_ref_parent_id'])){
            $cate_parent = $this->product_cate_model->getDetail(array(
                'cate_id' => $current_cate['cate_ref_parent_id']
            ));
        }
        
        $this->product_post_model->setWhere(array(
            'id_related' => $post['post_id'],
            'post_ref_cate_id' => $post['post_ref_cate_id']
        ));
        
        $related = $this->product_post_model->getList(array(
            'limit' => '20',
            'start' => '0'
        ));
        
        $tags = array();
        
        if ($post['post_ref_tags_id']){
            foreach (explode(' ', trim($post['post_ref_tags_id'])) as $id){
                $tmp = $this->product_tags_model->getDetail(array(
                    'tags_id' => $id
                ));
                if ($tmp){
                    $tags[] = $tmp;
                }
            }
        }
        
        $metas = array(
            'title' => ($post['post_seo_title'._LANG]) ? $post['post_seo_title'._LANG] : $post['post_title'._LANG],
            'keywords' => $post['post_seo_keywords'._LANG],
            'robots'    => $post['post_seo_robots'],
            'revisit-after'    => $post['post_seo_last_visit'],
            'description' => $post['post_seo_keywords'._LANG],
            'image'     => $post['post_image'],
            'page_url'     => $this->config->base_url('web-shop/'.$post['post_slug'._LANG].'-'.$post['post_id'].'.html'),
            'page_type' => 'article',
            'section'   => $post['post_ref_cate_title_short'._LANG],
            'published_time_int' => $post['post_timer_date_time_int'],
            'modified_time_int' => $post['post_last_update_date_time_int']
        );
        
        $this->load->view('product/detail', array(
            'metas' => $metas,
            'tags' => $tags,
            'related' => $related,
            'cate' => $current_cate,
            'cate_parent' => $cate_parent,
            'post' => $post
        ));
    }

}
?>
