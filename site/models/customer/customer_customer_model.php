<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_customer_model
{
    private $__customer = null;
            
    function __construct(){
        $this->__customer = new_table('customer', 'customer');
    }
    
    // Add
    function add($data){
        $this->__customer->clear();
        if ($this->__customer->validate($data)){
            return $this->__customer->insert($data);
        }
        return $this->__customer->get_error();
    }
}
?>
