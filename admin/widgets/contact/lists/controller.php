<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('contact/contact_contact_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'contact_id'       => $this->input->get('contact_id'),
            'contact_title'    => $this->input->get('contact_title'),
            'contact_add_date' => $this->input->get('contact_add_date'),
            'contact_status'   => $this->input->get('contact_status'),
            'contact_answer'   => $this->input->get('contact_answer'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'contact_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        if ($filter['contact_title']){
            $filter['contact_title_clear_utf8'] = title_clear_utf8($filter['contact_title']);
        }
        
        if ($filter['contact_add_date']){
            $filter['contact_add_date_int'] = strtotime($filter['contact_add_date']);
        }
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->contact_contact_model->countList($filter));
        
        // Remove Filter When Convert
        if (isset($filter['contact_add_date_int'])){
            unset($filter['contact_add_date_int']);
        }
        if (isset($filter['contact_title_clear_utf8'])){
            unset($filter['contact_title_clear_utf8']);
        }
        
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('contact/lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'contact_id,contact_title,contact_answer,contact_add_user_username, contact_status, contact_add_date_time_int,editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->contact_contact_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
