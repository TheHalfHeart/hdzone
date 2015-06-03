<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Lưu ý: Trong controller có phân quyền
 *  + Với admin và editor thì có đầy đủ quyền
 *  + Với Author được thêm, xóa, sửa bài chính họ
 *  + Với Contributor chỉ được thêm xóa, sửa những bài họ gửi lên và chưa được kiểm duyệt
 * Khi chỉnh phân quyền chú ý đến các phần sau:
 *  + Phần Controller
 *  + Phần View (Html và Javascript)
 */
class Product_post_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('product/product_post_model');
        $this->load->model('product/product_cate_model');
        $this->load->model('product/product_brand_model');
        $this->load->model('product/product_manu_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'post_id'       => $this->input->get('post_id'),
            lang_field('post_title')    => $this->input->get(lang_field('post_title')),
            'post_add_user_username' => $this->input->get('post_add_user_username'),
            'post_status'       => $this->input->get('post_status'),
            'post_ref_cate_id'  => $this->input->get('post_ref_cate_id'),
            'post_ref_brand_id'  => $this->input->get('post_ref_brand_id'),
            'post_ref_manu_id'  => $this->input->get('post_ref_manu_id'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'post_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        if ($filter[lang_field('post_title')]){
            $filter[lang_field('post_title_clear_utf8')] = clear_unicode($filter[lang_field('post_title')], ' ');
        }
        
        if ($filter['post_add_user_username']){
            $filter['post_add_user_username_int'] = username_hash($filter['post_add_user_username']);
        }
        
        // Check Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            $filter['post_add_user_id'] = $this->auth->getItem('user_id');
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_post_model->countList($filter));
        
        // Remove Filter From Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            unset($filter['post_add_user_id']);
        }
        
        // Remove Filter When Convert
        if (isset($filter['post_add_user_username_int'])){
            unset($filter['post_add_user_username_int']);
        }
        if (isset($filter[lang_field('post_title_clear_utf8')])){
            unset($filter[lang_field('post_title_clear_utf8')]);
        }
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('product/post_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'post_id,'.lang_field('post_title').','.lang_field('post_ref_cate_title_short').','.lang_field('post_ref_brand_title_short').','.lang_field('post_ref_manu_title_short').',post_add_user_username,post_timer_date_time_int,editting_date_time_int,editting_user_username,editting_token,post_ref_cate_id,post_ref_brand_id,post_ref_manu_id';
        
        // List Data
        $data = $this->product_post_model->getList($filter);
        
        // List Cate
        $cate = $this->product_cate_model->getList(array(
            'select' => 'cate_id,'.lang_field('cate_title_short').',cate_ref_parent_id',
            'order_by' => lang_field('cate_title_short'),
            'order_by' => 'asc'
        ));
        
        // List Cate
        $brand = $this->product_brand_model->getList(array(
            'select' => 'brand_id,'.lang_field('brand_title_short').',brand_ref_parent_id',
            'order_by' => lang_field('brand_title_short'),
            'order_by' => 'asc'
        ));
        
        // List Cate
        $manu = $this->product_manu_model->getList(array(
            'select' => 'manu_id,'.lang_field('manu_title_short').',manu_ref_parent_id',
            'order_by' => lang_field('manu_title_short'),
            'order_by' => 'asc'
        ));
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'cate'              => $cate,
            'brand'             => $brand,
            'manu'              => $manu,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
