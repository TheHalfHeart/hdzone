<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Customer_customer_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'customer_customer';
    protected $_tb_alias    = 'customer';
    protected $_tb_key      = 'customer_id';
    protected $_tb_rules    = array
    (
        // Title
        'customer_username' => array(
            'is_username' => array(
                'error' => 'Tên đăng nhập phải từ 5 đến 15 ký tự'
            )
        ),
        'customer_username_int' => array(
            'is_required' => array(
                'error' => 'Tên đăng nhập không được để trống'
            ),
            'is_unique' => array(
                'error' => 'Tên đăng nhập đã tồn tại'
            )
        ),
        'customer_address' => array(
            'is_required' => array(
                'error' => 'Địa chỉ không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => 'Địa chỉ tối đa 500 ký tự'
            )
        ),
        'customer_fullname' => array(
            'is_required' => array(
                'error' => 'Tên khách hàng không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(250),
                'error' => 'Tên khách hàng tối đa 250 ký tự'
            )
        ),
        'customer_email' => array(
            'is_required' => array(
                'error' => 'Email không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(250),
                'error' => 'Email tối đa 250 ký tự'
            ),
            'is_email' => array(
                'error' => 'Email không đúng định dạng'
            ),
            'is_unique' => array(
                'error' => 'Email này đã được sử dụng'
            )
        ),
        'customer_phone' => array(
            'is_max_length' => array(
                'input' => array(30),
                'error' => 'Số điện thoại tối đa 30 ký tự'
            )
        ),
        'customer_group' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn nhóm cho khách hàng'
            ),
            'is_radio' => array(
                'error' => 'Nhóm khách hàng phải là cá nhân hoặc công ty'
            )
        ),
        'customer_group' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn tình trạng khách hàng'
            ),
            'is_radio' => array(
                'error' => 'Tình trạng khách hàng phải là khóa hoặc mở'
            )
        )
    );
    
    
    function update_total_order($customer_id, $string = '-'){
        $sql = "
            UPDATE ".$this->get_tbname()." SET 
            customer_total_order = customer_total_order $string 1
            WHERE customer_id =  $customer_id
        ";
        return $this->query($sql);
    }
}