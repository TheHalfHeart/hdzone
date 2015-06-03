<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customer_voucher_history_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'customer_voucher_history';
    protected $_tb_alias    = 'history';
    protected $_tb_key      = 'history_id';
}