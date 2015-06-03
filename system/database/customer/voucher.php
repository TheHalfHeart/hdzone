<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customer_voucher_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'customer_voucher';
    protected $_tb_alias    = 'voucher';
    protected $_tb_key      = 'voucher_id';
    protected $_tb_relation = array(
        'customer' => array('alias' => 'customer', 'field' => 'voucher_customer_id')
    );
    
    protected $_tb_rules    = array
    (
        // Title
        'voucher_title' => array(
            'is_required' => array(
                'error' => 'Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => 'Tiêu đề tối đa 250 ký tự'
            )
        ),
        'voucher_code' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập mã code'
            ),
            'is_unique' => array(
                'error' => 'Mã code này đã được sử dụng'
            )
        )
    );
}