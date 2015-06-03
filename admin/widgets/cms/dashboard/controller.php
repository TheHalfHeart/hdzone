<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_dashboard_widget extends MY_Widget 
{ 
	public function index()
	{
            $order = new_table('customer', 'order')->where('order_status', '0')->order_by('order_id', 'desc')->limit('0', '20')->execute()->get_result();
            
            // To View
            $this->load->view('view', array(
                'order' => $order
            ));
	}
}
?>
