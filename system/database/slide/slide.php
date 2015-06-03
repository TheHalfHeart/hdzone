<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Slide_slide_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'cms_slide';
    protected $_tb_alias    = 'slide';
    protected $_tb_key      = 'slide_id';
    protected $_tb_rules    = array
    (
        // Title
        'slide_title_vi' => array
        (
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập tiêu đề'
            ),
            'is_max_length' => array(
                'error' => '[Tiếng Việt] Tiêu đề tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
       'slide_title_en' => array
        (
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập tiêu đề'
            ),
            'is_max_length' => array(
                'error' => '[Tiếng Anh] Tiêu đề tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
        
        // Link
        'slide_link_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập Link'
            ),
            'is_max_length' => array(
                'error' => '[Tiếng Việt] Link tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
        'slide_link_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập Link'
            ),
            'is_max_length' => array(
                'error' => '[Tiếng Anh] Link tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
        
        // Image
        'slide_image' => array(
            'is_max_length' => array(
                'error' => 'URL hình slide tối đa là 500 ký tự',
                'input' => array(500)
            )
        ),
        
        // Status
        'slide_status' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn trạng thái'
            ),
            'is_radio' => array(
                'error' => 'Trạng thái phải là hiển thị hoặc không hiển thị'
            )
        ),
        
        // Position
        'slide_position' => array(
            'is_required' => array(
                'error' => 'Bạn chưa chọn vị trí'
            ),
            'in_slide_position' => array(
                'error' => 'Vị trí slide bạn chọn không tồn tại'
            )
        )
    );
    
}