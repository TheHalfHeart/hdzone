<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_receive_model
{
    private $__receive = null;
    
    function __construct(){
        $this->__receive = new_table('cms', 'receive');
    }
    
    function edit($data, $receive_id)
    {
        $this->__receive->clear();
        if ($this->__receive->where('receive_id', $receive_id)->validate($data, 'update'))
        {
            $info = $this->__receive->execute()->get_result(0);
            
            if ($info && $this->__receive->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__receive->clear();
        if ($this->__receive->validate($data)){
            return $this->__receive->insert($data);
        }
        return $this->__receive->get_error();
    }
    
    function updateEditting($receive_id){
        $CI = get_instance();
        $this->__receive->clear();
        $this->__receive->where('receive_id', $receive_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__receive->clear();
        
        if ($this->__receive->delete('receive_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__receive->clear();
        if (isset($filter['select'])){
            $this->__receive->select($filter['select']);
        }
        if (isset($filter['receive_id'])){
            $this->__receive->where('receive_id', $filter['receive_id']);
        }
        return $this->__receive->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__receive->clear();
        if (isset($filter['receive_id']) && $filter['receive_id']){
            $this->__receive->where('receive_id', $filter['receive_id']);
        }
        if (isset($filter['receive_add_user_username_int']) && $filter['receive_add_user_username_int']){
            $this->__receive->where('receive_add_user_username_int', $filter['receive_add_user_username_int']);
        }
        return $this->__receive->count();
    }
    
    function clear(){
        $this->__receive->clear();
    }
    
    function getList($filter = array())
    {
        $this->__receive->clear_select();
        
        if (isset($filter['select'])){
            $this->__receive->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__receive->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__receive->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__receive->execute()->get_result();
    }
    
}
?>
