<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_cate_model
{
    private $__cate = null;
            
    function __construct(){
        $this->__cate = new_table('product', 'cate');
    }
    
    function getDetail($filter = array())
    {
        $this->__cate->clear();
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        if (isset($filter['cate_id'])){
            $this->__cate->where('cate_id', $filter['cate_id']);
        }
        if (isset($filter['cate_slug_int'._LANG])){
            $this->__cate->where('cate_slug_int'._LANG, $filter['cate_slug_int'._LANG]);
        }
        return $this->__cate->execute()->get_result(0);
    }
    
    function getList($filter = array())
    {
        $this->__cate->clear();
        
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        
        if (isset($filter['cate_ref_parent_id'])){
            $this->__cate->where('cate_ref_parent_id', $filter['cate_ref_parent_id']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__cate->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__cate->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__cate->execute()->get_result();
    }
}
?>
