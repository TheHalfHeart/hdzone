<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_actor_model
{
    private $__actor = null;
            
    function __construct(){
        $this->__actor = new_table('product', 'actor');
    }
    
    function edit($data, $actor_id)
    {
        $this->__actor->clear();
        if ($this->__actor->where('actor_id', $actor_id)->validate($data, 'update'))
        {
            if ($this->__actor->update($data)){
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'actor_sort'){
            $data = array(
                'actor_sort' => $value
            );
            if ($this->__actor->where('actor_id', $id)->validate($data)){
                $this->__actor->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    // Thêm mới
    function add($data)
    {
        $this->__actor->clear();
        if ($this->__actor->validate($data)){
            return $this->__actor->insert($data);
        }
        return $this->__actor->get_error();
    }
    
    // Cập nhật người edit
    function updateEditting($actor_id){
        $CI = get_instance();
        $this->__actor->clear();
        $this->__actor->where('actor_id', $actor_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Xóa chuyên mục
    // Nếu tổng số tin của chuyên mục này > 0 thì không được xóa
    function delete($list_id)
    {
        $this->__actor->clear();
       
        $total_post = new_table('product', 'post')->where("MATCH (post_ref_actor_id) AGAINST ('".boolean_mode($list_id)."' IN BOOLEAN MODE)")->count();
        
        if ($total_post > 0){
            return 2;
        }
        
        $actor = $this->__actor->select('actor_id, actor_add_date_time_int')->where('actor_id', $list_id)->execute()->get_result(0);
        
        if ($this->__actor->delete('actor_id = '.(int)$list_id)){
            
            $sub_path = date('Y/m/d/', $actor['actor_add_date_time_int']).$list_id;
            removeAllMedia('upload/product_actor/images/'.$sub_path, 'upload/product_actor/images/', $sub_path);
            removeAllMedia('upload/product_actor/files/'.$sub_path, 'upload/product_actor/files/', $sub_path);
            removeAllMedia('upload/product_actor/flash/'.$sub_path, 'upload/product_actor/flash/', $sub_path);
            removeAllMedia('upload/product_actor/_thumbs/Images/'.$sub_path, 'upload/product_actor/_thumbs/Images/', $sub_path);
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__actor->clear();
        if (isset($filter['select'])){
            $this->__actor->select($filter['select']);
        }
        if (isset($filter['actor_id'])){
            $this->__actor->where('actor_id', $filter['actor_id']);
        }
        return $this->__actor->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__actor->clear();
        if (isset($filter['actor_id']) && $filter['actor_id']){
            $this->__actor->where('actor_id', $filter['actor_id']);
        }
        if (isset($filter[lang_field('actor_title_short')]) && $filter[lang_field('actor_title_short')]){
            $this->__actor->where(lang_field('actor_title_short'), $filter[lang_field('actor_title_short')]);
        }
        if (isset($filter['actor_add_user_username_int']) && $filter['actor_add_user_username_int']){
            $this->__actor->where('actor_add_user_username_int', $filter['actor_add_user_username_int']);
        }
        return $this->__actor->count();
    }
    
    function clear(){
        $this->__actor->clear();
    }
    
    function getList($filter = array())
    {
        $this->__actor->clear_select();
        
        if (isset($filter['select'])){
            $this->__actor->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type'])) {
            $sort_by = array('actor_id', 'actor_sort', 'actor_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'actor_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__actor->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__actor->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__actor->execute()->get_result();
    }
}
?>
