<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_cate_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('news/news_cate_model');
        
        // Get Filter
        $filter = array
        (
            'order_by'      => 'cate_sort',
            'order_type'    => 'asc',
            'lang'  => $this->input->get('lang')
        );
        
        // Filter
        $filter['select'] = 'cate_id,cate_ref_parent_id,'.lang_field('cate_title_short').','.lang_field('cate_title').',cate_total_post,cate_add_user_username,editting_date_time_int,editting_user_username,editting_token,cate_sort';
        
        // List Data
        $data = $this->news_cate_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => 'news/cate_lists'
        ));
    }   
        
}
?>
