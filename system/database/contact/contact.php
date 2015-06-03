<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Contact_contact_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_contact';
    protected $_tb_alias    = 'contact';
    protected $_tb_key      = 'contact_id';
    protected $_tb_rules    = array
    (
        'contact_title' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập tiêu đề'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => 'Tiêu đề tối đa 500 ký tự'
            )
        ),
        'contact_fullname' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập tên của bạn'
            ),
            'is_max_length' => array(
                'error' => 'Tên của bạn tối đa là 250 ký tự'
            )
        ),
        'contact_email' => array(
            'is_required' => array(
                'error' => 'Email không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(250),
                'error' => 'Email tối đa là 250 ký tự'
            ),
            'is_email'  => array(
                'error' => 'Email không đúng định dạng'
            )
        ),
        'contact_address' => array(
            'is_max_length' => array(
                'input' => array(250),
                'error' => 'Địa chỉ tối đa là 250 ký tự'
            )
        ),
        'contact_phone' => array(
            'is_max_length' => array(
                'input' => array(30),
                'error' => 'Số điện thoại tối đa là 30 ký tự'
            )
        ),
        'contact_content' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập nội dung liên hệ'
            )
        ),
        'contact_status' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn tình trạng kiểm duyệt'
            ),
            'is_radio' => array(
                'error' => 'Tình trạng kiểm duyệt không phù hợp'
            )
        ),
        'contact_answer' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn tình trạng trả lời'
            ),
            'is_radio' => array(
                'error' => 'Tình trạng trả lời không phù hợp'
            )
        )
    );
    
}