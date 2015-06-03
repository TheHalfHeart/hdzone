<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_contact_model
{
    private $__contact = null;
            
    function __construct(){
        $this->__contact = new_table('contact', 'contact');
    }
    
    // Add
    function add($data){
        $this->__contact->clear();
        if ($this->__contact->validate($data)){
            return $this->__contact->insert($data);
        }
        return $this->__contact->get_error();
    }
    
    // Edit
    function edit($data, $contact_id)
    {
        $this->__contact->clear();
        if ($this->__contact->where('contact_id', $contact_id)->validate($data, 'update'))
        {
            return $this->__contact->update($data);
        }
        return $this->__contact->get_error();
    }
    
    // Quick Edit
    function quick_edit($id, $field, $value)
    {
        if (!in_array($field, array('contact_status', 'contact_answer'))){
            return false;
        }
        
        if ($field == 'contact_status' || $field == 'contact_answer')
        {
            $data = array(
                $field => $value
            );
            
            if ($this->__contact->where('contact_id', $id)->validate($data, 'update')){
                $this->__contact->update($data);
                return true;
            }
        }
        
        return false;
    }
    
    // Delete
    function delete($list_id)
    {
        $this->__contact->clear();
        $id_array = preg_split('/\s+/', $list_id);
        if (sizeof($id_array) > 10){
            return 2; // Max 
        }
        
        $CI = & get_instance();
        
        foreach ($id_array as $id)
        {
            $id = (int)$id;
            if ($id)
            {
                $this->__contact->delete("contact_id = $id");
            }
        }
        return true;
    }
    
    // Set Editting
    function updateEditting($contact_id)
    {
        $CI = get_instance();
        $this->__contact->clear();
        $this->__contact->where('contact_id', $contact_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Get Detail
    function getDetail($filter = array())
    {
        $this->__contact->clear();
        if (isset($filter['select'])){
            $this->__contact->select($filter['select']);
        }
        if (isset($filter['contact_id'])){
            $this->__contact->where('contact_id', $filter['contact_id']);
        }
        return $this->__contact->execute()->get_result(0);
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__contact->clear();
        
        if (isset($filter['contact_add_user_username_int']) && $filter['contact_add_user_username_int']){
            $this->__contact->where('contact_add_user_username_int', $filter['contact_add_user_username_int']);
        }
        
        if (isset($filter['contact_add_date_int']) && $filter['contact_add_date_int']){
            $this->__contact->where('contact_add_date_int', $filter['contact_add_date_int']);
        }
        
        if (isset($filter['contact_title_clear_utf8']) && $filter['contact_title_clear_utf8']){
            $this->__contact->where("MATCH (contact_title_clear_utf8) AGAINST ('".boolean_mode($filter['contact_title_clear_utf8'])."' IN BOOLEAN MODE)");
        }
        
        if (isset($filter['contact_id']) && $filter['contact_id']){
            $this->__contact->where('contact_id', (int)$filter['contact_id']);
        }
        
        if (isset($filter['contact_status']) && (string)$filter['contact_status'] != '')
        {
            $this->__contact->where('contact_status', (string)$filter['contact_status']);
        }
        
        if (isset($filter['contact_answer']) && (string)$filter['contact_answer'] != '')
        {
            $this->__contact->where('contact_answer', (string)$filter['contact_answer']);
        }
        
        return $this->__contact->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__contact->clear_select();
        
        if (isset($filter['select'])){
            $this->__contact->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('contact_add_date_time_int', 'contact_id');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'contact_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__contact->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__contact->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__contact->execute()->get_result();
    }
}
?>
