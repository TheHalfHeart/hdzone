<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Cms_message_widget extends MY_Widget
    {
        function index($message)
        {
            $this->load->view('view', array('message' => $message));
        }
    }
?>
