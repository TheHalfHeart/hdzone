<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Product_manu extends CI_Controller 
{
    function connector($id = 0, $type = 'Images') 
    {
        define('ROOT_CKFINDER', './public/ckfinder/');
        define('FOLDER', 'product_manu');
        define('BASE_URL_FULL', $this->config->base_url('upload/product_manu'));

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
            $manu = new_table('product', 'manu')->select('manu_add_date_int')->where('manu_id', (int)$id)->execute()->get_result(0);
            if (!$manu){
                define('CAN_USE_CKFINDER', false);
            }
            else
            {
                define('CAN_USE_CKFINDER', true);
            
                // Khởi tạo lại biến phân quyền
                $AccessControl = array();

                // Check Path
                $AccessControl[] = array(
                    'role'          => '*',
                    'resourceType'  => $type,
                    'folder'        => '/',
                    'folderView'    => true,
                    'folderCreate'  => true,
                    'folderRename'  => false,
                    'folderDelete'  => false,
                    'fileView'      => true,
                    'fileUpload'    => true,
                    'fileRename'    => true,
                    'fileDelete'    => true
                );

                $AccessControl[] = array(
                    'role'          => '*',
                    'resourceType'  => $type,
                    'folder'        => '/*',
                    'folderView'    => true,
                    'folderCreate'  => true,
                    'folderRename'  => true,
                    'folderDelete'  => true,
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
        $this->load->view('ckfinder/product_manu_view', array(
            'id' => $id
        ));
    }
}

?>
