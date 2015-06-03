<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_tags_model
{
    private $__tags = null;
            
    function __construct(){
        $this->__tags = new_table('product', 'tags');
    }
    
    function edit($data, $tags_id){
        $this->__tags->clear();
        if ($this->__tags->where('tags_id', $tags_id)->validate($data, 'update'))
        {
            if ($this->__tags->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__tags->clear();
        if ($this->__tags->validate($data)){
            return $this->__tags->insert($data);
        }
        return $this->__tags->get_error();
    }
    
    function updateEditting($tags_id){
        $CI = get_instance();
        $this->__tags->clear();
        $this->__tags->where('tags_id', $tags_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $id_array = preg_split('/\s+/', $list_id);
        if (sizeof($id_array) > 10){
            return 2; // Max 
        }
        
        foreach ($id_array as $id)
        {
            $this->__tags->clear();
            if ((int)$id){
                $this->__tags->delete('tags_id = '.(int)$id);
            }
        }
        
        return true;
    }
    
    function getDetail($filter = array()){
        $this->__tags->clear();
        if (isset($filter['select'])){
            $this->__tags->select($filter['select']);
        }
        if (isset($filter['tags_id'])){
            $this->__tags->where('tags_id', $filter['tags_id']);
        }
        return $this->__tags->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__tags->clear();
        if (isset($filter['tags_id']) && $filter['tags_id']){
            $this->__tags->where('tags_id', $filter['tags_id']);
        }
        if (isset($filter[lang_field('tags_title_short')]) && $filter[lang_field('tags_title_short')]){
            $this->__tags->where_like(lang_field('tags_title_short'), $filter[lang_field('tags_title_short')]);
        }
        if (isset($filter['tags_add_user_username_int']) && $filter['tags_add_user_username_int']){
            $this->__tags->where('tags_add_user_username_int', $filter['tags_add_user_username_int']);
        }
        return $this->__tags->count();
    }
    
    function getList($filter = array())
    {
        $this->__tags->clear_select();
        
        if (isset($filter['select'])){
            $this->__tags->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('tags_id', 'tags_sort', 'tags_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'tags_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__tags->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__tags->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__tags->execute()->get_result();
    }
}
?>
