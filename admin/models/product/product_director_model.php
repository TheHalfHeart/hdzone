<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_director_model
{
    private $__director = null;
            
    function __construct(){
        $this->__director = new_table('product', 'director');
    }
    
    function edit($data, $director_id)
    {
        $this->__director->clear();
        if ($this->__director->where('director_id', $director_id)->validate($data, 'update'))
        {
            if ($this->__director->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'director_sort'){
            $data = array(
                'director_sort' => $value
            );
            if ($this->__director->where('director_id', $id)->validate($data)){
                $this->__director->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__director->clear();
        if ($this->__director->validate($data)){
            return $this->__director->insert($data);
        }
        return $this->__director->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($director_id){
        $CI = get_instance();
        $this->__director->clear();
        $this->__director->where('director_id', $director_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__director->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_director_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $director = $this->__director->select('director_id, director_add_date_time_int')->where('director_id', $list_id)->execute()->get_result(0);
        
        if ($this->__director->delete('director_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $director['director_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_director/images/'.$sub_path, 'upload/product_director/images/', $sub_path);
            removeAllMedia('upload/product_director/files/'.$sub_path, 'upload/product_director/files/', $sub_path);
            removeAllMedia('upload/product_director/flash/'.$sub_path, 'upload/product_director/flash/', $sub_path);
            removeAllMedia('upload/product_director/_thumbs/Images/'.$sub_path, 'upload/product_director/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__director->clear();
        if (isset($filter['select'])){
            $this->__director->select($filter['select']);
        }
        if (isset($filter['director_id'])){
            $this->__director->where('director_id', $filter['director_id']);
        }
        return $this->__director->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__director->clear();
        if (isset($filter['director_id']) && $filter['director_id']){
            $this->__director->where('director_id', $filter['director_id']);
        }
        if (isset($filter[lang_field('director_title_short')]) && $filter[lang_field('director_title_short')]){
            $this->__director->where(lang_field('director_title_short'), $filter[lang_field('director_title_short')]);
        }
        if (isset($filter['director_add_user_username_int']) && $filter['director_add_user_username_int']){
            $this->__director->where('director_add_user_username_int', $filter['director_add_user_username_int']);
        }
        return $this->__director->count();
    }
    
    function clear(){
        $this->__director->clear();
    }
    
    function getList($filter = array())
    {
        $this->__director->clear_select();
        
        if (isset($filter['select'])){
            $this->__director->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('director_id', 'director_sort', 'director_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'director_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__director->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__director->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__director->execute()->get_result();
    }
}
?>
