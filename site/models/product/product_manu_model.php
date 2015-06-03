<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_manu_model
{
    private $__manu = null;
            
    function __construct(){
        $this->__manu = new_table('product', 'manu');
    }
    
    function getDetail($filter = array())
    {
        $this->__manu->clear();
        if (isset($filter['select'])){
            $this->__manu->select($filter['select']);
        }
        if (isset($filter['manu_id'])){
            $this->__manu->where('manu_id', $filter['manu_id']);
        }
        if (isset($filter['manu_slug_int'._LANG])){
            $this->__manu->where('manu_slug_int'._LANG, $filter['manu_slug_int'._LANG]);
        }
        return $this->__manu->execute()->get_result(0);
    }
    
    function getList($filter = array())
    {
        $this->__manu->clear();
        
        if (isset($filter['select'])){
            $this->__manu->select($filter['select']);
        }
        
        if (isset($filter['manu_ref_parent_id'])){
            $this->__manu->where($filter['manu_ref_parent_id'], $filter['manu_ref_parent_id']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__manu->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__manu->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__manu->execute()->get_result();
    }
}
?>
