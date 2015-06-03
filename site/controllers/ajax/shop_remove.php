<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_remove extends CI_Controller {

    function index()
    {
        if ($this->security->is_action('action_shop_delete')){
            $id = (int)$this->input->post('product_id');
            if ($id){
                $this->my_cart->removeProd($id);
            }
        }
    }

}
?>
