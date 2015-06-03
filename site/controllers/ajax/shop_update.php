<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_update extends CI_Controller {

    function index()
    {
        if ($this->security->is_action('action_shop_update'))
        {
            $id = (int)$this->input->post('product_id');
            $number = $this->input->post('value');
            if ($id){
                $this->my_cart->updateProd($id, $number);
            }
        }
    }

}
?>
