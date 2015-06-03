<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_showroom_model
{
    private $__showroom = null;
            
    function __construct(){
        $this->__showroom = new_table('cms', 'showroom');
    }
    
    function edit($data, $showroom_id)
    {
        $this->__showroom->clear();
        if ($this->__showroom->where('showroom_id', $showroom_id)->validate($data, 'update'))
        {
            $info = $this->__showroom->execute()->get_result(0);
            
            if ($info && $this->__showroom->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__showroom->clear();
        if ($this->__showroom->validate($data)){
            return $this->__showroom->insert($data);
        }
        return $this->__showroom->get_error();
    }
    
    function updateEditting($showroom_id){
        $CI = get_instance();
        $this->__showroom->clear();
        $this->__showroom->where('showroom_id', $showroom_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__showroom->clear();
        
        if ($this->__showroom->delete('showroom_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__showroom->clear();
        if (isset($filter['select'])){
            $this->__showroom->select($filter['select']);
        }
        if (isset($filter['showroom_id'])){
            $this->__showroom->where('showroom_id', $filter['showroom_id']);
        }
        return $this->__showroom->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__showroom->clear();
        if (isset($filter['showroom_id']) && $filter['showroom_id']){
            $this->__showroom->where('showroom_id', $filter['showroom_id']);
        }
        if (isset($filter['showroom_add_user_username_int']) && $filter['showroom_add_user_username_int']){
            $this->__showroom->where('showroom_add_user_username_int', $filter['showroom_add_user_username_int']);
        }
        return $this->__showroom->count();
    }
    
    function clear(){
        $this->__showroom->clear();
    }
    
    function getList($filter = array())
    {
        $this->__showroom->clear_select();
        
        if (isset($filter['select'])){
            $this->__showroom->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__showroom->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__showroom->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__showroom->execute()->get_result();
    }
    
}
?>
