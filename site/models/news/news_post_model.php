<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_post_model
{
    private $__post = null;
            
    function __construct(){
        $this->__post = new_table('news', 'post');
    }
    
    function getDetail($filter = array())
    {
        $this->__post->clear();
        
        $this->__post->where('post_timer_date_time_int', current_date_time_to_int(), '<=');
        
        if (isset($filter['select'])){
            $this->__post->select($filter['select']);
        }
        
        if (isset($filter['post_id'])){
            $this->__post->where('post_id', $filter['post_id']);
        }
        
        return $this->__post->execute()->get_result(0);
    }
    
    function setWhere($filter = array())
    {
        $this->__post->clear();
        
        // Timer
        $this->__post->where('post_timer_date_time_int', current_date_time_to_int(), '<=');
        
        // Title
        if (isset($filter['post_title_clear_utf8'._LANG]) && $filter['post_title_clear_utf8'._LANG]){
            // $this->__post->where("MATCH (".'post_title_clear_utf8'._LANG.") AGAINST ('".boolean_mode($filter['post_title_clear_utf8'._LANG])."' IN BOOLEAN MODE)");
            $this->__post->where_like('post_title_clear_utf8'._LANG, $filter['post_title_clear_utf8'._LANG]);
        }
        
        // Author
        if (isset($filter['post_add_user_username_int']) && $filter['post_add_user_username_int']){
            $this->__post->where('post_add_user_username_int', $filter['post_add_user_username_int']);
        }
        
        // Ref
        if (isset($filter['post_ref_cate_id']) && (string)$filter['post_ref_cate_id'] != ''){
            $this->__post->where_cate_id((int)$filter['post_ref_cate_id']);
        }
        
        // Tags
        if (isset($filter['post_ref_tags_id']) && $filter['post_ref_tags_id']){
            $this->__post->where("MATCH (post_ref_tags_id) AGAINST ('".boolean_mode($filter['post_ref_tags_id'])."' IN BOOLEAN MODE)");
        }
        
        // CurrentId
        if (isset($filter['id_related']) && $filter['id_related']){
            $this->__post->where('post_id', $filter['id_related'], '<>');
        }
        
    }
    
    function countList(){
        return $this->__post->count();
    }
    
    function getList($filter = array())
    {
        $this->__post->clear_select();
        
        if (isset($filter['select'])){
            $this->__post->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])){
            $this->__post->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__post->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__post->execute()->get_result();
    }
}
?>
