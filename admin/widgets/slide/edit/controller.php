<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slide_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        // Get Page Id And Check For It
        $slide_id = (int)$this->input->get('slide_id');
        if (!$slide_id){
            return;
        }
        
        // Load Lib
        $this->load->model('slide/slide_slide_model');
        
        // Get Current Page And Check For It
        $data = $this->slide_slide_model->getDetail(array(
            'slide_id' => $slide_id
        ));
        
        if (!$data){
            return '';
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->slide_slide_model->updateEditting($slide_id);
        }

        // Fill Data
        if ($filter)
        {
            foreach ($filter as $key => $item){
                $data[$key] = $item;
            }
        }

        // Timer
        if ($data['slide_timer_date_time_int'] == timer_private()){
            $data['timer'] = '0';
        }
        else if ($data['slide_timer_date_time_int'] <= current_date_time_to_int()){
            $data['timer'] = '1';
            $data['timer_day'] = date('d-m-Y', $data['slide_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['slide_timer_date_time_int']);
        }
        else{
            $data['timer'] = '2';
            $data['timer_day'] = date('d-m-Y', $data['slide_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['slide_timer_date_time_int']);
        }

        // Filter
        foreach ($data as & $item){
            $item = quotes_to_entities($item);
        }
        
        // Create Folder Image
        createFolderUpload('images','slide',date('Y/m/d', $data['slide_add_date_time_int']).'/'.$data['slide_id']);
        createFolderUpload('files','slide',date('Y/m/d', $data['slide_add_date_time_int']).'/'.$data['slide_id']);
        createFolderUpload('flash','slide',date('Y/m/d', $data['slide_add_date_time_int']).'/'.$data['slide_id']);
        
        // render to view
        $this->load->view('view', array
        (
                'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['slide_add_date_int']).$data['slide_id'].'/',
                'ck_img_id'     => $data['slide_id'],
                'errors'        => $this->message->getError(),
                'message'       => $this->message->getMessage(),
                'filter'        => $data
        ));
    }
}
?>
