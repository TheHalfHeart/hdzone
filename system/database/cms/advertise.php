<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_advertise_table extends MY_Table 
{
   
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_advertise';
    protected $_tb_alias    = 'adv';
    protected $_tb_key      = 'adv_id';
    protected $_tb_rules    = array();
}