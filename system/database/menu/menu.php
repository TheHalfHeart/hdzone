<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Menu_menu_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_menu';
    protected $_tb_alias    = 'menu';
    protected $_tb_key      = 'menu_id';
    protected $_tb_rules    = array
    (
        // Multilang
        'menu_title_vi' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập tiêu đề Tiếng Việt'
            )
        ),
        'menu_title_en' => array(
            'is_required' => array(
                'error' => 'Bạn chưa nhập tiêu đề Tiếng Anh'
            )
        ),
        'menu_target' => array(
            'is_required' => array(
                'error' => 'Target không được để trống'
            ),
            'is_number_between' => array(
                'input' => array(1,2),
                'error' => 'Target bạn chọn không tồn tại'
            )
        ),
        'menu_position' => array(
            'is_required' => array(
                'error' => 'Vị trí menu không tồn tại'
            ),
            'is_number_between' => array(
                'input' => array(1,6),
                'error' => 'Vị trí menu không tồn tại'
            )
        )
    );
}