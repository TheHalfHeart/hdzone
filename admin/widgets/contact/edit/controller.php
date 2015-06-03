<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        // Get Page Id And Check For It
        $contact_id = (int)$this->input->get('contact_id');
        if (!$contact_id){
            return;
        }

        // Load Lib
        $this->load->model('contact/contact_contact_model');
        
        // Get Current Page And Check For It
        $data = $this->contact_contact_model->getDetail(array(
            'contact_id' => $contact_id
        ));
        if (!$data){
            return '';
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->contact_contact_model->updateEditting($contact_id);
        }

        // Fill Data
        if ($filter)
        {
            foreach ($filter as $key => $item){
                $data[$key] = $item;
            }
        }
        
        // Filter
        foreach ($data as & $item){
            $item = quotes_to_entities($item);
        }
        
        // render to view
        $this->load->view('view', array
        (
                'errors'            => $this->message->getError(),
                'message'           => $this->message->getMessage(),
                'filter'            => $data
        ));
    }
}
?>
