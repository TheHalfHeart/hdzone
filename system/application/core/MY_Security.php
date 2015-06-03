<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Security extends CI_Security {

    // added by thehalfheart
    
    function check_get_token()
    {
        $CI = & get_instance();
        if ($CI->input->is_get_request()){
            return ($CI->input->get($this->get_csrf_token_name()) != $this->get_csrf_hash()) ? FALSE : TRUE;
        }
        return TRUE;
    }
    
    function set_csrf_hidden()
    {
        echo '<input type="hidden" name="'.$this->get_csrf_token_name().'" value="'.$this->get_csrf_hash().'"/>';
    }

    function set_action($action, $roles = true)
    {
        $CI = & get_instance();
        echo ($roles) ? '<input type="hidden" id="'.$action.'" name="'.$action.'" value="'.md5($action.'1'.$CI->input->ip_address()).'"/>' : '';
    }

    function is_action($action)
    {
        $CI = & get_instance();
        return ( (string) $CI->input->post($action) == (string) md5($action.'1'.$CI->input->ip_address())) ? true : false;
    }
    // end added by thehalfheart

}
?>
