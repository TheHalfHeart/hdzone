<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @author	TheHalfHeart@gmail.com
 * @category	Loader
 */
class MY_Input extends CI_Input
{
    public function is_post_request()
    {
            return ($this->server('REQUEST_METHOD') === 'POST');
    }
    
    public function is_get_request()
    {
            return ($this->server('REQUEST_METHOD') === 'GET');
    }
}
?>
