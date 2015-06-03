<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth 
{
    private $__session_key = '';
    
    private $__info = array
    (
        'user_id'           => '',
        'user_username'     => '',
        'user_add_date_int' => '',
        'user_email'        => '',
        'user_label'        => '',
        'user_is_root'      => false,
        'user_level'        => 0,
        'user_level_title' => ''
    );
    
    private $__level = array
    (
        10   => 'Admin',
        20   => 'Quản Lý',
        30   => 'Nhân Viên',
        40   => 'Cộng Tác Viên',
    );
    
    function __construct()
    {
        $CI = & get_instance();
        $this->__session_key = md5($CI->input->ip_address().$CI->input->user_agent().'$$');
        $info = $CI->session->userdata($this->__session_key);
        if (isset($info['user_id']) && $info['user_level'] >= 10 && $info['user_level'] <= 50){
            $this->__info['user_id']            = $info['user_id'];
            $this->__info['user_username']      = $info['user_username'];
            $this->__info['user_add_date_int']  = $info['user_add_date_int'];
            $this->__info['user_email']         = $info['user_email'];
            $this->__info['user_is_root']       = $info['user_is_root'];
            $this->__info['user_level']         = $info['user_level'];
            $this->__info['user_level_title']   = $this->__level[$info['user_level']];
        }
    }
    
    // Nếu username = false thì là avatar hiện tại của người dùng
    function getAvatar($username = false, $add_date_int = false)
    {
        if ($username == false){
            $username = $this->__info['user_username'];
            $add_date_int = $this->__info['user_add_date_int'];
        }
        $path = 'upload/user/images/'.date('Y/m/d', $add_date_int ? $add_date_int : '0').'/'.username_hash($username).'.jpg';
        return file_exists($path) ? $path : 'upload/user/images/default/no-avatar.jpg';
    }
    
    function getLevelList(){
        return $this->__level;
    }
    
    function getLevelName($key){
        return isset($this->__level[$key]) ? $this->__level[$key] : '';
    }
    
    function getItem($key){
        return isset($this->__info[$key]) ? $this->__info[$key] : false;
    }
    
    function setLoggedIn($info){
        $CI = & get_instance();
        $CI->session->set_userdata($this->__session_key, array(
            'user_id'       => $info['user_id'],
            'user_username' => $info['user_username'],
            'user_add_date_int' => $info['user_add_date_int'],
            'user_email'    => $info['user_email'],
            'user_is_root'  => $info['user_is_root'] ? true : false,
            'user_level'    => $info['user_level']
        ));
    }
    
    function setLogout(){
        $CI = & get_instance();
        $CI->session->unset_userdata($this->__session_key);
    }
    
    function isLoggedIn(){
        return ($this->__info['user_level'] >= 10 && $this->__info['user_level'] <= 60);
    }
    
    function isManager(){
        return ($this->__info['user_level'] >= 10 && $this->__info['user_level'] <= 40);
    }
    
    function isRoot(){
        return $this->__info['user_is_root'];
    }
    
    function isAdmin(){
        return ($this->__info['user_level'] == 10);
    }
    
    function isEditor(){
        return ($this->__info['user_level'] == 20);
    }
    
    function isAuthor(){
        return ($this->__info['user_level'] == 30);
    }
    
    function isContributor(){
        return ($this->__info['user_level'] == 40);
    }
    
    function isSupperMember(){
        return ($this->__info['user_level'] == 50);
    }
    
    function isMember(){
        return ($this->__info['user_level'] == 60);
    }
}

?>
