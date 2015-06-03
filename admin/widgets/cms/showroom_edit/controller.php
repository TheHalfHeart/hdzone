<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Cms_showroom_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $showroom_id = (int)$this->input->get('showroom_id');
            
            if (!$showroom_id){
                return;
            }
            
            $this->load->model('cms/cms_showroom_model');
            
            $data = $this->cms_showroom_model->getDetail(array(
                'showroom_id' => $showroom_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->cms_showroom_model->updateEditting($showroom_id);
            }
            
            // Fill Data
            if ($filter)
            {
                foreach ($filter as $key => $item){
                    $data[$key] = $item;
                }
            }
            
            // Filter
            foreach ($data as & $item){
                $item = quotes_to_entities($item);
            }
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'filter'            => $data
            ));
        }
    }
?>
