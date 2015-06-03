<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_tags_model
{
    private $__tags = null;
            
    function __construct(){
        $this->__tags = new_table('news', 'tags');
    }
    
    function getDetail($filter = array()){
        $this->__tags->clear();
        if (isset($filter['select'])){
            $this->__tags->select($filter['select']);
        }
        if (isset($filter['tags_id'])){
            $this->__tags->where('tags_id', $filter['tags_id']);
        }
        if (isset($filter['tags_slug'._LANG])){
            $this->__tags->where('tags_slug'._LANG, $filter['tags_slug'._LANG]);
        }
        return $this->__tags->execute()->get_result(0);
    }
    
    function getList($filter = array())
    {
        $this->__tags->clear_select();
        
        if (isset($filter['select'])){
            $this->__tags->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__tags->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__tags->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__tags->execute()->get_result();
    }
}
?>
