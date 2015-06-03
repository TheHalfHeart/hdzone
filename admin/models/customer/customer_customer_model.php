<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_customer_model
{
    private $__customer = null;
            
    function __construct(){
        $this->__customer = new_table('customer', 'customer');
    }
    
    // Delete
    function delete($list_id)
    {
        $id_array = preg_split('/\s+/', $list_id);
        if (sizeof($id_array) > 10){
            return 2; // Max 
        }
        
        $CI = & get_instance();
        
        $order = new_table('customer', 'order');
        
        $flag = 0; // success
        foreach ($id_array as $id)
        {
            $id = (int)$id;
            if ($id)
            {
                $order->clear();
                $order->where('order_customer_id', $id);
                $total = $order->count();
                
                if ($total > 0){
                    $flag = 1; // success, con order
                    continue;
                }
                
                $this->__customer->clear();
                $this->__customer->delete('customer_id = '.$id);
            }
        }
        return $flag;
    }
    
    function quick_edit($field, $value, $id)
    {
        $this->__customer->clear();
        
        if ($field == 'customer_status')
        {
            $data = array(
                'customer_status' => $value
            );
            
            if ($this->__customer->where('customer_id', $id)->validate($data, 'update')){
                $this->__customer->update($data);
                return true;
            }
        }
        else if ($field == 'customer_group')
        {
            $data = array(
                'customer_group' => $value
            );
            
            if ($this->__customer->where('customer_id', $id)->validate($data, 'update')){
                $this->__customer->update($data);
                return true;
            }
        }
        return false;
    }
    
    function edit($data, $customer_id)
    {
        $this->__customer->clear();
        if ($this->__customer->where('customer_id',$customer_id)->validate($data, 'update'))
        {
            if ($this->__customer->update($data))
            {
                return true;
            }
        }
        
        return $this->__customer->get_error();
    }
    
    
    function getDetail($filter = array())
    {
        $this->__customer->clear();
        if (isset($filter['customer_id']) && $filter['customer_id']){
            $this->__customer->where('customer_id', $filter['customer_id']);
        }
        if (isset($filter['customer_username_int']) && $filter['customer_username_int']){
            $this->__customer->where('customer_username_int', $filter['customer_username_int']);
        }
        if (isset($filter['customer_email']) && $filter['customer_email']){
            $this->__customer->where('customer_email', $filter['customer_email']);
        }
        if (isset($filter['customer_phone']) && $filter['customer_phone']){
            $this->__customer->where('customer_phone', $filter['customer_phone']);
        }
        return $this->__customer->execute()->get_result(0);
    }
    
    // Set Editting
    function updateEditting($customer_id)
    {
        $CI = get_instance();
        $this->__customer->clear();
        $this->__customer->where('customer_id', $customer_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Add
    function add($data){
        $this->__customer->clear();
        if ($this->__customer->validate($data)){
            return $this->__customer->insert($data);
        }
        return $this->__customer->get_error();
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__customer->clear();
        
        if (isset($filter['customer_id']) && $filter['customer_id']){
            $this->__customer->where('customer_id', (int)$filter['customer_id']);
        }
        
        if (isset($filter['customer_username_int']) && $filter['customer_username_int']){
            $this->__customer->where('customer_username_int', $filter['customer_username_int']);
        }
        
        if (isset($filter['customer_fullname']) && $filter['customer_fullname']){
            $this->__customer->where_like('customer_fullname', $filter['customer_fullname']);
        }
        
        if (isset($filter['customer_email_int']) && $filter['customer_email_int']){
            $this->__customer->where('customer_email_int', $filter['customer_email_int']);
        }
        
        if (isset($filter['customer_group']) && (string)$filter['customer_group'] != ''){
            $this->__customer->where('customer_group', $filter['customer_group']);
        }
        
        if (isset($filter['customer_phone']) && $filter['customer_phone']){
            $this->__customer->where('customer_phone', $filter['customer_phone']);
        }
        
        if (isset($filter['customer_address']) && $filter['customer_address']){
            $this->__customer->where_like('customer_address', $filter['customer_address']);
        }
        
        if (isset($filter['customer_status']) && (string)$filter['customer_status'] != ''){
            $this->__customer->where('customer_status', $filter['customer_status']);
        }
        
        return $this->__customer->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__customer->clear_select();
        
        if (isset($filter['select'])){
            $this->__customer->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('customer_id', 'customer_add_date_time_int', 'customer_total_order');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'customer_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__customer->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__customer->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__customer->execute()->get_result();
    }
}
?>
