<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_hdd_group_model
{
    private $__hdd_group = null;
            
    function __construct(){
        $this->__hdd_group = new_table('product', 'hdd_group');
    }
    
    function edit($data, $hdd_group_id)
    {
        $this->__hdd_group->clear();
        if ($this->__hdd_group->where('hdd_group_id', $hdd_group_id)->validate($data, 'update'))
        {
            $info = $this->__hdd_group->execute()->get_result(0);
            
            if ($info && $this->__hdd_group->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__hdd_group->clear();
        if ($this->__hdd_group->validate($data)){
            return $this->__hdd_group->insert($data);
        }
        return $this->__hdd_group->get_error();
    }
    
    function updateEditting($hdd_group_id){
        $CI = get_instance();
        $this->__hdd_group->clear();
        $this->__hdd_group->where('hdd_group_id', $hdd_group_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__hdd_group->clear();
        
        if ($this->__hdd_group->delete('hdd_group_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__hdd_group->clear();
        if (isset($filter['select'])){
            $this->__hdd_group->select($filter['select']);
        }
        if (isset($filter['hdd_group_id'])){
            $this->__hdd_group->where('hdd_group_id', $filter['hdd_group_id']);
        }
        return $this->__hdd_group->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__hdd_group->clear();
        if (isset($filter['hdd_group_id']) && $filter['hdd_group_id']){
            $this->__hdd_group->where('hdd_group_id', $filter['hdd_group_id']);
        }
        if (isset($filter['hdd_group_add_user_username_int']) && $filter['hdd_group_add_user_username_int']){
            $this->__hdd_group->where('hdd_group_add_user_username_int', $filter['hdd_group_add_user_username_int']);
        }
        return $this->__hdd_group->count();
    }
    
    function clear(){
        $this->__hdd_group->clear();
    }
    
    function getList($filter = array())
    {
        $this->__hdd_group->clear_select();
        
        if (isset($filter['select'])){
            $this->__hdd_group->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__hdd_group->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__hdd_group->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__hdd_group->execute()->get_result();
    }
    
}
?>
