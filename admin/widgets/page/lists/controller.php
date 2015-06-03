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
class Page_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('page/page_page_model');
        $this->load->library('admin/pagination');
       
        // Get Filter
        $filter = array
        (
            'page_id'       => $this->input->get('page_id'),
            lang_field('page_title') => $this->input->get(lang_field('page_title')),
            'page_add_user_username' => $this->input->get('page_add_user_username'),
            'page_status'   => $this->input->get('page_status'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'page_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        if ($filter[lang_field('page_title')]){
            $filter[lang_field('page_title_clear_utf8')] = title_clear_utf8($filter[lang_field('page_title')]);
        }
        
        if ($filter['page_add_user_username']){
            $filter['page_add_user_username_int'] = username_hash($filter['page_add_user_username']);
        }
        
        // Check Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            $filter['page_add_user_id'] = $this->auth->getItem('user_id');
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->page_page_model->countList($filter));
        
        // Remove Filter From Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            unset($filter['page_add_user_id']);
        }
        
        // Remove Filter When Convert
        if (isset($filter['page_add_user_username_int'])){
            unset($filter['page_add_user_username_int']);
        }
        if (isset($filter[lang_field('page_title_clear_utf8')])){
            unset($filter[lang_field('page_title_clear_utf8')]);
        }
        
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('page/lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = lang_field('page_title').',page_id,page_add_user_username, page_timer_date_time_int, editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->page_page_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
