<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Slide_slide_model
{
    private $__slide = null;
            
    function __construct(){
        $this->__slide = new_table('slide', 'slide');
    }
    
    // Add
    function add($data){
        $this->__slide->clear();
        if ($this->__slide->validate($data)){
            return $this->__slide->insert($data);
        }
        return $this->__slide->get_error();
    }
    
    // Edit
    function edit($data, $slide_id)
    {
        $this->__slide->clear();
        if ($this->__slide->where('slide_id', $slide_id)->validate($data, 'update'))
        {
            return $this->__slide->update($data);
        }
        return $this->__slide->get_error();
    }
    
    // Delete
    function delete($list_id)
    {
        $this->__slide->clear();
        $id_array = preg_split('/\s+/', $list_id);
        if (sizeof($id_array) > 10){
            return 2; // Max 
        }
        
        foreach ($id_array as $id)
        {
            $id = (int)$id;
            if ($id)
            {
                // Delete All Image Media File
                $this->__slide->clear();
                $slide = $this->__slide->select('slide_add_date_time_int')->where('slide_id', $id)->execute()->get_result(0);
                if ($slide)
                {
                    $sub_path = date('Y/m/d/', $slide['slide_add_date_time_int']).$id;
                    removeAllMedia('upload/slide/images/'.$sub_path, 'upload/slide/images/', $sub_path);
                    removeAllMedia('upload/slide/files/'.$sub_path, 'upload/slide/files/', $sub_path);
                    removeAllMedia('upload/slide/flash/'.$sub_path, 'upload/slide/flash/', $sub_path);
                    removeAllMedia('upload/slide/_thumbs/Images/'.$sub_path, 'upload/slide/_thumbs/Images/', $sub_path);
                    $this->__slide->clear();
                    $this->__slide->delete("slide_id = $id");
                }
            }
        }
        return true;
    }
    
    // Set Editting
    function updateEditting($slide_id)
    {
        $CI = get_instance();
        $this->__slide->clear();
        $this->__slide->where('slide_id', $slide_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    // Get Detail
    function getDetail($filter = array()){
        $this->__slide->clear();
        if (isset($filter['select'])){
            $this->__slide->select($filter['select']);
        }
        if (isset($filter['slide_id'])){
            $this->__slide->where('slide_id', $filter['slide_id']);
        }
        return $this->__slide->execute()->get_result(0);
    }
    
    // Count List
    function countList($filter = array())
    {
        $this->__slide->clear();
        
        if (isset($filter['slide_position']) && (string)$filter['slide_position'] != ''){
            $this->__slide->where('slide_position', (int)$filter['slide_position']);
        }
        
        if (isset($filter['slide_id']) && (string)$filter['slide_id'] != ''){
            $this->__slide->where('slide_id', (int)$filter['slide_id']);
        }
        
        if (isset($filter[lang_field('slide_title_clear_utf8')]) && $filter[lang_field('slide_title_clear_utf8')]){
            $this->__slide->where("MATCH (".lang_field('slide_title_clear_utf8').") AGAINST ('".boolean_mode($filter[lang_field('slide_title_clear_utf8')])."' IN BOOLEAN MODE)");
        }
        
        if (isset($filter['slide_status']) && $filter['slide_status'] != '')
        {
             // Hiển thị
            if ($filter['slide_status'] == '1'){
                $this->__slide->where('slide_timer_date_time_int', current_date_time_to_int(), '<=');
            }
            else if ($filter['slide_status'] == '2'){ // Hẹn Giờ
                $this->__slide->where('slide_timer_date_time_int', current_date_time_to_int(), '>');
                $this->__slide->where('slide_timer_date_time_int', timer_private(), '<');
            }
            else{ // Ẩn
                $this->__slide->where('slide_timer_date_time_int', timer_private(), '=');
            }
        }
        
        return $this->__slide->count();
    }
    
    // Get List
    function getList($filter = array())
    {
        $this->__slide->clear_select();
        
        if (isset($filter['select'])){
            $this->__slide->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('slide_id');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'slide_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $filter['order_type'] = 'desc';
            }
            
            $this->__slide->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__slide->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__slide->execute()->get_result();
    }
}
?>
