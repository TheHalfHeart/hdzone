<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Page_page_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_page';
    protected $_tb_alias    = 'page';
    protected $_tb_key      = 'page_id';
    protected $_tb_rules    = array
    (
        'page_title_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập tiêu đề'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Việt] Tiêu đề tối đa 500 ký tự'
            )
        ),
        'page_title_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập tiêu đề'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Anh] Tiêu đề tối đa 500 ký tự'
            )
        ),
        'page_slug_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Anh] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Anh] Slug này đã được sử dụng'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Anh] Slug tối đa 500 ký tự'
            )
        ),
        'page_slug_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Việt] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Việt] Slug này đã được sử dụng'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Việt] Slug tối đa 500 ký tự'
            )
        ),
        'page_template' => array(
            'in_template_page' => array(
                'error' => 'Template bạn chọn không tồn tại'
            )
        ),
        'slide_image' => array(
            'is_max_length' => array(
                'error' => 'URL hình slide tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
        'page_summary_vi' => array(
            'is_max_length' => array(
                'input' => array(1000),
                'error' => '[Tiếng Việt] Tóm tắt tối đa 1000 ký tự'
            )
        ),
        'page_summary_en' => array(
            'is_max_length' => array(
                'input' => array(1000),
                'error' => '[Tiếng Anh] Tóm tắt tối đa 1000 ký tự'
            )
        )
    );
    
}