<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @author		PhatPhapUngDung Dev Team
 * @category	Loader
 */
class MY_Loader extends CI_Loader 
{
        /*
         * Ten File Cache Da Ma Hoa MD5
         */
        private $__widget_cache_file_name  = null;
        
        /*
         * Đường Dẫn Tới Widget Cần Load
         */
        private $__widget_directory = null;
        
        /*
         * Version Hien Tai Cua Widget Can Load
         */
        private $__widget_cache_version    = null;
        
        /*
         * Luu Thong Tin Config Doc Tu File Config
         */
        private $__widget_cache_config = array();
        
        /*
         * Lưu Cache Cho Widget
         */
        private $__widget_is_use_cache = false;
        
        
        function __construct()
        {
            $this->_ci_ob_level  = ob_get_level();
            $this->_ci_library_paths = array('system/application/', BASEPATH, APPPATH);
            $this->_ci_helper_paths = array('system/application/', BASEPATH);
            $this->_ci_model_paths = array(APPPATH);
            $this->_ci_view_paths = array(APPPATH.'views/' => TRUE);
            
            //----------------------
            // Load file cache config
            $path = APPPATH . 'cache/widget/version.config';
            if (is_really_writable($path)){
                    $this->__widget_cache_config = json_decode(@file_get_contents($path), true);
            }
        }
        
        /*
         * Tạo Cache Widget
         */
        public function widget_cache()
        {
                $this->__widget_is_use_cache = true;
        }
        
        //---------------------------------------------------------------------
        /*
         * Load Widget
         */
        public function widget($widget_directory, $agrs = array())
        {
                //-------------------------------
                // Khởi Tạo Biến Dùng Cho Cache
                $this->__create_cache_vars($widget_directory, $agrs);
                
                //-------------------------------
                // Lấy data từ file cache
                $content = $this->__get_cache_widget();
                
                //-------------------------------
                // Nếu có data thì trả về và ngưng xử lý
                if ($content !== FALSE){
                        return $content;
                }
                
                //--------------------------------
                // Lấy path và class name của widget
                $path = APPPATH . 'widgets/'.$widget_directory.'/controller.php';
                $class_name = ucfirst(str_replace('/', '_', $widget_directory)).'_widget';
                
                if (!file_exists($path)){
                        show_error('The Widget '.$path.' Not Found');
                }
                
                //--------------------------------
                // Tạo đường dẫn để load file view trong widget
                $this->_ci_view_paths  = array(APPPATH.'widgets/'.$widget_directory.'/' => TRUE);
                
                //--------------------------------
                // Load Widget
                require_once($path);
                
                if (!class_exists($class_name)){
                        show_error("Class Name Widget $class_name Not Found, URL Is $path");
                }
                
                $MD = new $class_name;
                
                if (!method_exists($MD, 'index')){
                        show_error("Method Index Of Widget $class_name Not Found, URL Is $path");
                }
                
                ob_start();
                call_user_func_array(array($MD, 'index'), $agrs);
                $content = ob_get_contents();
                ob_end_clean();
                
                //--------------------------------
                // Lưu Cache Và Return Kết Quả
                $this->__save_cache_widget($content);
                $this->_ci_view_paths = array(APPPATH.'views/' => TRUE);
                $this->__widget_cache_version = null;
                
                return $content;
        }
        
        //---------------------------------------------------------------------
        /*
         * Tạo các biến xử lý trong việc load widget
         */
        private function __create_cache_vars($widget_directory, $agrs = array())
        {
                $this->__widget_cache_file_name = md5($widget_directory.serialize($agrs));
                $this->__widget_directory = $widget_directory;
        }
        
        //---------------------------------------------------------------------
        /*
         * Lấy Cache Widget
         * Nó sẽ kiểm tra có file cache không. Nếu không có thì return về false
         * Hoặc thời gian cache không đúng với version trong file config thì cũng return về false
         */
        private function __get_cache_widget()
        { 
                //------------------------------
                // Nếu trong file config ko có widget này thì return false
                if (isset($this->__widget_cache_config[$this->__widget_directory]))
                {
                        if (isset($this->__widget_cache_config[$this->__widget_directory]['version'])){
                                $this->__widget_cache_version = intval($this->__widget_cache_config[$this->__widget_directory]['version']);
                        }
                        if (isset($this->__widget_cache_config[$this->__widget_directory]['timer']) && is_array($this->__widget_cache_config[$this->__widget_directory]['timer'])){
                                $timer = $this->__widget_cache_config[$this->__widget_directory]['timer'];
                        }
                }
                
                //------------------------------
                // Trường hợp thông tin version không có. tức là widget hiện tại khong có sử dụng chức năng cache
                if (empty($this->__widget_cache_version)){
                        return FALSE;
                }
                
                //------------------------------
                // Duong Dan Den File Cache
                $path = APPPATH.'cache/widget/'.$this->__widget_directory.'/'.$this->__widget_cache_file_name;
                
                //------------------------------
                // Nếu widget cần gọi ko tồn tại
                if (!file_exists($path)){
                         return FALSE;
                }
                
                //------------------------------
                // Lay noi dung, Kiểm tra nội dung trong file cache có đúng cấu trúc JSON ko? nếu không thì return false
                $content = json_decode(@file_get_contents($path), true);
                if ($content == null){
                         return FALSE;
                }
                
                //------------------------------
                // Kiểm Tra thời gian nàm trong file cache
                if (!isset($content['version'])){
                        return FALSE;
                }
                
                //------------------------------
                // Xử Lý Timer
                if (!empty($timer))
                {
                        $is_reload_version_file = false;
                        array_multisort($timer);
                        foreach ($timer as $key => $time)
                        {
                                $time = intval($time);
                                if (time() >= $time && $time > $this->__widget_cache_version)
                                {
                                        $this->__widget_cache_version = $time;
                                        unset($timer[$key]);
                                        $is_reload_version_file = true;
                                        break;
                                }
                                else if ($time <= $this->__widget_cache_version)
                                {
                                        $is_reload_version_file = true;
                                        unset($timer[$key]);
                                }
                        }
                        
                        $this->__widget_cache_config[$this->__widget_directory] = array(
                                'timer'     => $timer,
                                'version'   => $this->__widget_cache_version
                        );
                        
                        if ($is_reload_version_file){
                                @file_put_contents(APPPATH.'cache/widget/version.config', json_encode($this->__widget_cache_config));
                        }
                }
                
                //-------------------------------
                // Neu thoi gian cache da cu~. Reload
                if ($content['version'] != $this->__widget_cache_version){
                        return FALSE;
                }
                
                return isset($content['data']) ? $content['data'] : FALSE;
        }
        
