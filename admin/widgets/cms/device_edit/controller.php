<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Cms_device_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $device_id = (int)$this->input->get('device_id');
            
            if (!$device_id){
                return;
            }
            
            $this->load->model('cms/cms_device_model');
            
            $data = $this->cms_device_model->getDetail(array(
                'device_id' => $device_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->cms_device_model->updateEditting($device_id);
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
