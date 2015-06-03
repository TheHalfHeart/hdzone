<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_voucher_model
{
    private $__voucher = null;
    private $__customer = null;
    
    function __construct(){
        $this->__voucher = new_table('customer', 'voucher');
        $this->__customer = new_table('customer', 'customer');
    }
    
    function edit($data, $voucher_id)
    {
        $this->__voucher->clear();
        if ($this->__voucher->where('voucher_id', $voucher_id)->validate($data, 'update'))
        {
            $info = $this->__voucher->execute()->get_result(0);
            
            if ($info && $this->__voucher->update($data))
            {
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function add($data)
    {
        $this->__voucher->clear();
        if ($this->__voucher->validate($data)){
            return $this->__voucher->insert($data);
        }
        return $this->__voucher->get_error();
    }
    
    function updateEditting($voucher_id){
        $CI = get_instance();
        $this->__voucher->clear();
        $this->__voucher->where('voucher_id', $voucher_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__voucher->clear();
        
        if ($this->__voucher->delete('voucher_id = '.(int)$list_id)){
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__voucher->clear();
        if (isset($filter['select'])){
            $this->__voucher->select($filter['select']);
        }
        if (isset($filter['voucher_id'])){
            $this->__voucher->where('voucher_id', $filter['voucher_id']);
        }
        return $this->__voucher->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__voucher->clear();
        $this->__customer->clear();
        if (isset($filter['voucher_id']) && $filter['voucher_id']){
            $this->__voucher->where('voucher_id', $filter['voucher_id']);
        }
        if (isset($filter['customer_username_int']) && $filter['customer_username_int']){
            $this->__voucher->where_join('customer','customer_username_int', $filter['customer_username_int']);
        }
        if (isset($filter['voucher_add_user_username_int']) && $filter['voucher_add_user_username_int']){
            $this->__voucher->where('voucher_add_user_username_int', $filter['voucher_add_user_username_int']);
        }
        if (isset($filter['voucher_code']) && $filter['voucher_code']){
            $this->__voucher->where('voucher_code', $filter['voucher_code']);
        }
        if (isset($filter['voucher_price']) && $filter['voucher_price']){
            $this->__voucher->where('voucher_price', $filter['voucher_price']);
        }
        if (isset($filter['voucher_price_current']) && $filter['voucher_price_current']){
            $this->__voucher->where('voucher_price_current', $filter['voucher_price_current']);
        }
        if (isset($filter['voucher_active_date_int']) && $filter['voucher_active_date_int']){
            $this->__voucher->where('voucher_active_date_int', $filter['voucher_active_date_int']);
        }
        if (isset($filter['voucher_end_date_int']) && $filter['voucher_end_date_int']){
            $this->__voucher->where('voucher_end_date_int', $filter['voucher_end_date_int']);
        }
        if (isset($filter['voucher_status']) && (string)$filter['voucher_status'] != ''){
            $this->__voucher->where('voucher_status', $filter['voucher_status']);
        }
        $this->__customer->select('customer_username_int,customer_id, customer_username');
        
        $this->__voucher->join($this->__customer, 'customer', 'left');
        
        return $this->__voucher->count();
    }
    
    function clear(){
        $this->__voucher->clear();
        $this->__customer->clear();
    }
    
    function getList($filter = array())
    {
        $this->__voucher->clear_select();
                
        if (isset($filter['select'])){
            $this->__voucher->select($filter['select']);
        }
        
        $this->__voucher->select_join('customer', 'customer_id, customer_username', false);
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $this->__voucher->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__voucher->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__voucher->execute()->get_result();
    }
    
}
?>
