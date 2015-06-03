<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_post_model
{
    private $__post = null;
            
    function __construct(){
        $this->__post = new_table('product', 'post');
    }
    
    function getDetail($filter = array()){
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
    
    function getListByCateParent($cate_parent = '0', $limit = 10, $select = '*')
    {
        $result = array();
        
        $cate = new_table('product', 'cate')->where('cate_ref_parent_id', $cate_parent)->execute()->get_result();
        
        foreach ($cate as $key => $item)
        {
            $this->__post->select($select);
            $this->__post->clear();
            $this->__post->where('post_timer_date_time_int', current_date_time_to_int(), '<=');
            $this->__post->where_cate_id($item['cate_id']);
            $this->__post->order_by('post_timer_date_time_int', 'desc');
            $this->__post->limit('0', $limit);
            $post = $this->__post->execute()->get_result();
            
            $result[] = array(
                'cate' => $item,
                'post' => $post
            );
        }
        
        return $result;
        
    }
    
    function setWhere($filter)
    {
        $this->__post->clear();
        
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
        
        // Ref
        if (isset($filter['post_ref_brand_id']) && (string)$filter['post_ref_brand_id'] != ''){
            $this->__post->where_brand_id((int)$filter['post_ref_brand_id']);
        }
        
        // Ref
        if (isset($filter['post_ref_manu_id']) && (string)$filter['post_ref_manu_id'] != ''){
            $this->__post->where_manu_id((int)$filter['post_ref_manu_id']);
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
    
    function countList()
    {
        return $this->__post->count();
    }
    
    function getList($filter = array())
    {
        $this->__post->clear_select();
        
        if (isset($filter['select'])){
            $this->__post->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__post->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__post->limit($filter['start'], $filter['limit']);
        }
        
        $this->__post->order_by('post_timer_date_time_int', 'desc');
        
        return $this->__post->execute()->get_result();
    }
}
?>
