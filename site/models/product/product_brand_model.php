<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_brand_model
{
    private $__brand = null;
            
    function __construct(){
        $this->__brand = new_table('product', 'brand');
    }
    
    function getDetail($filter = array())
    {
        $this->__brand->clear();
        if (isset($filter['select'])){
            $this->__brand->select($filter['select']);
        }
        if (isset($filter['brand_id'])){
            $this->__brand->where('brand_id', $filter['brand_id']);
        }
        if (isset($filter['brand_slug_int'._LANG])){
            $this->__brand->where('brand_slug_int'._LANG, $filter['brand_slug_int'._LANG]);
        }
        return $this->__brand->execute()->get_result(0);
    }
    
    function getList($filter = array())
    {
        $this->__brand->clear();
        
        if (isset($filter['select'])){
            $this->__brand->select($filter['select']);
        }
        
        if (isset($filter['brand_ref_parent_id'])){
            $this->__brand->where($filter['brand_ref_parent_id'], $filter['brand_ref_parent_id']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__brand->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__brand->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__brand->execute()->get_result();
    }
}
?>
