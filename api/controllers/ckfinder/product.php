<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller 
{
    function connector($id = 0, $type = 'Images') 
    {
        define('ROOT_CKFINDER', './public/ckfinder/');
        define('FOLDER', 'product');
        define('BASE_URL_FULL', $this->config->base_url('upload/product'));

        // Biến lưu trữ access control
        $AccessControl = array();
        
        // Thông số image resize
        $imageSize = array(
            'smallThumb'    => '90x90',
            'mediumThumb'   => '150x150',
            'largeThumb'    => '335x220'
        );
        
        // Plugin được sử dụng
        $plugins = array(
            'imageresize' => true,
            'fileeditor' => true,
            'zip' => true
        );
        
        // Phân quyền an toàn cho hệ thống
        $AccessControl[] = array(
            'role'          => '*',
            'resourceType'  => '*',
            'folder'        => '/',
            'folderView'    => false,
            'folderCreate'  => false,
            'folderRename'  => false,
            'folderDelete'  => false,
            'fileView'      => false,
            'fileUpload'    => false,
            'fileRename'    => false,
            'fileDelete'    => false
        );
        
        // Xử lý kiểm tra dữ liệu
        if (!$id){
            define('CAN_USE_CKFINDER', false);
        }
        else if (!$this->auth->isAdmin() && !$this->auth->isEditor()){
            define('CAN_USE_CKFINDER', false);
        }
        else 
        {
            $post = new_table('product', 'post')->select('post_add_date_int,post_add_user_username,post_timer_date_time_int')->where('post_id', (int)$id)->execute()->get_result(0);
            if (!$post || $post['post_add_user_username'] != $this->auth->getItem('user_username')){
                define('CAN_USE_CKFINDER', false);
            }
            else if ($this->auth->isContributor() && $post['post_timer_date_time_int'] != timer_private()){
                define('CAN_USE_CKFINDER', false);
            }
            else
            {
                define('CAN_USE_CKFINDER', true);
                
                $path = date('Y/m/d/', $post['post_add_date_int']).$id;
                $p_arr = explode('/', $path);
                
                // Khởi tạo lại biến phân quyền
                $AccessControl = array();
                
                // Check Path
                $AccessControl[] = array(
                    'role'          => '*',
                    'resourceType'  => $type,
                    'folder'        => '/',
                    'folderView'    => true,
                    'folderCreate'  => false,
                    'folderRename'  => false,
                    'folderDelete'  => false,
                    'fileView'      => true,
                    'fileUpload'    => false,
                    'fileRename'    => false,
                    'fileDelete'    => false
                );
                $AccessControl[] = array(
                    'role'          => '*',
                    'resourceType'  => $type,
                    'folder'        => '/'.$p_arr[0].'/'.$p_arr[1].'/'.$p_arr[2].'/'.$p_arr[3],
                    'folderView'    => true,
                    'folderCreate'  => false,
                    'folderRename'  => false,
                    'folderDelete'  => false,
                    'fileView'      => true,
                    'fileUpload'    => true,
                    'fileRename'    => true,
                    'fileDelete'    => true
                );
            }
        }
        require (ROOT_CKFINDER . 'core/connector/php/connector.php');
    }
    
    function html($id = false) {
        $this->load->view('ckfinder/product_view', array(
            'id' => $id
        ));
    }
}

?>
