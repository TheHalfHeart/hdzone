<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class News_cate_add_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            // Fill Data
            foreach ($filter as & $item){
                $item = quotes_to_entities($item);
            }
            
            // Load Lib
            $this->load->model('news/news_cate_model');
            
            // List Data
            $this->news_cate_model->clear();
            $cate = $this->news_cate_model->getList(array
            (
                'select'     => 'cate_id,cate_ref_parent_id,'.lang_field('cate_title_short').','.lang_field('cate_title').',cate_total_post,cate_add_user_username,editting_date_time_int,editting_user_username,editting_token,cate_sort',
                'order_by'  => 'cate_sort',
                'order_type'=> 'asc'
            ));
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'cate'              => $cate,
                    'filter'            => $filter
            ));
        }
    }
?>
