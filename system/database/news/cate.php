<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News_cate_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'news_cate';
    protected $_tb_alias    = 'cate';
    protected $_tb_key      = 'cate_id';
    protected $_tb_rules    = array
    (
        // Title
        'cate_title_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Việt] Tiêu đề tối đa 250 ký tự'
            )
        ),
        'cate_title_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Anh] Tiêu đề tối đa 250 ký tự'
            )
        ),
        // Title_short
        'cate_title_short_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Tiêu đề ngắn không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Việt] Tiêu đề ngắn tối đa 250 ký tự'
            )
        ),
        'cate_title_short_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Tiêu đề ngắn không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(255),
                'error' => '[Tiếng Anh] Tiêu đề ngắn tối đa 250 ký tự'
            )
        ),
        // SLug
        'cate_slug_vi' => array(
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
        'cate_slug_en' => array(
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
    
    function addTotalPost($where){
        $sql = 'UPDATE '.$this->_tb_name.' SET cate_total_post = cate_total_post + 1 WHERE '.$where; 
        $this->query($sql);
    }
    
    function removeTotalPost($where){
        $sql = 'UPDATE '.$this->_tb_name.' SET cate_total_post = cate_total_post - 1 WHERE '.$where; 
        $this->query($sql);
    }
    
    function getListCateIdById($id = 0, &$str = '')
    {
        
        $this->clear();
        $str .= $id . ' ';
        $cate = $this->select('cate_id, cate_ref_parent_id')->where('cate_ref_parent_id', $id)->execute()->get_result();
        if ($cate){
            foreach ($cate as $item)
            {
                $this->getListCateIdById($item['cate_id'], $str);
            }
        }
    }
}