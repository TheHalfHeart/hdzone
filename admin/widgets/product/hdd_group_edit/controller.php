<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_hdd_group_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $hdd_group_id = (int)$this->input->get('hdd_group_id');
            
            if (!$hdd_group_id){
                return;
            }
            
            $this->load->model('product/product_hdd_group_model');
            
            $data = $this->product_hdd_group_model->getDetail(array(
                'hdd_group_id' => $hdd_group_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_hdd_group_model->updateEditting($hdd_group_id);
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
