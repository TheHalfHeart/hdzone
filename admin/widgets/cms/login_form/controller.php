<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_login_form_widget extends MY_Widget 
{ 
	public function index($message = '')
	{
                $this->load->view('view', array(
                    'message' => $message
                ));
	}
}
?>
