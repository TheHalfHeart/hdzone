<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_manu_model
{
    private $__manu = null;
            
    function __construct(){
        $this->__manu = new_table('product', 'manu');
    }
    
    function edit($data, $manu_id)
    {
        $this->__manu->clear();
        if ($this->__manu->where('manu_id', $manu_id)->validate($data, 'update'))
        {
            if ($this->__manu->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'manu_sort'){
            $data = array(
                'manu_sort' => $value
            );
            if ($this->__manu->where('manu_id', $id)->validate($data)){
                $this->__manu->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__manu->clear();
        if ($this->__manu->validate($data)){
            return $this->__manu->insert($data);
        }
        return $this->__manu->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($manu_id){
        $CI = get_instance();
        $this->__manu->clear();
        $this->__manu->where('manu_id', $manu_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__manu->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_manu_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $manu = $this->__manu->select('manu_id, manu_add_date_time_int')->where('manu_id', $list_id)->execute()->get_result(0);
        
        if ($this->__manu->delete('manu_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $manu['manu_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_manu/images/'.$sub_path, 'upload/product_manu/images/', $sub_path);
            removeAllMedia('upload/product_manu/files/'.$sub_path, 'upload/product_manu/files/', $sub_path);
            removeAllMedia('upload/product_manu/flash/'.$sub_path, 'upload/product_manu/flash/', $sub_path);
            removeAllMedia('upload/product_manu/_thumbs/Images/'.$sub_path, 'upload/product_manu/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__manu->clear();
        if (isset($filter['select'])){
            $this->__manu->select($filter['select']);
        }
        if (isset($filter['manu_id'])){
            $this->__manu->where('manu_id', $filter['manu_id']);
        }
        return $this->__manu->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__manu->clear();
        if (isset($filter['manu_id']) && $filter['manu_id']){
            $this->__manu->where('manu_id', $filter['manu_id']);
        }
        if (isset($filter[lang_field('manu_title_short')]) && $filter[lang_field('manu_title_short')]){
            $this->__manu->where(lang_field('manu_title_short'), $filter[lang_field('manu_title_short')]);
        }
        if (isset($filter['manu_add_user_username_int']) && $filter['manu_add_user_username_int']){
            $this->__manu->where('manu_add_user_username_int', $filter['manu_add_user_username_int']);
        }
        return $this->__manu->count();
    }
    
    function clear(){
        $this->__manu->clear();
    }
    
    function getList($filter = array())
    {
        $this->__manu->clear_select();
        
        if (isset($filter['select'])){
            $this->__manu->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('manu_id', 'manu_sort', 'manu_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'manu_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__manu->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__manu->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__manu->execute()->get_result();
    }
}
?>
