<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Customer_voucher_edit_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {   
            $voucher_id = (int)$this->input->get('voucher_id');
            
            if (!$voucher_id){
                return;
            }
            
            $this->load->model('customer/customer_voucher_model');
            
            $data = $this->customer_voucher_model->getDetail(array(
                'voucher_id' => $voucher_id
            ));
            
            if (!$data){
                return '';
            }
            
            // Update Editting
            if (!_is_editting($data)){
                $this->customer_voucher_model->updateEditting($voucher_id);
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
            $customer = array();
            if ($data['voucher_customer_id']){
                $this->load->model('customer/customer_customer_model');
                $customer = $this->customer_customer_model->getDetail(array(
                    'customer_id' => $data['voucher_customer_id']
                ));
            }
            
            // Get History
            $history  = new_table('customer', 'voucher_history')->where('history_voucher_id', $voucher_id)->execute()->get_result();
            
            // render to view
            $this->load->view('view', array
            (
                    'errors'            => $this->message->getError(),
                    'message'           => $this->message->getMessage(),
                    'history'           => $history,
                    'customer'          => $customer,
                    'filter'            => $data
            ));
        }
    }
?>
