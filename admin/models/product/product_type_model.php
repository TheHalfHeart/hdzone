<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_type_model
{
    private $__type = null;
            
    function __construct(){
        $this->__type = new_table('product', 'type');
    }
    
    function edit($data, $type_id)
    {
        $this->__type->clear();
        if ($this->__type->where('type_id', $type_id)->validate($data, 'update'))
        {
            if ($this->__type->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'type_sort'){
            $data = array(
                'type_sort' => $value
            );
            if ($this->__type->where('type_id', $id)->validate($data)){
                $this->__type->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__type->clear();
        if ($this->__type->validate($data)){
            return $this->__type->insert($data);
        }
        return $this->__type->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($type_id){
        $CI = get_instance();
        $this->__type->clear();
        $this->__type->where('type_id', $type_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__type->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_type_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $type = $this->__type->select('type_id, type_add_date_time_int')->where('type_id', $list_id)->execute()->get_result(0);
        
        if ($this->__type->delete('type_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $type['type_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_type/images/'.$sub_path, 'upload/product_type/images/', $sub_path);
            removeAllMedia('upload/product_type/files/'.$sub_path, 'upload/product_type/files/', $sub_path);
            removeAllMedia('upload/product_type/flash/'.$sub_path, 'upload/product_type/flash/', $sub_path);
            removeAllMedia('upload/product_type/_thumbs/Images/'.$sub_path, 'upload/product_type/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__type->clear();
        if (isset($filter['select'])){
            $this->__type->select($filter['select']);
        }
        if (isset($filter['type_id'])){
            $this->__type->where('type_id', $filter['type_id']);
        }
        return $this->__type->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__type->clear();
        if (isset($filter['type_id']) && $filter['type_id']){
            $this->__type->where('type_id', $filter['type_id']);
        }
        if (isset($filter[lang_field('type_title_short')]) && $filter[lang_field('type_title_short')]){
            $this->__type->where(lang_field('type_title_short'), $filter[lang_field('type_title_short')]);
        }
        if (isset($filter['type_add_user_username_int']) && $filter['type_add_user_username_int']){
            $this->__type->where('type_add_user_username_int', $filter['type_add_user_username_int']);
        }
        return $this->__type->count();
    }
    
    function clear(){
        $this->__type->clear();
    }
    
    function getList($filter = array())
    {
        $this->__type->clear_select();
        
        if (isset($filter['select'])){
            $this->__type->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('type_id', 'type_sort', 'type_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'type_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__type->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__type->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__type->execute()->get_result();
    }
}
?>
