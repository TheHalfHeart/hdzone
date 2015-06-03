<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Cms_receive_add_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            // Fill Data
            foreach ($filter as & $item){
                $item = quotes_to_entities($item);
            }
            
            $order_id = $this->input->get('order_id');
            $order = array();
            if ($order_id){
                $order = new_table('customer', 'order')->where('order_id', $order_id)->execute()->get_result(0);
            }
            
            $customer  = array();
            if ($order){
                $customer = new_table('customer', 'customer')->where('customer_id', $order['order_customer_id'])->execute()->get_result(0);
            }
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'showroom'          => new_table('cms', 'showroom')->order_by('showroom_order', 'asc')->execute()->get_result(),
                    'message'           => $this->message->getMessage(),
                    'filter'            => $filter,
                    'order'             => $order,
                    'customer'          => $customer
            ));    
        }
    }
?>
