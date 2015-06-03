<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_post_model
{
    private $__post = null;
            
    function __construct(){
        $this->__post = new_table('news', 'post');
    }
    
    // Check Author Edit
    function canEditPost($post_id)
    {
        $CI = & get_instance();
        
        $this->__post->clear();
        $this->__post->select('post_ref_tags_id, post_ref_cate_id,post_timer_date_time_int,post_add_user_id');
        $this->__post->where('post_id', $post_id);
        
        $post = $this->__post->execute()->get_result(0);
        
        if ($post)
        {
            if ($CI->auth->isAuthor() || $CI->auth->isContributor()){
                if ($post['post_add_user_id'] != $CI->auth->getItem('user_id')){
                    return false;
                }
            }
            
            if ($CI->auth->isContributor()){
                if ($post['post_timer_date_time_int'] != timer_private()){
                    return false;
                }
            }
            return $post;
        }
        return false;
    }
    
    function quick_edit($field, $value, $id)
    {
        $this->__post->clear();
        
        $post = $this->__post->where('post_id', $id)->execute()->get_result(0);
        
        $this->__post->clear();
        
        if (!$post){
            return false;
        }
        
        if ($field == 'post_ref_cate_id')
        {
            $cate_new = new_table('news', 'cate')->select('*')->where('cate_id', $value)->execute()->get_result(0);
            
            $data = array(
                'post_ref_cate_id' => ($cate_new) ? $cate_new['cate_id'] : '0'
            );
            
            if ($cate_new)
            {
                lang_field_data($data, $cate_new, 'post_ref_cate_title_short', 'cate_title_short');
                lang_field_data($data, $cate_new, 'post_ref_cate_slug', 'cate_slug');
                lang_field_data($data, $cate_new, 'post_ref_cate_slug_int', 'cate_slug_int');
            }
            $this->edit($data, $id, $post);
            return true;
        }
        return false;
    }
    
    function edit($data, $post_id, $current_post)
    {
        $this->__post->clear();
        if ($this->__post->where('post_id',$post_id)->validate($data, 'update'))
        {
            if ($current_post)
            {
                // Check Category
                if (isset($data['post_ref_cate_id']))
                {
                    if ($data['post_ref_cate_id'] == '0'){
                        
                    }
                    else 
                    {
                        $cate = new_table('news', 'cate')->select('*')->where('cate_id', $data['post_ref_cate_id'])->execute()->get_result(0);
                        if (!$cate)
                        {
                            return 1; // Cate Not Found
                        }
                        
                        lang_field_data($data, $cate, 'post_ref_cate_title_short', 'cate_title_short');
                        lang_field_data($data, $cate, 'post_ref_cate_slug', 'cate_slug');
                        lang_field_data($data, $cate, 'post_ref_cate_slug_int', 'cate_slug_int');
                    }
                }
                
                if ($this->__post->update($data))
                {
                    // Update Total Post Category
                    if (isset($data['post_ref_cate_id']) && $data['post_ref_cate_id'] != $current_post['post_ref_cate_id'])
                    {
                        // Tăng total cate lên 1
                        new_table('news', 'cate')->addTotalPost('cate_id = '.(int)$data['post_ref_cate_id']);
                        
                        // Giảm total cate xuống 1
                        new_table('news', 'cate')->removeTotalPost('cate_id = '.(int)$current_post['post_ref_cate_id']);
                    }
                    
                    // Update Total Tags
                    if (isset($data['post_ref_tags_id']) && $data['post_ref_tags_id'] != $current_post['post_ref_tags_id'])
                    {
                        // Update All Old Post
                        if ($data['post_ref_tags_id']){
                            foreach (preg_split('/\s+/', $data['post_ref_tags_id']) as $val){
                                $val = (int)$val;
                                if ($val){
                                    new_table('news', 'tags')->addTotalPost('tags_id = '.$val);
                                }
                            }
                        }
                        
                        if ($current_post['post_ref_tags_id']){
                            foreach (preg_split('/\s+/', $current_post['post_ref_tags_id']) as $val){
                                $val = (int)$val;
                                if ($val){
                                    new_table('news', 'tags')->removeTotalPost('tags_id = '.$val);
                                }
                            }
                        }
                    }
                    return 2;
                }
            }
        }
        
        return $this->__post->get_error();
    }
    
    function add($data)
    {
        $this->__post->clear();
        if ($this->__post->validate($data)){
            return $this->__post->insert($data);
        }
        return $this->__post->get_error();
    }
    
    function delete($list_id)
    {
        $id_array = preg_split('/\s+/', $list_id);
        
        if (sizeof($id_array) > 5){
            return 2; // Max Record
        }
        
        $CI = & get_instance();
        
        foreach ($id_array as $id)
        {
            $id = (int)$id;
            
            $this->__post->clear();
            
            $this->__post->select('post_ref_tags_id,post_ref_cate_id,post_add_user_id,post_timer_date_time_int,post_add_date_time_int');
            
            $post = $this->__post->where('post_id', $id)->execute()->get_result(0);
            
            if (!$post){
                continue;
            }
            
            // Auth
            if ($CI->auth->isAuthor() || $CI->auth->isContributor()){
                if ($post['post_add_user_id'] != $CI->auth->getItem('user_id')){
                    continue;
                }
            }
            if ($CI->auth->isContributor()){
                if ($post['post_timer_date_time_int'] != timer_private()){
                    continue;
                }
            }
            
            if ($this->__post->delete("post_id = $id", true))
            {
                if ($post)
                {
                    $sub_path = date('Y/m/d/', $post['post_add_date_time_int']).$id;
                    removeAllMedia('upload/news/images/'.$sub_path, 'upload/news/images/', $sub_path);
                    removeAllMedia('upload/news/files/'.$sub_path, 'upload/news/files/', $sub_path);
                    removeAllMedia('upload/news/flash/'.$sub_path, 'upload/news/flash/', $sub_path);
                    removeAllMedia('upload/news/_thumbs/Images/'.$sub_path, 'upload/news/_thumbs/Images/', $sub_path);
                    
                    // Update Total Post
                    if ($post['post_ref_cate_id']){
                        new_table('news', 'cate')->removeTotalPost('cate_id = '.$post['post_ref_cate_id']);
                    }
                    
                    // Update Total Tags
                    foreach (preg_split('/\s+/', $post['post_ref_tags_id']) as $tag){
                        $tag = (int)$tag;
                        if ($tag){
                            new_table('news', 'tags')->removeTotalPost("tags_id=$tag");
                        }
                    }
                }
            }
        }
        return true;
    }
    
    function getDetail($filter = array()){
        $this->__post->clear();
        if (isset($filter['select'])){
            $this->__post->select($filter['select']);
        }
        if (isset($filter['post_id'])){
            $this->__post->where('post_id', $filter['post_id']);
        }
        return $this->__post->execute()->get_result(0);
    }
    
    function updateEditting($post_id)
    {
        $CI = get_instance();
        $this->__post->clear();
        $this->__post->where('post_id', $post_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function countList($filter = array())
    {
        $this->__post->clear();
        
        // Title
        if (isset($filter[lang_field('post_title_clear_utf8')]) && $filter[lang_field('post_title_clear_utf8')]){
            $this->__post->where("MATCH (".lang_field('post_title_clear_utf8').") AGAINST ('".boolean_mode($filter[lang_field('post_title_clear_utf8')])."' IN BOOLEAN MODE)");
        }
        
        // Author
        if (isset($filter['post_add_user_username_int']) && $filter['post_add_user_username_int']){
            $this->__post->where('post_add_user_username_int', $filter['post_add_user_username_int']);
        }
        
        // Post Id
        if (isset($filter['post_id']) && $filter['post_id']){
            $this->__post->where('post_id', (int)$filter['post_id']);
        }
        
        // Ref
        if (isset($filter['post_ref_cate_id']) && (string)$filter['post_ref_cate_id'] != ''){
            $this->__post->where_cate_id((int)$filter['post_ref_cate_id']);
        }
        
        // Tags
        if (isset($filter['post_ref_tags_id']) && $filter['post_ref_tags_id']){
            $this->__post->where("MATCH (post_ref_tags_id) AGAINST ('".boolean_mode($filter['post_ref_tags_id'])."' IN BOOLEAN MODE)");
        }
        
        // Status
        if (isset($filter['post_status']) && $filter['post_status'] != '')
        {
            // Hiển thị
            if ($filter['post_status'] == '1'){
                $this->__post->where('post_timer_date_time_int', current_date_time_to_int(), '<=');
            }
            else if ($filter['post_status'] == '2'){ // Hẹn Giờ
                $this->__post->where('post_timer_date_time_int', current_date_time_to_int(), '>');
                $this->__post->where('post_timer_date_time_int', timer_private(), '<');
            }
            else{ // Ẩn
                $this->__post->where('post_timer_date_time_int', timer_private(), '=');
            }
        }
        
        return $this->__post->count();
    }
    
    function getList($filter = array())
    {
        $this->__post->clear_select();
        
        if (isset($filter['select'])){
            $this->__post->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array(lang_field('post_title_first_char_ascii'), 'post_id', 'post_total_comment', 'post_add_date_time_int', 'post_add_date_int', 'post_timer_date_time_int', 'post_timer_date_int');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'post_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__post->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__post->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__post->execute()->get_result();
    }
}
?>
