<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function index($page = 1)
    {
        $this->lang->check('vi');
        
        $this->lang->load('site', LANG);
        
        $this->load->model('product/product_post_model');
        $this->load->model('product/product_cate_model');
        
        $this->load->library('site/pagination');
        
        $filter = array(
            'select' => '*',
            'order_by' => 'post_timer_date_time_int',
            'order_type' => 'desc'
        );
        
        $this->product_post_model->setWhere($filter);
        
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_post_model->countList());
        $this->pagination->setLimit(12);
        $this->pagination->setLink($this->config->base_url('mau-web/page/{page}'));
        $this->pagination->setLinkFirst($this->config->base_url('mau-web'));
        $this->pagination->setup();
        
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['order_by'] = 'post_timer_date_time_int';
        $filter['order_type'] = 'desc';
        
        $post = $this->product_post_model->getList($filter);
        
        $metas = array(
            'title' => $this->wconfig->item('seo_webshop_page', 'seo_webshop_page_title'._LANG),
            'keywords' => $this->wconfig->item('seo_webshop_page', 'seo_webshop_page_keywords'._LANG),
            'description' => $this->wconfig->item('seo_webshop_page', 'seo_webshop_page_description'._LANG),
            'image'     => $this->wconfig->item('common','logo'),
            'page_url'     => $this->config->base_url('web-shop'),
            'page_type' => 'website'
        );
        
        $this->load->view('product/home', array(
            'metas' => $metas,
            'cate' => $this->product_cate_model->getList(array(
                'cate_ref_parent_id' => 0
            )),
            'post' => $post
        ));
    }
}
?>
