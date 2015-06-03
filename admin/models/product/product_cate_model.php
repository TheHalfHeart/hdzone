<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_cate_model
{
    private $__cate = null;
            
    function __construct(){
        $this->__cate = new_table('product', 'cate');
    }
    
    function edit($data, $cate_id)
    {
        $this->__cate->clear();
        if ($this->__cate->where('cate_id', $cate_id)->validate($data, 'update'))
        {
            if ($this->__cate->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'cate_sort'){
            $data = array(
                'cate_sort' => $value
            );
            if ($this->__cate->where('cate_id', $id)->validate($data)){
                $this->__cate->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__cate->clear();
        if ($this->__cate->validate($data)){
            return $this->__cate->insert($data);
        }
        return $this->__cate->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($cate_id){
        $CI = get_instance();
        $this->__cate->clear();
        $this->__cate->where('cate_id', $cate_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__cate->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_cate_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $cate = $this->__cate->select('cate_id, cate_add_date_time_int')->where('cate_id', $list_id)->execute()->get_result(0);
        
        if ($this->__cate->delete('cate_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $cate['cate_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_cate/images/'.$sub_path, 'upload/product_cate/images/', $sub_path);
            removeAllMedia('upload/product_cate/files/'.$sub_path, 'upload/product_cate/files/', $sub_path);
            removeAllMedia('upload/product_cate/flash/'.$sub_path, 'upload/product_cate/flash/', $sub_path);
            removeAllMedia('upload/product_cate/_thumbs/Images/'.$sub_path, 'upload/product_cate/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__cate->clear();
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        if (isset($filter['cate_id'])){
            $this->__cate->where('cate_id', $filter['cate_id']);
        }
        return $this->__cate->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__cate->clear();
        if (isset($filter['cate_id']) && $filter['cate_id']){
            $this->__cate->where('cate_id', $filter['cate_id']);
        }
        if (isset($filter[lang_field('cate_title_short')]) && $filter[lang_field('cate_title_short')]){
            $this->__cate->where(lang_field('cate_title_short'), $filter[lang_field('cate_title_short')]);
        }
        if (isset($filter['cate_add_user_username_int']) && $filter['cate_add_user_username_int']){
            $this->__cate->where('cate_add_user_username_int', $filter['cate_add_user_username_int']);
        }
        return $this->__cate->count();
    }
    
    function clear(){
        $this->__cate->clear();
    }
    
    function getList($filter = array())
    {
        $this->__cate->clear_select();
        
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('cate_id', 'cate_sort', 'cate_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'cate_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__cate->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__cate->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__cate->execute()->get_result();
    }
}
?>
