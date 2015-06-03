<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_product_add extends CI_Controller 
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
        if ($this->security->is_action('order_product_add'))
        {
            $post_id = trim($this->input->post('post_id'));

            if (!$post_id){
                die('ERROR_BAD_REQUEST');
            }

            $this->load->model('product/product_post_model');
            $post = $this->product_post_model->getDetail(array(
                'select' => 'post_id,post_title_vi,post_title_en,post_price',
                'post_id' => $post_id
            ));

            if (!$post){
                die ('ERROR_NOT_FOUND');
            }
            
            $post['post_price'] = (int)$post['post_price'];
            
            $order_prod = new_table('customer', 'order_product');
            
            $data = array(
                'order_id'      => $this->input->post('order_id'),
                'post_id'       => $post['post_id'],
                'post_price'    => (int)$post['post_price'],
                'post_title_vi' => $post['post_title_vi'],
                'post_title_en' => $post['post_title_en'],
                'number'        => (int)$this->input->post('number')
            );
            
            if ($data['number'] < 1){
                die('ERROR_BAD_REQUEST');
            }
            
            if ($order_prod->validate($data)){
                $data['id'] = $order_prod->insert($data);
                new_table('customer', 'order')->change_price($data['number']*$data['post_price'], $data['order_id'], '+');
                die (json_encode($data));
            }
            
            die('ERROR_BAD_REQUEST');
        }
        die ('ERROR_BAD_REQUEST');
    }
}
?>
