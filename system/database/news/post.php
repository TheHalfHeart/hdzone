<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News_post_table extends MY_Table 
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_tb_name     = 'news_post';
    protected $_tb_alias    = 'post';
    protected $_tb_key      = 'post_id';
    protected $_tb_rules    = array(
        // Title
        'post_title_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Việt] Tiêu đề tối đa 500 ký tự'
            )
        ),
        'post_title_en' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Tiêu đề không được để trống'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Anh] Tiêu đề tối đa 500 ký tự'
            )
        ),
        // SLug
        'post_slug_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Việt] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Việt] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Việt] Slug tối đa 500 ký tự'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Việt] Slug này đã được sử dụng'
            )
        ),
        'post_slug_vi' => array(
            'is_required' => array(
                'error' => '[Tiếng Anh] Bạn chưa nhập slug'
            ),
            'is_slug' => array(
                'error' => '[Tiếng Anh] Slug gồm cách chữ số, dấu gạch dưới hoặc chữ thường không dấu'
            ),
            'is_max_length' => array(
                'input' => array(500),
                'error' => '[Tiếng Anh] Slug tối đa 500 ký tự'
            ),
            'is_unique' => array(
                'error' => '[Tiếng Anh] Slug này đã được sử dụng'
            )
        )
    );
    
    function removePostTags($id){
        $sql = 'UPDATE '.$this->_tb_name.' SET post_ref_tags_id = REPLACE (post_ref_tags_id, \''.$id.' \',\'\')'; 
        $this->query($sql);
    }
    
    function where_cate_id($id)
    {
        $str = '';
        new_table('news', 'cate')->getListCateIdById($id, $str);
        $str = trim($str);
        $arr = preg_split('/\s+/', trim($str));
        if ($str && $arr) {
            $this->begin();
            foreach ($arr as $key => $val) {
                if ($key > 0) {
                    $this->where_or('post_ref_cate_id', (int) $val);
                }
                $this->where('post_ref_cate_id', (int) $val);
            }
            $this->end();
        }
    }
    
}