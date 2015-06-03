<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slide_lists_widget extends MY_Widget 
{ 
    public function index()
    {
        // Load Lib
        $this->load->model('slide/slide_slide_model');
        $this->load->library('admin/pagination');
        
        // Get Filter
        $filter = array
        (
            'slide_id'      => $this->input->get('slide_id'),
            'slide_position'=> $this->input->get('slide_position'),
            lang_field('slide_title') => $this->input->get(lang_field('slide_title')),
            'slide_status'  => $this->input->get('slide_status'),
            'order_by'      => $this->input->get('order_by')    ? $this->input->get('order_by') : 'slide_id',
            'order_type'    => $this->input->get('order_type')  ? $this->input->get('order_type') : 'desc',
            'limit'         => $this->input->get('limit'),
            'lang'  => $this->input->get('lang')
        );
        
        if ($filter[lang_field('slide_title')]){
            $filter[lang_field('slide_title_clear_utf8')] = title_clear_utf8($filter[lang_field('slide_title')]);
        }
        
        // Curent Slide
        $slide = $this->input->get('page');
        
        // Pagination
        $this->pagination->setCurrentPage($slide);
        $this->pagination->setTotalRecord($this->slide_slide_model->countList($filter));
        $this->pagination->setLimit($filter['limit']);
        $this->pagination->setLink('slide/lists');
        $this->pagination->setQuery($filter);
        $this->pagination->setup();
        
        // Add More Filter
        $filter['limit'] = $this->pagination->getLimit();
        $filter['start'] = $this->pagination->getStart();
        $filter['select'] = 'slide_id,'.lang_field('slide_title').', slide_position, slide_add_user_username, slide_timer_date_time_int, editting_date_time_int, editting_user_username, editting_token';
        
        // List Data
        $data = $this->slide_slide_model->getList($filter);
        
        // To View
        $this->load->view('view', array(
            'data'              => $data,
            'filter'            => $filter,
            'link_back'         => $this->pagination->__get_link($slide)
        ));
    }   
        
}
?>
