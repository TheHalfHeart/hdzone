<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_voucher_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('customer/customer_voucher_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'customer_username'     => $this->input->get('customer_username'),
            'voucher_code'     => $this->input->get('voucher_code'),
            'voucher_price'     => $this->input->get('voucher_price'),
            'voucher_price_current' => $this->input->get('voucher_price_current'),
            'voucher_active_date'   => $this->input->get('voucher_active_date'),
            'voucher_end_date'      => $this->input->get('voucher_end_date'),
            'voucher_status'        => $this->input->get('voucher_status'),
            'voucher_add_user_username' => $this->input->get('voucher_add_user_username'),
            'order_by'      => $this->input->get('order_by') ? $this->input->get('order_by') : 'voucher_id',
            'order_type'    => $this->input->get('order_type') ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        if ($filter['customer_username']){
            $filter['customer_username_int'] = username_hash($filter['customer_username']);
        }
        
        if ($filter['voucher_add_user_username']){
            $filter['voucher_add_user_username_int'] = username_hash($filter['voucher_add_user_username']);
        }
        
        if ($filter['voucher_active_date']){
            $filter['voucher_active_date_int']  = strtotime($filter['voucher_active_date']);
        }
        
        if ($filter['voucher_end_date']){
            $filter['voucher_end_date_int']  = strtotime($filter['voucher_end_date']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->customer_voucher_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('customer/voucher_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Remove Filter
        if (isset($filter['voucher_add_user_username_int'])){
            unset($filter['voucher_add_user_username_int']);
        }
        
        
        if (isset($filter['customer_username_int'])){
            unset($filter['customer_username_int']);
        }
        
        if (isset($filter['voucher_active_date_int'])){
            unset($filter['voucher_active_date_int']);
        }
        
        if (isset($filter['voucher_end_date_int'])){
            unset($filter['voucher_end_date_int']);
        }
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->customer_voucher_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
