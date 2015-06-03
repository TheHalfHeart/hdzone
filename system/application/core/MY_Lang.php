<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @author	TheHalfHeart@gmail.com
 * @category	Loader
 */
class MY_Lang extends CI_Lang
{
    var $lang_list = array(
        'vi' => 'Tiếng Việt',
        'en' => 'Tiếng Anh'
    );
    
    var $lang_folder = array(
        'en' => 'english',
        'vi' => 'vietnam'
    );
    
    var $lang_default = 'vi';
    
    function get_lang($lang){
        return isset($this->lang_list[$lang]) ? $lang : $this->lang_default;
    }
    
    function check($lang)
    {
        if (!array_key_exists($lang, $this->lang_list)){
            $CI = get_instance();
            $CI->load->helper('url');
            redirect_301($CI->config->base_url($this->lang_default));
        }
        else{
            define('LANG', $lang);
            define('_LANG', '_'.$lang);
        }
    }
}
?>
