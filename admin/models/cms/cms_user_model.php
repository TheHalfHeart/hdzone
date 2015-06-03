<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_user_model
{
    private $__user = null;
    
    function __construct() {
        $this->__user = new_table('cms', 'user');
    }
    
    function edit($data, $user_id){
        $this->__user->clear();
        if ($this->__user->where('user_id', (int)$user_id)->validate($data, 'update')){
            if (isset($data['user_password'])){
                $data['user_password'] = password_hash($data['user_password'], 4);
            }
            return $this->__user->update($data);
        }
        return $this->__user->get_error();
    }
    
    function delete($id){
        $this->__user->clear();
        return $this->__user->delete("user_id = $id");
    }
    
    function add($data){
        $this->__user->clear();
        if ($this->__user->validate($data)){
            $data['user_password'] = password_hash($data['user_password'], 4);
            return $this->__user->insert($data);
        }
        return $this->__user->get_error();
    }
    
    function updateEditting($user_id)
    {
        $CI = get_instance();
        $this->__user->clear();
        $this->__user->where('user_id', $user_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Login
    function getDetail($filter)
    {
        $this->__user->clear();
        
        if (isset($filter['select'])){
            $this->__user->select($filter['select']);
        }
        
        if (isset($filter['user_id'])){
            $this->__user->where('user_id', (int)$filter['user_id']);
        }
        
        if (isset($filter['user_is_root<>'])){
            $this->__user->where('user_is_root', (int)$filter['user_is_root<>']);
        }
        
        if (isset($filter['user_username_int'])){
            $this->__user->where('user_username_int', $filter['user_username_int']);
        }
        
        return $this->__user->execute()->get_result(0);
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__user->clear();
        
        if (isset($filter['user_id']) && $filter['user_id']){
            $this->__user->where('user_id', (int)$filter['user_id']);
        }
        
        if (isset($filter['user_level']) && $filter['user_level']){
            $this->__user->where('user_level', (int)$filter['user_level']);
        }
        
        if (isset($filter['user_status']) && (string)$filter['user_status'] != ''){
            $this->__user->where('user_status', (int)$filter['user_status']);
        }
        
        if (isset($filter['user_add_date_int']) && $filter['user_add_date_int']){
            $this->__user->where('user_add_date_int', $filter['user_add_date_int']);
        }
        
        if (isset($filter['user_username_int']) && $filter['user_username_int']){
            $this->__user->where('user_username_int', $filter['user_username_int']);
        }
        
        if (isset($filter['user_email_int']) && $filter['user_email_int']){
            $this->__user->where('user_email_int', $filter['user_email_int']);
        }
        
        return $this->__user->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__user->clear_select();
        
        if (isset($filter['select'])){
            $this->__user->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('user_id', 'user_level', 'user_add_date_timer_int');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'user_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__user->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__user->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__user->execute()->get_result();
    }
}
?>
