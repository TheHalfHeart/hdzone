<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Product_manu_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'product_manu';
    protected $_tb_alias    = 'manu';
    protected $_tb_key      = 'manu_id';
    protected $_tb_rules    = array
    (
        // Title
        'manu_title_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Việt] Tiêu đề tối đa 250 ký tự'
            )
        ),
        'manu_title_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Anh] Tiêu đề tối đa 250 ký tự'
            )
        ),
        // Title_short
        'manu_title_short_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Tiêu đề ngắn không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Việt] Tiêu đề ngắn tối đa 250 ký tự'
            )
        ),
        'manu_title_short_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Tiêu đề ngắn không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Anh] Tiêu đề ngắn tối đa 250 ký tự'
            )
        ),
        // SLug
        'manu_slug_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Việt] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Việt] Slug tối đa 250 ký tự'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Việt] Slug này đã được sử dụng'
            )
        ),
        'manu_slug_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Anh] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Anh] Slug tối đa 250 ký tự'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Anh] Slug này đã được sử dụng'
            )
        )
    );
}