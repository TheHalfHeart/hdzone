<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_director_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $director_id = (int)$this->input->get('director_id');
            
            if (!$director_id){
                return;
            }
            
            $this->load->model('product/product_director_model');
            
            $data = $this->product_director_model->getDetail(array(
                'director_id' => $director_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_director_model->updateEditting($director_id);
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
            createFolderUpload('images','product_director',date('Y/m/d', $data['director_add_date_time_int']).'/'.$data['director_id']);
            createFolderUpload('files','product_director',date('Y/m/d', $data['director_add_date_time_int']).'/'.$data['director_id']);
            createFolderUpload('flash','product_director',date('Y/m/d', $data['director_add_date_time_int']).'/'.$data['director_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['director_add_date_int']).$data['director_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
