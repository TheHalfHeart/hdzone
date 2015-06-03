<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_device_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_device';
    protected $_tb_alias    = 'device';
    protected $_tb_key      = 'device_id';
    protected $_tb_rules    = array
    (
        // Title
        'device_title' => array(
            'is_required' => array(
                'error' => 'Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => 'Tiêu đề tối đa 250 ký tự'
            )
        )
    );
}