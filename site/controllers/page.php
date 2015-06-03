<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Page extends CI_Controller {

    function index($slug = '')
    {
        $this->lang->check('vi');
        
        $this->lang->load('site', LANG);
        
        $this->load->model('page/page_page_model');
                
        $page = $this->page_page_model->getDetail(array(
            'page_slug_int'._LANG => to_slug_int($slug)
        ));
        
        if (!$page){
            redirect_404();
        }
        
        $metas = array(
            'revisit-after' => $page['page_seo_last_visit'],
            'robots'        => $page['page_seo_robots'],
            'title'         => $page['page_seo_title'._LANG] ? $page['page_seo_title'._LANG] : $page['page_title'._LANG],
            'keywords'      => $page['page_seo_keywords'._LANG],
            'description'   => $page['page_seo_description'._LANG],
            'image'         => $page['page_image'],
            'page_type'     => 'article',
            'page_url'      => $this->config->base_url($page['page_slug'._LANG].'.html'),
            'published_time_int' => $page['page_timer_date_time_int'],
            'modified_time_int'  => $page['page_last_update_date_time_int']
        );
        
        $this->load->view($page['page_template'], array(
            'page' => $page,
            'metas' => $metas
        )); 
    }

}