<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_config_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_config';
    protected $_tb_alias    = 'config';
    protected $_tb_key      = 'config_id';
    
}


// Lấy thông tin lọc
$filter  = array(
    'email'     => isset($_GET['email']) ? mysql_escape_string($_GET['email']) : false,
    'phone'     => isset($_GET['email']) ? mysql_escape_string($_GET['phone']) : false,
    'address'   => isset($_GET['email']) ? mysql_escape_string($_GET['address']) : false,
    'fullname'  => isset($_GET['email']) ? mysql_escape_string($_GET['fullname']) : false
);

// Biến lưu trữ lọc
$where = array();

// Nếu có chọn lọc thì thêm điều kiện vào mảng
if ($filter['email']){
    $where[] = "email = '{$filter['email']}'";
}

if ($filter['phone']){
    $where[] = "phone = '{$filter['phone']}'";
}

if ($filter['address']){
    $where[] = "address = '{$filter['address']}'";
}

if ($filter['fullname']){
    $where[] = "fullname = '{$filter['fullname']}'";
}

// Câu truy vấn cuối cùng
$sql = 'SELECT * FROM customer';
if ($where){
    $sql .= ' WHERE '.implode(' AND ', $where);
}