        //---------------------------------------------------------------------
        /*
         * Add Timer
         */
        function add_timer($widget, $time)
        {
                $path = APPPATH.'cache/widget/version.config';
                if (file_exists($path) && is_really_writable($path))
                {
                        if (!file_exists($path))
                        {
                                $fp = @fopen($path, "w+");
                                if (!$fp){
                                        return FALSE;
                                }
                                fclose($fp);
                                @chmod($path, FILE_WRITE_MODE);
                        }
                        $config = json_decode(@file_get_contents($path), true);
                        $config[$widget]['timer'][] = $time;
                        @file_put_contents($path, json_encode($config));
                        return TRUE;
                }
                return FALSE;
        }
        
        //---------------------------------------------------------------------
        // Hàm Thêm Cache Config Widget
        private function __add_cache_config($widget_dir)
        {
                $path = APPPATH.'cache/widget';
                if (is_really_writable($path))
                {
                        $path .= '/version.config';
                        if (!file_exists($path))
                        {
                                $fp = @fopen($path, "w+");
                                if (!$fp){
                                        return FALSE;
                                }
                                fclose($fp);
                                @chmod($path, FILE_WRITE_MODE);
                        }
                        $config = json_decode(@file_get_contents($path), true);
                        $time = time();
                        $config[$widget_dir] = array(
                                'version'   => $time,
                                'timer'     => array()
                        );
                        @file_put_contents($path, json_encode($config));
                        return $time;
                }
                return FALSE;
        }
        
        //---------------------------------------------------------------------
        // Lưu Cache Widget
        private function __save_cache_widget($data)
        {
                // Co su dung cache ko
                if (!$this->__widget_is_use_cache){
                        return FALSE;
                }
                
                // Neu chua co trong widget config thi phai add vao
                if (!$this->__widget_cache_version){
                        $this->__widget_cache_version = $this->__add_cache_config($this->__widget_directory);
                }
                
                // Kiem tra lan cuoi cung cho chac an
                if (!$this->__widget_cache_version){
                        return FALSE;
                }
                
                // Luu Cache
                $path = APPPATH.'cache/widget';
                
                if (is_really_writable($path))
                {
                        // Tạo SubFolder Cache
                        $folders = explode('/', $this->__widget_directory);
                        foreach ($folders as $folder)
                        {
                                $path .= '/'.$folder;
                                if (!is_dir($path)){
                                        mkdir($path);
                                }
                        }
                        $path .= '/'.$this->__widget_cache_file_name;
                        
                        // Content
                        $contents = array(
                                'version'       => $this->__widget_cache_version,
                                'data'          => $data
                        );
                        
                        // Ghi File Cache
                        if ( ! $fp = @fopen($path, FOPEN_WRITE_CREATE_DESTRUCTIVE)){
                            return FALSE;
                        } 
                        
                        flock($fp, LOCK_EX);
                        fwrite($fp, json_encode($contents));
                        flock($fp, LOCK_UN);
                        fclose($fp);
                        return TRUE;
                }
                return FALSE;
        }
        
        // --------------------------------------------------------------------

	/**
	 * Model Loader
	 *
	 * This function lets users load and instantiate models.
	 *
	 * @param	string	the name of the class
	 * @param	string	name for the model
	 * @param	bool	database connection
	 * @return	void
	 */
	public function model($model, $name = '', $db_conn = FALSE)
	{
		if (is_array($model))
		{
			foreach ($model as $babe)
			{
				$this->model($babe);
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);

			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		$model = strtolower($model);

		foreach ($this->_ci_model_paths as $mod_path)
		{
			if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))
			{
				continue;
			}

			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
			{
				if ($db_conn === TRUE)
				{
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}

			require_once($mod_path.'models/'.$path.$model.'.php');

			$model = ucfirst($model);

			$CI->$name = new $model();

			$this->_ci_models[] = $name;
			return;
		}

		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}
}
?>
