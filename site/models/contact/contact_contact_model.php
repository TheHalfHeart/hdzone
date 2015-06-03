<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_contact_model
{
    private $__contact = null;
            
    function __construct(){
        $this->__contact = new_table('contact', 'contact');
    }
    
    // Add
    function add($data){
        $this->__contact->clear();
        if ($this->__contact->validate($data)){
            return $this->__contact->insert($data);
        }
        return $this->__contact->get_error();
    }
}
?>
