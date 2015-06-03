<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Message 
    {
            protected $_session_error   = 'session_error';
            protected $_session_message = 'session_message';
            protected $_session_is_success = 'session_is_success';
            
            function setError($errors = array()){
                    $CI = & get_instance();
                    $CI->session->sess_use_database = false;
                    $CI->session->set_userdata($this->_session_error, $errors);
            }

            function getError(){
                    $CI = & get_instance();
                    $CI->session->sess_use_database = false;
                    $error = $CI->session->userdata($this->_session_error);
                    $CI->session->unset_userdata($this->_session_error);
                    return $error;
            }
            
            function setMessage($message, $is_success = FALSE){
                    $CI = & get_instance();
                    $CI->session->sess_use_database = false;
                    $CI->session->set_userdata($this->_session_message, $message);
                    $CI->session->set_userdata($this->_session_is_success, $is_success);
            }
            
            function getMessage()
            {
                    $CI = & get_instance();
                    $CI->session->sess_use_database = false;
                    $message    = $CI->session->userdata($this->_session_message);
                    $is_success = $CI->session->userdata($this->_session_is_success);
                    $CI->session->unset_userdata($this->_session_message);
                    $CI->session->unset_userdata($this->_session_is_success);
                    
                    if ($message)
                    {
                        if ($is_success){
                            return '<div class="success">'.$message.'</div>';
                        }
                        else{
                            return '<div class="warning">'.$message.'</div>';
                        }
                    }
                    return '';
            }
    }
?>
