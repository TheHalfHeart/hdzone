<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_device_model
{
    private $__device = null;
            
    function __construct(){
        $this->__device = new_table('cms', 'device');
    }
    
    function edit($data, $device_id)
    {
        $this->__device->clear();
        if ($this->__device->where('device_id', $device_id)->validate($data, 'update'))
        {
            $info = $this->__device->execute()->get_result(0);
            
            if ($info && $this->__device->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__device->clear();
        if ($this->__device->validate($data)){
            return $this->__device->insert($data);
        }
        return $this->__device->get_error();
    }
    
    function updateEditting($device_id){
        $CI = get_instance();
        $this->__device->clear();
        $this->__device->where('device_id', $device_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__device->clear();
        
        if ($this->__device->delete('device_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__device->clear();
        if (isset($filter['select'])){
            $this->__device->select($filter['select']);
        }
        if (isset($filter['device_id'])){
            $this->__device->where('device_id', $filter['device_id']);
        }
        return $this->__device->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__device->clear();
        if (isset($filter['device_id']) && $filter['device_id']){
            $this->__device->where('device_id', $filter['device_id']);
        }
        if (isset($filter['device_add_user_username_int']) && $filter['device_add_user_username_int']){
            $this->__device->where('device_add_user_username_int', $filter['device_add_user_username_int']);
        }
        return $this->__device->count();
    }
    
    function clear(){
        $this->__device->clear();
    }
    
    function getList($filter = array())
    {
        $this->__device->clear_select();
        
        if (isset($filter['select'])){
            $this->__device->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__device->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__device->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__device->execute()->get_result();
    }
    
}
?>
