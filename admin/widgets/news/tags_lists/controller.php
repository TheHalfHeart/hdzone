<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_tags_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('news/news_tags_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'tags_id'       => $this->input->get('tags_id'),
            lang_field('tags_title_short') => $this->input->get(lang_field('tags_title_short')),
            'tags_add_user_username' => $this->input->get('tags_add_user_username'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'tags_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        if ($filter['tags_add_user_username']){
            $filter['tags_add_user_username_int'] = username_hash($filter['tags_add_user_username']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->news_tags_model->countList($filter));
        if (isset($filter['tags_add_user_username_int'])){
            unset($filter['tags_add_user_username_int']);
        }
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('news/tags_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'tags_id,'.lang_field('tags_title_short').',tags_total_post,tags_add_user_username,editting_date_time_int,editting_user_username,editting_token';
        
        // List Data
        $data = $this->news_tags_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
