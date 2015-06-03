<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cms_contact_answer_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_contact_answer';
    protected $_tb_alias    = 'ct_answer';
    protected $_tb_key      = 'answer_id';
    protected $_tb_rules    = array();
}