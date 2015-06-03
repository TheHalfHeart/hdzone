<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_product_edit extends CI_Controller 
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
        if ($this->security->is_action('order_product_quick_edit'))
        {
            $id = trim((string)(int)$this->input->post('id'));
            $field = trim($this->input->post('field'));
            $value = trim((string)(int)$this->input->post('value'));

            if (!$id || !$field || !$value){
                die('ERROR_BAD_REQUEST');
            }
            
            if (!in_array($field, array('number', 'post_price'))){
                die('ERROR_BAD_REQUEST');
            }
            
            $data = array(
                $field => $value
            );
            
            $order_prod = new_table('customer', 'order_product');
            
            // Order Product hien tai
            $current    = $order_prod->where('id', $id)->execute()->get_result(0);
            $old_price  = $current['number'] * $current['post_price'];
            
            $order_prod->clear();
            
            if ($current && $order_prod->where('id', $id)->validate($data, 'update') && $order_prod->update($data))
            {
                $order_prod->clear();
                $current = $order_prod->where('id', $id)->execute()->get_result(0);
                $new_price = $current['number'] * $current['post_price'];
                
                if ($new_price > $old_price){
                    $price = $new_price - $old_price;
                    $slash = '+';
                }
                else if ($new_price < $old_price){
                    $price = $old_price - $new_price;
                    $slash = '-';
                }
                if (isset($slash)){
                    new_table('customer', 'order')->change_price($price, $current['order_id'], $slash);
                    die ((string)($current['number']*$current['post_price']));
                }
            }
        }
        die ('ERROR_BAD_REQUEST');
    }
}
?>
