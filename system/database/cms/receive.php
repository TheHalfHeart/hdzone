<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_receive_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_receive';
    protected $_tb_alias    = 'receive';
    protected $_tb_key      = 'receive_id';
    
    protected $_tb_rules    = array
    (
        // Title
        'receive_title' => array(
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