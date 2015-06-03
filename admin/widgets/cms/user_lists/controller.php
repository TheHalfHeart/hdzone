<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_user_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('cms/cms_user_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'user_id'       => $this->input->get('user_id'),
            'user_username' => $this->input->get('user_username'),
            'user_email' => $this->input->get('user_email'),
            'user_status'   => $this->input->get('user_status'),
            'user_level'   => $this->input->get('user_level'),
            'user_add_date'   => $this->input->get('user_add_date'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'user_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit')
        );
        if ($filter['user_username']){
            $filter['user_username_int'] = username_hash($filter['user_username']);
        }
        if ($filter['user_email']){
            $filter['user_email_int'] = email_hash($filter['user_email']);
        }
        if ($filter['user_add_date']){
            $filter['user_add_date_int'] = strtotime($filter['user_add_date']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->cms_user_model->countList($filter));
        
        // Remove Filter From Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            unset($filter['page_add_user_id']);
        }
        
        // Remove Filter When Convert
        if (isset($filter['user_username_int'])){
            unset($filter['user_username_int']);
        }
        if (isset($filter['user_username_int'])){
            unset($filter['user_username_int']);
        }
        if (isset($filter['user_add_date_int'])){
            unset($filter['user_add_date_int']);
        }
        
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('cms/user_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'user_id,user_username,user_email,user_status,user_level,user_is_root,user_add_date_time_int,editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->cms_user_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'level'             => $this->auth->getLevelList(),
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
