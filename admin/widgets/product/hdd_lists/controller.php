<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_hdd_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('product/product_hdd_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'order_by'      => 'hdd_order',
            'order_type'    => 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_hdd_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('product/hdd_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->product_hdd_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
