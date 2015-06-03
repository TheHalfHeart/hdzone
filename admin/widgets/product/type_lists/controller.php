<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_type_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('product/product_type_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            lang_field('type_title_short') => $this->input->get('type_title_short'),
            'type_id'       => $this->input->get('type_id'),
            'order_by'      => 'type_sort',
            'order_type'    => 'asc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_type_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('product/type_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->product_type_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
