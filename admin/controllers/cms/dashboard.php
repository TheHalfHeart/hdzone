<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{ 
	public function index()
	{
            die ($this->load->widget('cms/dashboard'));
	}
}
?>
