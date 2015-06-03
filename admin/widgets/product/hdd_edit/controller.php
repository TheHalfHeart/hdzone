<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_hdd_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $hdd_id = (int)$this->input->get('hdd_id');
            
            if (!$hdd_id){
                return;
            }
            
            $this->load->model('product/product_hdd_model');
            
            $data = $this->product_hdd_model->getDetail(array(
                'hdd_id' => $hdd_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_hdd_model->updateEditting($hdd_id);
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
