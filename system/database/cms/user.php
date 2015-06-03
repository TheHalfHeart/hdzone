<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_user_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_user';
    protected $_tb_alias    = 'user';
    protected $_tb_key      = 'user_id';
    protected $_tb_rules    = array(
        'user_username' => array(
            'is_required' => array(
                'error' => 'Tên đăng nhập không được để trống'
            ),
            'is_username' => array(
                'error' => 'Tên đăng nhập chỉ chấp nhận ký tự không dấu, ký tự số và dài từ 5 đến 15 ký tự'
            )
        ),
        'user_username_int' => array(
            'is_required' => array(
                'error' => 'Tên đăng nhập không được để trống'
            ),
            'is_unique' => array(
                'error' => 'Tên đăng nhập đã tồn tại'
            )
        ),
        'user_password' => array(
            'is_required' => array(
                'error' => 'Mật khẩu không được để trống'
            ),
            'is_min_length' => array(
                'error' => 'Mật khẩu ít nhất là 8 ký tự',
                'input' => array(8)
            )
        ),
        'user_email' => array(
            'is_required' => array(
                'error' => 'Email không được để trống'
            ),
            'is_email' => array(
                'error' => 'Email không đúng định dạng'
            )
        ),
        'user_email_int' => array(
            'is_required' => array(
                'error' => 'Email không được để trống'
            ),
            'is_unique' => array(
                'error' => 'Email này đã tồn tại'
            )
        ),
        'user_level' => array(
            'is_required' => array(
                'error' => 'Group bạn chọn không phù hợp'
            ),
            'in_user_level' => array(
                'error' => 'Group bạn chọn không phù hợp'
            )
        )
    );
}