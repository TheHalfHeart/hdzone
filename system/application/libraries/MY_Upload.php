<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Upload extends CI_Upload
{
    
    // Custom
    public $custom_error = array();
    
    function __construct($props = array()) {
        parent::__construct($props);
    }
    
    function get_errors(){
        return $this->custom_error;
    }
    
    function set_error($msg) 
    {
        if (is_array($msg))
        {
                foreach ($msg as $val)
                {
                        $this->error_msg[] = $msg;
                }
        }
        else{
                if (!in_array($msg, $this->custom_error))
                {
                        $this->custom_error[] = $msg;
                }
        }
        parent::set_error($msg);
    }
    
}

?>
