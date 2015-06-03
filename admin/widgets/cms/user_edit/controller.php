<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cms_user_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {
        // Get Page Id And Check For It
        $user_id = (int)$this->input->get('user_id');
        if (!$user_id){
            return;
        }

        // Load Lib
        $this->load->model('cms/cms_user_model');

        // Get Current Page And Check For It
        $data = $this->cms_user_model->getDetail(array(
            'user_id' => $user_id
        ));
        
        // Không có data hoặc không có quyền
        if (!$data || !can_edit_user($data['user_id'], $data['user_level'], $data['user_is_root'])){
            return '';
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->cms_user_model->updateEditting($user_id);
        }
        
        // Fill Data
        if ($filter){
            foreach ($filter as $key => $item){
                $data[$key] = $item;
            }
        }
        
        // Create Folder Image
        createFolderUpload('images', 'user', date('Y/m/d', $data['user_add_date_int']));
        
        // Filter
        foreach ($filter as & $item){
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
