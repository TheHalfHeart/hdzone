<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 Chỉ có admin và editor mới vào được
 */
class Customer_customer_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('customer/customer_customer_model');
        $this->load->library('admin/pagination');
       
        // Get Filter
        $filter = array
        (
            'customer_id'       => $this->input->get('customer_id'),
            'customer_username' => $this->input->get('customer_username'),
            'customer_fullname' => $this->input->get('customer_fullname'),
            'customer_email'    => $this->input->get('customer_email'),
            'customer_group'    => $this->input->get('customer_group'),
            'customer_phone'    => $this->input->get('customer_phone'),
            'customer_address'  => $this->input->get('customer_address'),
            'customer_status'   => $this->input->get('customer_status'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'customer_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        if ($filter['customer_username']){
            $filter['customer_username_int'] = username_hash($filter['customer_username']);
        }
        
        if ($filter['customer_email']){
            $filter['customer_email_int'] = email_hash($filter['customer_email']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->customer_customer_model->countList($filter));
        
        // Remove Filter When Convert
        if (isset($filter['customer_username_int'])){
            unset($filter['customer_username_int']);
        }
        
        // Remove Filter When Convert
        if (isset($filter['customer_email_int'])){
            unset($filter['customer_email_int']);
        }
        
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('customer/customer_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'customer_id, customer_username, customer_fullname, customer_email, customer_total_order, customer_address, customer_phone, customer_status, customer_group, editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->customer_customer_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
