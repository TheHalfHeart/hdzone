<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Ho_Chi_Minh');
/**
 * @package	CodeIgniter
 * @subpackage	Core
 * @author      Freetuts Dev Team
 * @category	Output
 */

class MY_Output extends CI_Output 
{
    
    protected $_cache_folder    = '';
    protected $_cache_file_name = '';
    protected $_cache_version   = null;
    
    // --------------------------------------------------------------------
    /*
     * Add Timer
     */
    public function add_timer($apppath, $folder, $time)
    {

            $path = $apppath.'cache/page/version.config';
            if (!file_exists($path))
            {
                    if (!$this->__create_cache_version($apppath))
                    {
                            return FALSE;
                    }
            }
            
            $config = json_decode(@file_get_contents($path), true);
            $config = (empty($config)) ? array() : $config;
            
            if (!in_array($time, $config[$folder]['timer']))
            {
                $config[$folder]['timer'][] = $time;
                @file_put_contents($path, json_encode($config));
            }
            return TRUE;
    }
    
    // --------------------------------------------------------------------
    /*
     * Clear File Cache
     */
    public function clear_cache($apppath, $folder, $time = NULL)
    {
            if (is_really_writable($apppath.'cache/page/version.config'))
            {
                    $config = json_decode(@file_get_contents($apppath.'cache/page/version.config'), true);
                    if (!empty($config))
                    {
                            $config[$folder]['version'] = empty($time) ? $time : time();
                            @file_put_contents($apppath.'cache/page/version.config', json_encode($config));
                            return true;
                    }
            }
            return false;
    }
    
    // --------------------------------------------------------------------
    /*
     * Khoi tao file version cache
     */
    private function __create_cache_version($apppath)
    {
            $path = $apppath.'cache/page';
            if (is_really_writable($path))
            {   
                    $path .= '/version.config';
                    
                    $content = array();
                    
                    if (file_exists($path))
                    {
                        $content = json_decode(file_get_contents($path), true);
                    }
                    else
                    {
                        if ( ! $fp = @fopen($path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE) ){
                                return FALSE;
                        }
                        fclose($fp);
                        @chmod($path, FILE_WRITE_MODE);
                    }
                    
                    if (empty($content)){
                        $content = array();
                    }
                    $time = time();
                    $content[$this->_cache_folder] = array('version' => $time, 'timer' => array());
                    @file_put_contents($path, json_encode($content));
                    return $time;
            }
            return FALSE;
    }
    
    // --------------------------------------------------------------------
    /*
     * Ghi file cache
     */
    function _write_cache($output)
    {
            //-------------------------------
            // Kiem tra co version hien tai ko
            if (empty($this->_cache_version)){
                    $this->_cache_version = $this->__create_cache_version(APPPATH);
            }

            //-------------------------------
            // Kiem tra co version ko
            if (empty($this->_cache_version)){
                    return;
            }
            
            //-------------------------------
            // Xu ly duong dan toi file cache
            $pathfile = APPPATH.'cache/page';

            if ( ! is_dir($pathfile) OR ! is_really_writable($pathfile))
            {
                    log_message('error', "Unable to write cache file: ".$cache_path);
                    return;
            }

            //-------------------------------
            // Tao Folder Chua File Cache
            if ($this->_cache_folder)
            {
                    foreach (explode('/', $this->_cache_folder) as $folder)
                    {
                            $pathfile .= '/'.$folder;
                            if (!is_dir($pathfile))
                            {
                                    mkdir($pathfile);
                            }
                    }
            }

            //-------------------------------
            // Duong dan full toi file cache
            $pathfile .= '/'.$this->_cache_file_name;

            if ( ! $fp = @fopen($pathfile, FOPEN_WRITE_CREATE_DESTRUCTIVE))
            {
                    log_message('error', "Unable to write cache file: ".$cache_path);
                    return;
            }

            if (flock($fp, LOCK_EX))
            {
                    fwrite($fp, $this->_cache_version.'TS--->'.($output));
                    flock($fp, LOCK_UN);
            }
            else
            {
                    log_message('error', "Unable to secure a file lock for file at: ".$cache_path);
                    return;
            }

            fclose($fp);
            @chmod($pathfile, FILE_WRITE_MODE);

            log_message('debug', "Cache file written: ".$pathfile);
    }
    
