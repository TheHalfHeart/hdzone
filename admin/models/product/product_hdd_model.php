<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_hdd_model
{
    private $__hdd = null;
            
    function __construct(){
        $this->__hdd = new_table('product', 'hdd');
    }
    
    function edit($data, $hdd_id)
    {
        $this->__hdd->clear();
        if ($this->__hdd->where('hdd_id', $hdd_id)->validate($data, 'update'))
        {
            $info = $this->__hdd->execute()->get_result(0);
            
            if ($info && $this->__hdd->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__hdd->clear();
        if ($this->__hdd->validate($data)){
            return $this->__hdd->insert($data);
        }
        return $this->__hdd->get_error();
    }
    
    function updateEditting($hdd_id){
        $CI = get_instance();
        $this->__hdd->clear();
        $this->__hdd->where('hdd_id', $hdd_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__hdd->clear();
        
        if ($this->__hdd->delete('hdd_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__hdd->clear();
        if (isset($filter['select'])){
            $this->__hdd->select($filter['select']);
        }
        if (isset($filter['hdd_id'])){
            $this->__hdd->where('hdd_id', $filter['hdd_id']);
        }
        return $this->__hdd->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__hdd->clear();
        if (isset($filter['hdd_id']) && $filter['hdd_id']){
            $this->__hdd->where('hdd_id', $filter['hdd_id']);
        }
        if (isset($filter['hdd_add_user_username_int']) && $filter['hdd_add_user_username_int']){
            $this->__hdd->where('hdd_add_user_username_int', $filter['hdd_add_user_username_int']);
        }
        return $this->__hdd->count();
    }
    
    function clear(){
        $this->__hdd->clear();
    }
    
    function getList($filter = array())
    {
        $this->__hdd->clear_select();
        
        if (isset($filter['select'])){
            $this->__hdd->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__hdd->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__hdd->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__hdd->execute()->get_result();
    }
    
}
?>
