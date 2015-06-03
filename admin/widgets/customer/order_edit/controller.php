<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_order_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        // Get Page Id And Check For It
        $order_id = (int)$this->input->get('order_id');
        if (!$order_id){
            return;
        }

        // Load Lib
        $this->load->model('customer/customer_order_model');

        // Get Current Page And Check For It
        $data = $this->customer_order_model->getDetail(array(
            'order_id' => $order_id
        ));
        
        if (!$data){
            return '';
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->customer_order_model->updateEditting($order_id);
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
        
        // List Order Product
        $order_prod = new_table('customer', 'order_product')->order_by('id', 'desc')->where('order_id', $data['order_id'])->execute()->get_result();
        
        // HDD Info
        $this->load->model('product/product_hdd_group_model');
        $hdd_group = $this->product_hdd_group_model->getList();
        
        
        // render to view
        $this->load->view('view', array
        (
                'errors'        => $this->message->getError(),
                'message'       => $this->message->getMessage(),
                'filter'        => $data,
                'hdd_group'     => $hdd_group,
                'order_prod'    => $order_prod
        ));
    }
}
?>
