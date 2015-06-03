<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Lưu ý: Trong View có sử dụng phân quyền:
 *  + Nếu Admin và Editor đc full quyền
 *  + Nếu Author thì thêm bình thường
 *  + Nếu Contributor thì không sử dụng được chức năng hẹn giờ 
 */
class Page_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {
        // Get Page Id And Check For It
        $page_id = (int)$this->input->get('page_id');
        if (!$page_id){
            return;
        }

        // Load Lib
        $this->load->model('page/page_page_model');

        // Get Current Page And Check For It
        $data = $this->page_page_model->getDetail(array(
            'page_id' => $page_id
        ));
        if (!$data){
            return '';
        }

        // Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            if ($data['page_add_user_id'] != $this->auth->getItem('user_id')){
                return;
            }
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->page_page_model->updateEditting($page_id);
        }

        // Fill Data
        if ($filter)
        {
            foreach ($filter as $key => $item){
                $data[$key] = $item;
            }
        }

        // Timer
        if ($data['page_timer_date_time_int'] == timer_private())
        {
            $data['timer'] = '0';
        }
        else if ($data['page_timer_date_time_int'] < current_date_time_to_int())
        {
            $data['timer'] = '1';
            $data['timer_day'] = date('d-m-Y', $data['page_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['page_timer_date_time_int']);
        }
        else{
            $data['timer'] = '2';
            $data['timer_day'] = date('d-m-Y', $data['page_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['page_timer_date_time_int']);
        }
        
        // Filter
        foreach ($data as & $item){
            $item = quotes_to_entities($item);
        }
        
        // Create Folder Image
        createFolderUpload('images','page',date('Y/m/d', $data['page_add_date_time_int']).'/'.$data['page_id']);
        createFolderUpload('files','page',date('Y/m/d', $data['page_add_date_time_int']).'/'.$data['page_id']);
        createFolderUpload('flash','page',date('Y/m/d', $data['page_add_date_time_int']).'/'.$data['page_id']);
        
        // render to view
        $this->load->view('view', array
        (
                'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['page_add_date_int']).$data['page_id'].'/',
                'errors'        => $this->message->getError(),
                'message'       => $this->message->getMessage(),
                'filter'        => $data
        ));
    }
}
?>
