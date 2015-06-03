<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_author_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('product/product_author_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            lang_field('author_title_short') => $this->input->get('author_title_short'),
            'author_id'       => $this->input->get('author_id'),
            'order_by'      => 'author_sort',
            'order_type'    => 'asc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_author_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('product/author_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->product_author_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
