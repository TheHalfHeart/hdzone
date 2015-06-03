<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

    function index($slug = '', $page = '')
    {
        $this->lang->check('vi');
        
        $this->lang->load('site', LANG);
        
        $this->load->model('news/news_cate_model');
        
        $cate = $this->news_cate_model->getDetail(array(
            'cate_slug_int'._LANG => to_slug_int($slug)
        ));
        
        if (!$cate){
            redirect_404();
        }
        
        $this->load->model('news/news_post_model');
        
        $filter = array(
            'post_ref_cate_id' => $cate['cate_id']
        );
        
        $this->load->library('site/pagination');
        
        $this->news_post_model->setWhere($filter);
        
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->news_post_model->countList());
        $this->pagination->setLimit(12);
        $this->pagination->setLink($this->config->base_url('san-pham/'.$slug.'/page/{page}'));
        $this->pagination->setLinkFirst($this->config->base_url('san-pham/'.$slug));
        $this->pagination->setup();
        
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['order_by'] = 'post_timer_date_time_int';
        $filter['order_type'] = 'desc';
        
        $post = $this->news_post_model->getList($filter);
        
        $metas = array(
            'title' => ($cate['cate_seo_title'._LANG]) ? $cate['cate_seo_title'._LANG] : $cate['cate_title'._LANG],
            'keywords' => $cate['cate_seo_keywords'._LANG],
            'robots'    => $cate['cate_seo_robots'],
            'revisit-after'    => $cate['cate_seo_last_visit'],
            'description' => $cate['cate_seo_keywords'._LANG],
            'image'     => $this->wconfig->item('common','logo'),
            'page_url'     => $this->config->base_url('san-pham/'.$cate['cate_slug'._LANG]),
            'page_type' => 'object'
        );
        
        $this->load->view('news/category', array(
            'metas' => $metas,
            'cate' => $this->news_cate_model->getList(array(
                'cate_ref_parent_id' => $cate['cate_id']
            )),
            'current_cate' => $cate,
            'post'  => $post
        ));
    }

}
?>
