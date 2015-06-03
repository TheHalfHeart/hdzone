<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller 
{ 
	public function index()
	{
            if (!$this->input->is_ajax_request()){
                show_404();
            }
            
            if ($this->security->is_action('admin_login'))
            {
                define('LOGIN_SUCCESS'  , '100');
                define('LOGIN_BANDED'   , '101');
                define('LOGIN_ERROR'    , '102');
                
                $username = trim($this->input->post('username'));
                $password = trim($this->input->post('password'));
                $this->load->helper('validate');
                if (is_username($username) && strlen($password) == 32)
                {
                    $this->load->model('cms/cms_user_model');
                    $username = username_hash($username);
                    $password = password_hash($password, 3);
                    $user = $this->cms_user_model->getDetail(array(
                        'select'            => 'user_id,user_username,user_password,user_add_date_int,user_email,user_level,user_is_root,user_status',
                        'user_username_int' => $username
                    ));
                    
                    if ($user)
                    {
                        
                        if ($user['user_status'] != 1){
                            die(LOGIN_BANDED);
                        }
                        else if ($user['user_level'] > 40 || $user['user_level'] < 10){
                            die(LOGIN_ERROR);
                        }
                        else if ($user['user_password'] != $password){
                            die(LOGIN_ERROR);
                        }
                        else{
                            $this->auth->setLoggedIn($user);
                            die(LOGIN_SUCCESS);
                        }
                    }
                }
                die (LOGIN_ERROR);
            }
            die ($this->load->widget('cms/login_form'));
	}
}
?>
