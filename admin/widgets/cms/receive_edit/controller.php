<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Cms_receive_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $receive_id = (int)$this->input->get('receive_id');
            
            if (!$receive_id){
                return;
            }
            
            $this->load->model('cms/cms_receive_model');
            
            $data = $this->cms_receive_model->getDetail(array(
                'receive_id' => $receive_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->cms_receive_model->updateEditting($receive_id);
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
