<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_actor_add_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            // Fill Data
            foreach ($filter as & $item){
                $item = quotes_to_entities($item);
            }
            
            // Load Lib
            $this->load->model('product/product_actor_model');
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'filter'            => $filter
            ));
        }
    }
?>
