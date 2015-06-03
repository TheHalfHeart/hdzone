<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customer_order_product_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'customer_order_product';
    protected $_tb_alias    = 'order_product';
    protected $_tb_key      = 'id';
    protected $_tb_relation = array(
        'order' => array('alias' => 'order', 'field' => 'order_id'),
        'product' => array('alias' => 'product', 'field' => 'product_id')
    );
    
    protected $_tb_rules    = array
    (
        
    );
}