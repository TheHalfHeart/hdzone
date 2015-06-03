<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_receive_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('cms/cms_receive_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'order_by'      => 'receive_id',
            'order_type'    => 'desc',
            'limit'         => $this->input->get('limit')
        );
        
        // Curent Page
        $page = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($page);
        $this->pagination->setTotalRecord($this->cms_receive_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('cms/receive_lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Filter
        $filter['select'] = '*';
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        
        // List Data
        $data = $this->cms_receive_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($page)
        ));
    }   
        
}
?>
