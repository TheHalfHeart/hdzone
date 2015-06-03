<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_cate_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $cate_id = (int)$this->input->get('cate_id');
            
            if (!$cate_id){
                return;
            }
            
            $this->load->model('product/product_cate_model');
            
            $data = $this->product_cate_model->getDetail(array(
                'cate_id' => $cate_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->product_cate_model->updateEditting($cate_id);
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
            createFolderUpload('images','product_cate',date('Y/m/d', $data['cate_add_date_time_int']).'/'.$data['cate_id']);
            createFolderUpload('files','product_cate',date('Y/m/d', $data['cate_add_date_time_int']).'/'.$data['cate_id']);
            createFolderUpload('flash','product_cate',date('Y/m/d', $data['cate_add_date_time_int']).'/'.$data['cate_id']);
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['cate_add_date_int']).$data['cate_id'].'/',
                    'filter'            => $data
            ));
        }
    }
?>
