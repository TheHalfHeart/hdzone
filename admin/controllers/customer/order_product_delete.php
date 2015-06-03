<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_product_delete extends CI_Controller 
{
    public function index()
    {
        // Not Request Ajax
        if (!$this->input->is_ajax_request()){
            die ('ERROR_BAD_REQUEST');
        }

        // Check For Token
        if (!$this->security->check_get_token()){
            die ('ERROR_TOKEN');
        }

        // Only Admin, Editor
        if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
            die ('ERROR_AUTH');
        }
        
        // Add Action
        if ($this->security->is_action('order_product_delete'))
        {
            $id = trim($this->input->post('id'));

            if (!$id){
                die('ERROR_BAD_REQUEST');
            }
            
            // DELETE Order Product
            $order_product = new_table('customer', 'order_product');
            $order_product->delete("id = ".(int)$id, true);
            
            $deleted = $order_product->get_result('0');
            
            // Update Price
            if ($deleted){
                $price = (int)$deleted['post_price'] * (int)$deleted['number'];
                new_table('customer', 'order')->change_price($price, $deleted['order_id'], '-');
                die ("ERROR_SUCCESS");
            }
            
            die('ERROR_BAD_REQUEST');
        }
        die ('ERROR_BAD_REQUEST');
    }
}
?>
