<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_add extends CI_Controller {

    function index()
    {
        if ($this->security->is_action('action_shop_add'))
        {
            $product_id = (int)$this->input->post('product_id');

            $number     = (int)$this->input->post('number');

            if ($product_id && $number > 0){
                $this->my_cart->addProd($product_id, $number);
                die (json_encode(array(
                    'type' => 'Success',
                    'response' => $this->my_cart->total
                )));
            }
        }
        
        die (json_encode(array(
            'type' => 'Error',
            'bad_request' => true
        )));
    }

}