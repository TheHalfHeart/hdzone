<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customer_order_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'customer_order';
    protected $_tb_alias    = 'orders';
    protected $_tb_key      = 'order_id';
    protected $_tb_relation = array(
        'customer' => array('alias' => 'customer', 'field' => 'order_customer_id')
    );
    protected $_tb_rules    = array
    (
        
    );
    
    function change_price($price, $id, $op = '-'){
        
        $sql = "UPDATE " . $this->get_tbname()." SET 
            order_price = order_price $op $price 
             WHERE order_id = $id
        ";
        
        return $this->query($sql);
    }
    
}