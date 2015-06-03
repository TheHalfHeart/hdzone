<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class News_cate_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $cate_id = (int)$this->input->get('cate_id');
            
            if (!$cate_id){
                return;
            }
            
            $this->load->model('news/news_cate_model');
            
            $data = $this->news_cate_model->getDetail(array(
                'cate_id' => $cate_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->news_cate_model->updateEditting($cate_id);
            }
            
            // Fill Data
            if ($filter)
            {
                foreach ($filter as $key => $item){
                    $data[$key] = $item;
                }
            }
            
            // Filter
            foreach ($data as & $item){
                $item = quotes_to_entities($item);
            }
            
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
                    'filter'            => $data
            ));
        }
    }
?>
