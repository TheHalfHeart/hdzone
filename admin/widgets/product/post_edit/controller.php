<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Lưu ý: Trong View có sử dụng phân quyền:
 *  + Nếu Admin và Editor đc full quyền
 *  + Nếu Author thì thêm bình thường
 *  + Nếu Contributor thì không sử dụng được chức năng hẹn giờ 
 */

function br2nl($value){
    return str_replace(array('<br/>', '<br />', '<br>'), array("\n","\n","\n"), nl2br($value));
}
class Product_post_edit_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        $this->load->model('product/product_cate_model');
        $this->load->model('product/product_post_model');
        $this->load->model('product/product_brand_model');
        $this->load->model('product/product_manu_model');

        $post_id = (int)$this->input->get('post_id');

        if (!$post_id){
            return;
        }

        $data = $this->product_post_model->getDetail(array(
            'post_id' => $post_id
        ));

        if (!$data){
            return;
        }
        
        // Auth
        if ($this->auth->isAuthor() || $this->auth->isContributor()){
            if ($data['post_add_user_id'] != $this->auth->getItem('user_id')){
                return;
            }
        }
        
        // Update Editting
        if (!_is_editting($data)){
            $this->product_post_model->updateEditting($post_id);
        }

        // Fill Data
        if ($filter)
        {
            foreach ($filter as $key => $item){
                $data[$key] = $item;
            }
        }
        
        // Fill Data
        foreach ($data as & $item){
            $item = quotes_to_entities($item);
        }

        // Create Folder Image
        createFolderUpload('images','product',date('Y/m/d', $data['post_add_date_time_int']).'/'.$data['post_id']);
        createFolderUpload('files','product',date('Y/m/d', $data['post_add_date_time_int']).'/'.$data['post_id']);
        createFolderUpload('flash','product',date('Y/m/d', $data['post_add_date_time_int']).'/'.$data['post_id']);

        // Timer
        if ($data['post_timer_date_time_int'] == timer_private()){
            $data['timer'] = '0';
        }
        else if ($data['post_timer_date_time_int'] < current_date_time_to_int()){
            $data['timer'] = '1';
            $data['timer_day'] = date('d-m-Y', $data['post_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['post_timer_date_time_int']);
        }
        else if (isset($filter['post_timer_date_time_int'])){
            $data['timer'] = '2';
            $data['timer_day'] = date('d-m-Y', $data['post_timer_date_time_int']);
            $data['timer_time'] = date('H:i:s', $data['post_timer_date_time_int']);
        }

        // Related
        $related = array();
        if (isset($data['post_ref_related']) && $data['post_ref_related']){
            foreach (preg_split('/\s+/', $data['post_ref_related']) as $val){
                if ((int)$val){
                    $related[] = $this->product_post_model->getDetail(array(
                        'select' => 'post_id, '.lang_field('post_title'),
                        'post_id' => (int)$val
                    ));
                }
            }
        }

        // Tags
        $tags = array();
        if (isset($data['post_ref_tags_id']) && $data['post_ref_tags_id']){
            $this->load->model('product/product_tags_model');
            foreach (preg_split('/\s+/', $data['post_ref_tags_id']) as $val){
                if ((int)$val){
                    $tags[] = $this->product_tags_model->getDetail(array(
                        'select' => 'tags_id, '.lang_field('tags_title_short'),
                        'tags_id' => (int)$val
                    ));
                }
            }
        }

        // List Cate
        $cate = $this->product_cate_model->getList(array(
            'select' => 'cate_id,'.lang_field('cate_title_short').', cate_ref_parent_id',
            'order_by' => lang_field('cate_title_short'),
            'order_by' => 'asc'
        ));
        
        // List Cate
        $brand = $this->product_brand_model->getList(array(
            'select' => 'brand_id,'.lang_field('brand_title_short').',brand_ref_parent_id',
            'order_by' => lang_field('brand_title_short'),
            'order_by' => 'asc'
        ));
        
        // List Cate
        $manu = $this->product_manu_model->getList(array(
            'select' => 'manu_id,'.lang_field('manu_title_short').',manu_ref_parent_id',
            'order_by' => lang_field('manu_title_short'),
            'order_by' => 'asc'
        ));
        
        // render to view
        $this->load->view('view', array
        (
                'ck_img_path'   => 'Images:/'.date('Y/m/d/', $data['post_add_date_int']).$data['post_id'].'/',
                'errors'            => $this->message->getError(),
                'message'           => $this->message->getMessage(),
                'related'           => $related,
                'tags'              => $tags,
                'brand'             => $brand,
                'manu'              => $manu,
                'cate'              => $cate,
                'filter'            => $data
        ));
    }
}
?>
