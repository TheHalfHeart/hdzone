<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Lưu ý: Trong View có sử dụng phân quyền:
 *  + Nếu Admin và Editor đc full quyền
 *  + Nếu Author thì thêm bình thường
 *  + Nếu Contributor thì không sử dụng được chức năng hẹn giờ 
 */
class Customer_customer_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {
        // Get Page Id And Check For It
        $customer_id = (int)$this->input->get('customer_id');
        if (!$customer_id){
            return;
        }

        // Load Lib
        $this->load->model('customer/customer_customer_model');

        // Get Current Page And Check For It
        $data = $this->customer_customer_model->getDetail(array(
            'customer_id' => $customer_id
        ));
        if (!$data){
            return '';
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->customer_customer_model->updateEditting($customer_id);
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
                'errors'        => $this->message->getError(),
                'message'       => $this->message->getMessage(),
                'filter'        => $data
        ));
    }
}
?>
