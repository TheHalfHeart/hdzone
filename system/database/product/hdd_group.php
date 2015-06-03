<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Product_hdd_group_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'product_hdd_group';
    protected $_tb_alias    = 'hdd_group';
    protected $_tb_key      = 'hdd_group_id';
    protected $_tb_rules    = array
    (
        // Title
        'hdd_group_title' => array(
            'is_required' => array(
                'error' => 'Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => 'Tiêu đề tối đa 250 ký tự'
            )
        ),
        'hdd_group_code' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập mã code'
            ),
            'is_unique' => array(
                'error' => 'Mã code này đã được sử dụng'
            )
        )
    );
}