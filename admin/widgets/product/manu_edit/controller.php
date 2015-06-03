<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_manu_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $manu_id = (int)$this->input->get('manu_id');
            
            if (!$manu_id){
                return;
            }
            
            $this->load->model('product/product_manu_model');
            
            $data = $this->product_manu_model->getDetail(array(
                'manu_id' => $manu_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_manu_model->updateEditting($manu_id);
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
            createFolderUpload('images','product_manu',date('Y/m/d', $data['manu_add_date_time_int']).'/'.$data['manu_id']);
            createFolderUpload('files','product_manu',date('Y/m/d', $data['manu_add_date_time_int']).'/'.$data['manu_id']);
            createFolderUpload('flash','product_manu',date('Y/m/d', $data['manu_add_date_time_int']).'/'.$data['manu_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['manu_add_date_int']).$data['manu_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
