<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_delete extends CI_Controller 
{
    public function index()
    {
        if (!$this->input->is_ajax_request()){
            show_404();
        }

        if (!$this->security->check_get_token()){
            die ('101'); // NOT FOUND
        }

        // Manager
        if (!$this->auth->isManager()){
            die ('101'); // NOT FOUND
        }

        if ($this->security->is_action('post_delete'))
        {
            $list_id = $this->input->post('list_id');
            if ($list_id)
            {
                $this->load->model('product/product_post_model');

                $check = $this->product_post_model->delete($list_id);

                die (($check === 2) ? '102' : '100'); // Max Or Success
            }
        }
        die ('101'); // NOT FOUND
    }
}
?>
