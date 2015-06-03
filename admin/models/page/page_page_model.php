<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page_page_model
{
    private $__page = null;
            
    function __construct(){
        $this->__page = new_table('page', 'page');
    }
    
    // Add
    function add($data){
        $this->__page->clear();
        if ($this->__page->validate($data)){
            return $this->__page->insert($data);
        }
        return $this->__page->get_error();
    }
    
    // Check Author Edit
    function canEditPage($page_id)
    {
        $CI = & get_instance();
        
        $this->__page->clear();
        $this->__page->select('page_add_user_id,page_timer_date_time_int');
        $this->__page->where('page_id', $page_id);
        
        $post = $this->__page->execute()->get_result(0);
        
        if ($post)
        {
            if ($CI->auth->isAuthor() || $CI->auth->isContributor()){
                if ($post['page_add_user_id'] != $CI->auth->getItem('user_id')){
                    return false;
                }
            }
            
            if ($CI->auth->isContributor()){
                if ($post['page_timer_date_time_int'] != timer_private()){
                    return false;
                }
            }
            return $post;
        }
        return false;
    }
    
    // Edit
    function edit($data, $page_id)
    {
        $this->__page->clear();
        if ($this->__page->where('page_id', $page_id)->validate($data, 'update'))
        {
            return $this->__page->update($data);
        }
        return $this->__page->get_error();
    }
    
    // Delete
    function delete($list_id)
    {
        $this->__page->clear();
        $id_array = preg_split('/\s+/', $list_id);
        if (sizeof($id_array) > 10){
            return 2; // Max 
        }
        
        $CI = & get_instance();
        
        foreach ($id_array as $id)
        {
            $id = (int)$id;
            if ($id)
            {
                $this->__page->clear();
                
                $this->__page->select('page_add_user_id,page_timer_date_time_int,page_add_date_time_int');
                
                $post = $this->__page->where('page_id', $id)->execute()->get_result(0);
            
                if (!$post){
                    continue;
                }
                
                // Auth
                if ($CI->auth->isAuthor() || $CI->auth->isContributor()){
                    if ($post['page_add_user_id'] != $CI->auth->getItem('user_id')){
                        continue;
                    }
                }
                if ($CI->auth->isContributor()){
                    if ($post['page_timer_date_time_int'] != timer_private()){
                        continue;
                    }
                }
                $sub_path = date('Y/m/d/', $post['page_add_date_time_int']).$id;
                removeAllMedia('upload/page/images/'.$sub_path, 'upload/page/images/', $sub_path);
                removeAllMedia('upload/page/files/'.$sub_path, 'upload/page/files/', $sub_path);
                removeAllMedia('upload/page/flash/'.$sub_path, 'upload/page/flash/', $sub_path);
                removeAllMedia('upload/page/_thumbs/Images/'.$sub_path, 'upload/page/_thumbs/Images/', $sub_path);
                $this->__page->delete("page_id = $id");
            }
        }
        return true;
    }
    
    // Set Editting
    function updateEditting($page_id)
    {
        $CI = get_instance();
        $this->__page->clear();
        $this->__page->where('page_id', $page_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Get Detail
    function getDetail($filter = array()){
        $this->__page->clear();
        if (isset($filter['select'])){
            $this->__page->select($filter['select']);
        }
        if (isset($filter['page_id'])){
            $this->__page->where('page_id', $filter['page_id']);
        }
        return $this->__page->execute()->get_result(0);
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__page->clear();
        
        if (isset($filter['page_add_user_id']) && $filter['page_add_user_id']){
            $this->__page->where('page_add_user_id', (int)$filter['page_add_user_id']);
        }
        
        if (isset($filter['page_add_user_username_int']) && $filter['page_add_user_username_int']){
            $this->__page->where('page_add_user_username_int', $filter['page_add_user_username_int']);
        }
        
        if (isset($filter[lang_field('page_title_clear_utf8')]) && $filter[lang_field('page_title_clear_utf8')]){
            $this->__page->where("MATCH (".lang_field('page_title_clear_utf8').") AGAINST ('".boolean_mode($filter[lang_field('page_title_clear_utf8')])."' IN BOOLEAN MODE)");
        }
        
        if (isset($filter['page_id']) && $filter['page_id']){
            $this->__page->where('page_id', (int)$filter['page_id']);
        }
        
        if (isset($filter['page_status']) && $filter['page_status'] != '')
        {
             // Hiển thị
            if ($filter['page_status'] == '1'){
                $this->__page->where('page_timer_date_time_int', current_date_time_to_int(), '<=');
            }
            else if ($filter['page_status'] == '2'){ // Hẹn Giờ
                $this->__page->where('page_timer_date_time_int', current_date_time_to_int(), '>');
                $this->__page->where('page_timer_date_time_int', timer_private(), '<');
            }
            else{ // Ẩn
                $this->__page->where('page_timer_date_time_int', timer_private(), '=');
            }
        }
        
        return $this->__page->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__page->clear_select();
        
        if (isset($filter['select'])){
            $this->__page->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('page_title_first_char_ascii', 'page_id');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'page_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__page->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__page->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__page->execute()->get_result();
    }
}
?>
