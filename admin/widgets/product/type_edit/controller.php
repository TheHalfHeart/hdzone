<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_type_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $type_id = (int)$this->input->get('type_id');
            
            if (!$type_id){
                return;
            }
            
            $this->load->model('product/product_type_model');
            
            $data = $this->product_type_model->getDetail(array(
                'type_id' => $type_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_type_model->updateEditting($type_id);
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
            
            // Create Folder Image
            createFolderUpload('images','product_type',date('Y/m/d', $data['type_add_date_time_int']).'/'.$data['type_id']);
            createFolderUpload('files','product_type',date('Y/m/d', $data['type_add_date_time_int']).'/'.$data['type_id']);
            createFolderUpload('flash','product_type',date('Y/m/d', $data['type_add_date_time_int']).'/'.$data['type_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['type_add_date_int']).$data['type_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
