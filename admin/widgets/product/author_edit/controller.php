<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_author_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $author_id = (int)$this->input->get('author_id');
            
            if (!$author_id){
                return;
            }
            
            $this->load->model('product/product_author_model');
            
            $data = $this->product_author_model->getDetail(array(
                'author_id' => $author_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_author_model->updateEditting($author_id);
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
            createFolderUpload('images','product_author',date('Y/m/d', $data['author_add_date_time_int']).'/'.$data['author_id']);
            createFolderUpload('files','product_author',date('Y/m/d', $data['author_add_date_time_int']).'/'.$data['author_id']);
            createFolderUpload('flash','product_author',date('Y/m/d', $data['author_add_date_time_int']).'/'.$data['author_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['author_add_date_int']).$data['author_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
