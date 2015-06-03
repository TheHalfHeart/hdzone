<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_actor_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $actor_id = (int)$this->input->get('actor_id');
            
            if (!$actor_id){
                return;
            }
            
            $this->load->model('product/product_actor_model');
            
            $data = $this->product_actor_model->getDetail(array(
                'actor_id' => $actor_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_actor_model->updateEditting($actor_id);
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
            createFolderUpload('images','product_actor',date('Y/m/d', $data['actor_add_date_time_int']).'/'.$data['actor_id']);
            createFolderUpload('files','product_actor',date('Y/m/d', $data['actor_add_date_time_int']).'/'.$data['actor_id']);
            createFolderUpload('flash','product_actor',date('Y/m/d', $data['actor_add_date_time_int']).'/'.$data['actor_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['actor_add_date_int']).$data['actor_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
