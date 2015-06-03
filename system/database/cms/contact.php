<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_contact_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_contact';
    protected $_tb_alias    = 'contact';
    protected $_tb_key      = 'contact_id';
    protected $_tb_rules    = array();
}