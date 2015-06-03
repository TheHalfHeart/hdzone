<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 Chỉ có admin và editor mới vào được
 */
class Customer_order_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('customer/customer_order_model');
        $this->load->library('admin/pagination');
       
        // Get Filter
        $filter = array
        (
            'order_id'       => $this->input->get('order_id'),
            'order_status'       => $this->input->get('order_status'),
            'order_customer_username' => $this->input->get('order_customer_username'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'order_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        if ($filter['order_customer_username']){
            $filter['order_customer_username_int'] = username_hash($filter['order_customer_username']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->customer_order_model->countList($filter));
        
        // Remove Filter When Convert
        if (isset($filter['order_customer_username_int'])){
            unset($filter['order_customer_username_int']);
        }
        
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('customer/order_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'order_id, order_title, order_customer_username, order_add_date_time_int, order_price, order_status, editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->customer_order_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }
}
?>