    // --------------------------------------------------------------------
    /*
     * Đọc file cache và hiển thị
     */
    function _display_cache(&$CFG, &$URI)
    {
        //-------------------------------
        // cache_folder chua duong dan folder can tao
        // cache_page_file_name chua ten cua file cache
        $this->_cache_folder        = (($URI->subfolder !== null) ? $URI->subfolder . '/' : '' ) . $URI->rsegments[1];
        $this->_cache_file_name     = md5($CFG->item('index_page').'/'.$URI->uri_string);
        
        //-------------------------------
        // lấy thông tin file check cache
        if (file_exists(APPPATH.'cache/page/version.config'))
        {
                $config = json_decode(@file_get_contents(APPPATH.'cache/page/version.config'), true);
                if (isset($config[$this->_cache_folder]['version'])){
                        $this->_cache_version = intval($config[$this->_cache_folder]['version']);
                }  
        }
        
        //-------------------------------
        // Trường hợp này chỉ có file version không tồn tại hoặc cấu trúc JSON trong file ko đúng 
        if (empty($this->_cache_version)){
                require("MY_Widget.php");
                return FALSE;
        }
        
        //-------------------------------
        // Đường Dẫn Đầy Đủ Của File Cache
	$pathfile = APPPATH.'cache/page/'.$this->_cache_folder.'/'.$this->_cache_file_name;
        
        //-------------------------------
        // Kiểm Tra File Cache Tồn Tại Ko
        if ( !file_exists($pathfile))
        {
                require("MY_Widget.php");
                return FALSE;
        }
        
        //-------------------------------
        // Kiểm Tra File Có Quyền Đọc Không
        if ( ! $fp = @fopen($pathfile, FOPEN_READ))
        {
                require("MY_Widget.php");
                return FALSE;
        }
        
        //-------------------------------
        // Lấy Nội Dung File Cache
        flock($fp, LOCK_SH);

        $cache = '';
        if (filesize($pathfile) > 0)
        {
                $cache = fread($fp, filesize($pathfile));
        }

        flock($fp, LOCK_UN);
        fclose($fp);
        
        //-------------------------------
        // Lọc Lấy Thời Gian Từ File Cache
        if ( ! preg_match("/(\d+TS--->)/", $cache, $match)){
                require("MY_Widget.php");
                return FALSE;
        }
        $version_in_file = intval(trim(str_replace('TS--->', '', $match['1'])));
        
        //-------------------------------
        // Xử Lý Timer Hen Gio
        if (!empty($config[$this->_cache_folder]['timer']) && is_array($config[$this->_cache_folder]['timer']))
        {
                // Sap Xep Lai Thoi Gian Cache
                $is_reload_version_file = false;
                array_multisort($config[$this->_cache_folder]['timer']);
                foreach ($config[$this->_cache_folder]['timer'] as $key => $time)
                {
                        $time = intval($time);
                        if (time() >= $time && $time > $this->_cache_version)
                        {
                                $this->_cache_version = $time;
                                unset($config[$this->_cache_folder]['timer'][$key]);
                                $is_reload_version_file = true;
                                break;
                        }
                        else if ($time <= $this->_cache_version)
                        {
                                $is_reload_version_file = true;
                                unset($config[$this->_cache_folder]['timer'][$key]);
                        }
                }
                $config[$this->_cache_folder]['version'] = $this->_cache_version;
                
                if ($is_reload_version_file){
                        @file_put_contents(APPPATH.'cache/page/version.config', json_encode($config));
                }
        }
        
        //-------------------------------
        // Neu thoi gian cache da cu~. Reload
        if ($version_in_file != $this->_cache_version){
                require("MY_Widget.php");
                return FALSE;
        }

        // Display the cache
        $this->_display(str_replace($match['0'], '', $cache));
        log_message('debug', "Cache file is current. Sending it to browser.");
        return TRUE;
    }
}

?>