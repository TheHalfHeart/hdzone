<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Lưu ý: Trong View có sử dụng phân quyền:
 *  + Nếu Admin và Editor đc full quyền
 *  + Nếu Author thì thêm bình thường
 *  + Nếu Contributor thì không sử dụng được chức năng hẹn giờ 
 */
class Product_post_add_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        $this->load->model('product/product_cate_model');

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
