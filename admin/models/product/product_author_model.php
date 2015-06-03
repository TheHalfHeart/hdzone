<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_author_model
{
    private $__author = null;
            
    function __construct(){
        $this->__author = new_table('product', 'author');
    }
    
    function edit($data, $author_id)
    {
        $this->__author->clear();
        if ($this->__author->where('author_id', $author_id)->validate($data, 'update'))
        {
            if ($this->__author->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'author_sort'){
            $data = array(
                'author_sort' => $value
            );
            if ($this->__author->where('author_id', $id)->validate($data)){
                $this->__author->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__author->clear();
        if ($this->__author->validate($data)){
            return $this->__author->insert($data);
        }
        return $this->__author->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($author_id){
        $CI = get_instance();
        $this->__author->clear();
        $this->__author->where('author_id', $author_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__author->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_author_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $author = $this->__author->select('author_id, author_add_date_time_int')->where('author_id', $list_id)->execute()->get_result(0);
        
        if ($this->__author->delete('author_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $author['author_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_author/images/'.$sub_path, 'upload/product_author/images/', $sub_path);
            removeAllMedia('upload/product_author/files/'.$sub_path, 'upload/product_author/files/', $sub_path);
            removeAllMedia('upload/product_author/flash/'.$sub_path, 'upload/product_author/flash/', $sub_path);
            removeAllMedia('upload/product_author/_thumbs/Images/'.$sub_path, 'upload/product_author/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__author->clear();
        if (isset($filter['select'])){
            $this->__author->select($filter['select']);
        }
        if (isset($filter['author_id'])){
            $this->__author->where('author_id', $filter['author_id']);
        }
        return $this->__author->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__author->clear();
        if (isset($filter['author_id']) && $filter['author_id']){
            $this->__author->where('author_id', $filter['author_id']);
        }
        if (isset($filter[lang_field('author_title_short')]) && $filter[lang_field('author_title_short')]){
            $this->__author->where(lang_field('author_title_short'), $filter[lang_field('author_title_short')]);
        }
        if (isset($filter['author_add_user_username_int']) && $filter['author_add_user_username_int']){
            $this->__author->where('author_add_user_username_int', $filter['author_add_user_username_int']);
        }
        return $this->__author->count();
    }
    
    function clear(){
        $this->__author->clear();
    }
    
    function getList($filter = array())
    {
        $this->__author->clear_select();
        
        if (isset($filter['select'])){
            $this->__author->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('author_id', 'author_sort', 'author_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'author_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__author->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__author->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__author->execute()->get_result();
    }
}
?>
