<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slide_add_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        // Fill Data
        foreach ($filter as & $item){
            $item = quotes_to_entities($item);
        }
        
        // render to view
        $this->load->view('view', array
        (
                'errors'            => $this->message->getError(),
                'message'           => $this->message->getMessage(),
                'filter'            => $filter
        ));
    }
}


?>
