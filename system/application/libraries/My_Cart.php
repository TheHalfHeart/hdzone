<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Cart 
{
    public $product = array();
    
    public $total = 0;
    
    public $CI;
    
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $prod = $this->CI->session->userdata('cart-list');
        if ($prod){
            $this->getListCart();
            $this->total = count($prod);
        }
    }
    
    function addProd($post_id, $number)
    {
        $prod = $this->CI->session->userdata('cart-list');
        
        if (!$prod){
            $prod = array();
        }
        
        if (isset($prod[$post_id])){ 
            $prod[$post_id] += $number;
        }
        else {
            $prod[$post_id] = $number;
        }
        
        $this->CI->session->set_userdata('cart-list', $prod);
        
        $this->total = count($prod);
    }
    
    function updateProd($post_id, $number)
    {
        $prod = $this->CI->session->userdata('cart-list');
        if (!$prod || !isset($prod[$post_id])){
            return false;
        }
        if ($number <= 0){
            unset($prod[$post_id]);
        }
        
        $prod[$post_id] = (int)$number;
        
        $this->CI->session->set_userdata('cart-list', $prod);
        
        $this->total = count($prod);
    }
    
    function removeProd($post_id){
        $prod = $this->CI->session->userdata('cart-list');
        if (isset($prod[$post_id])){
            unset($prod[$post_id]);
        }
        $this->CI->session->set_userdata('cart-list', $prod);
    }
    function emptyProd(){
        $this->CI->session->unset_userdata('cart-list', array());
    }
    function getListCart()
    {
        $prod = $this->CI->session->userdata('cart-list');
        
        if (!$prod){
            return array();
        }
        
        $this->CI->load->model('product/product_post_model');
        
        foreach ($prod as $key => $val){
            $tmp = $this->CI->product_post_model->getDetail(array(
                'select' => '*',
                'post_id' => $key
            ));
            if ($tmp){
                $tmp['number'] = $val;
                $this->product[] = $tmp;
            }
        }
    }
}
?>
