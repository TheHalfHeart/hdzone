<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_order_model
{
    private $__order = null;
            
    function __construct(){
        $this->__order = new_table('customer', 'order');
    }
    
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
                
                $current_order = $order->where('order_id', $id)->execute()->get_result(0);
                
                if ($current_order && $order->clear()->delete('order_id = '.$id)){
                    // Delete Order Product
                    new_table('customer', 'order_product')->delete('order_id = '.$id);
                    
                    // Update Cusstomer Count
                    new_table('customer', 'customer')->update_total_order($current_order['order_customer_id'], '-');
                }
                
            }
        }
        return $flag;
    }
    
    function edit($data, $order_id)
    {
        $this->__order->clear();
        // Get ID Customer
        $customer = new_table('customer', 'customer');
        $cus_current = $customer->where('customer_username_int', $data['order_customer_username_int'])->execute()->get_result(0);
        
        $current_order = $this->__order->where('order_id',$order_id)->execute()->get_result(0);
        $this->__order->clear();
        
        if ($current_order && $cus_current && $this->__order->where('order_id',$order_id)->validate($data, 'update'))
        {
            $data['order_customer_id'] = $cus_current['customer_id'];
            if ($this->__order->update($data))
            {
                if ($current_order['order_customer_id'] != $cus_current['customer_id']){
                    $customer->update_total_order($cus_current['customer_id'],'+');
                    $customer->update_total_order($current_order['order_customer_id'],'-');
                }
                return true;
            }
        }
        
        return $this->__order->get_error();
    }
    
    
    function getDetail($filter = array())
    {
        $this->__order->clear();
        if (isset($filter['order_id'])){
            $this->__order->where('order_id', $filter['order_id']);
        }
        return $this->__order->execute()->get_result(0);
    }
    
    // Set Editting
    function updateEditting($order_id)
    {
        $CI = get_instance();
        $this->__order->clear();
        $this->__order->where('order_id', $order_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Add
    function add($data){
        $this->__order->clear();
        
        // Get ID Customer
        $customer = new_table('customer', 'customer');
        $cus_current = $customer->where('customer_username_int', $data['order_customer_username_int'])->execute()->get_result(0);
        if ($cus_current && $this->__order->validate($data)){
            $data['order_customer_id'] = $cus_current['customer_id'];
            $id = $this->__order->insert($data);
            if ($id){
                $customer->update_total_order($cus_current['customer_id'],'+');
                return $id;
            }
        }
        return $this->__order->get_error();
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__order->clear();
        
        if (isset($filter['order_id']) && $filter['order_id']){
            $this->__order->where('order_id', (int)$filter['order_id']);
        }
        
        if (isset($filter['order_customer_username_int']) && $filter['order_customer_username_int']){
            $this->__order->where('order_customer_username_int', $filter['order_customer_username_int']);
        }
        
        if (isset($filter['order_email_int']) && $filter['order_email_int']){
            $this->__order->where('order_email_int', $filter['order_email_int']);
        }
        
        if (isset($filter['order_status']) && (string)$filter['order_status'] != ''){
            $this->__order->where('order_status', $filter['order_status']);
        }
        
        if (isset($filter['order_add_date_int']) && $filter['order_add_date_int']){
            $this->__order->where('order_add_date_int', $filter['order_add_date_int']);
        }
        
        return $this->__order->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__order->clear_select();
        
        if (isset($filter['select'])){
            $this->__order->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('order_id', 'order_add_date_time_int');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'order_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__order->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__order->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__order->execute()->get_result();
    }
}
?>
