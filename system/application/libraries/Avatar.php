<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avatar 
{
    var $error = array(
        'upload_no_file_selected' => 'Bạn chưa chọn file',
        'upload_invalid_filetype'   => 'Chỉ chấp nhận file hình (gif, jpg, png)',
        'upload_invalid_filesize' => 'Dung lượng tối đa là 400kbs',
        'upload_invalid_dimensions' => 'Chiều dài và chiều rộng tối đa là 250px',
        'upload_invalid_other' => 'Vui lòng kiểm tra lại định dạng, kích thước file'
    );
    
    function show_error($key){
        return isset($this->error[$key]) ? $this->error[$key]  : '';
    }
    
    // Tối đa 400kb
    // Rộng 250px;
    // Cao 250px;
    function upload($username, $user_add_date_int, $file_name)
    {
        if (!isset($_FILES[$file_name])){
            return true;
        }
        
        $username = username_hash($username);
        
        $config = array();
        $config['upload_path']  = 'upload/user/tmp/';
        $config['allowed_types']= 'gif|jpg|png';
        $config['max_size']	= '400';
        $config['max_width']    = '250';
        $config['max_height']   = '250';
        $config['file_name']     = $username;
        
        $CI = & get_instance();
        
        $CI->load->library('upload', $config);
        
        // validate file 
        if (@$CI->upload->do_upload($file_name))
        {
            
            $data = $CI->upload->data();
            
            // Path Tmp
            $path = $config['upload_path'].$data['file_name'];
            
            if (file_exists($path))
            {
                // Resize Image
                $config = array();
                $config['image_library']= 'gd2';
                $config['source_image'] = $path;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']        = 150;
                $config['height']       = 150;
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();
                $CI->image_lib->convert('jpg', true);
                
                // Move To Avatar Image
                $new_path = 'upload/user/images/'.date('Y/m/d',$user_add_date_int).'/'.$username.'.jpg';
                @rename(preg_replace('/^(.+)(\.(.*))$/', '$1.jpg', $path), $new_path);
                return true;
            }
            else{
                return array($this->error['upload_invalid_other']);
            }
        }
        else
        {
            // Return Error
            $error = array();
            foreach ($CI->upload->get_errors() as $val){
                $error[] = isset($this->error[$val]) ? $this->error[$val] : '';
            }
            return !empty($error) ? $error : array($this->error['upload_invalid_other']);
        }
        return false;
    }
}

?>
