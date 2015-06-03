<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_director_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('product/product_director_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            lang_field('director_title_short') => $this->input->get('director_title_short'),
            'director_id'       => $this->input->get('director_id'),
            'order_by'      => 'director_sort',
            'order_type'    => 'asc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->product_director_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('product/director_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->product_director_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
