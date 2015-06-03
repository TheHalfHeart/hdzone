<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_order extends CI_Controller {

    function index()
    {
        $this->my_cart->getListCart();
        if ($this->security->is_action('action_shop_order'))
        {
            
            $captcha_init = $this->session->userdata('code_captcha_order');
            
            if (!$captcha_init || $captcha_init != $this->input->post('order_captcha')){
                die (json_encode(array(
                    'type' => 'Error',
                    'bad_captcha' => true
                )));
            }
            
            if ($this->my_cart->total < 1){
                die (json_encode(array(
                    'type' => 'Error',
                    'bad_number' => true
                )));
            }
            
            $customer_id = '1';
            
            $customer = new_table('customer', 'customer')->where('customer_id', $customer_id)->execute()->get_result(0);
            
            if (!$customer){
                die (json_encode(array(
                    'type' => 'Error',
                    'bad_custoemr' => true
                )));
            }
            
            $data = array(
                'order_title' => $this->input->post('order_title'),
                'order_address' => $this->input->post('order_address'),
                'order_email' => $this->input->post('order_email'),
                'order_fullname' => $this->input->post('order_fullname'),
                'order_phone' => $this->input->post('order_phone'),
                'order_note' => $this->input->post('order_note'),
                'order_customer_id' => '2',
                'order_customer_username_int' => '2168032777',
                'order_customer_username' => 'Customer',
                'order_status' => '0'
            );
            
            $data['order_add_date_time'] = current_date_time_mysql();
            $data['order_add_date_int'] = current_date_to_int();
            $data['order_add_date_time_int'] = current_date_time_to_int();
            
            $order = new_table('customer', 'order');
            $id_insert = $order->insert($data);
            if ($id_insert){
                foreach ($this->my_cart->product as $item){
                    $data_order_prod = array(
                        'order_id'  => $id_insert,
                        'post_id'       => $item['post_id'],
                        'post_title_vi' => $item['post_title_vi'],
                        'post_title_en' => $item['post_title_en'],
                        'post_price'    => $item['post_price'],
                        'number'   => $item['number'],
                    );
                    new_table('customer', 'order_product')->insert($data_order_prod);
                }
                $this->my_cart->emptyProd();
                die (json_encode(array(
                    'type' => 'Success'
                )));
            }
        }
        die (json_encode(array(
            'type' => 'Error',
            'bad_request' => true
        )));
    }

}
?>
