<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class News_tags_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $tags_id = (int)$this->input->get('tags_id');
            
            if (!$tags_id){
                return;
            }
            
            $this->load->model('news/news_tags_model');
            
            $data = $this->news_tags_model->getDetail(array(
                'tags_id' => $tags_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->news_tags_model->updateEditting($tags_id);
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
