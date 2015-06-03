<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config_edit extends CI_Controller 
{ 
	public function index()
	{
            // Not Request Ajax
            if (!$this->input->is_ajax_request()){
                show_404();
            }

            // Check For Token
            if (!$this->security->check_get_token()){
                die ($this->load->widget('cms/login_form'));
            }

            // Only Manager
            if (!$this->auth->isAdmin()){
                die ($this->load->widget('cms/login_form'));
            }
            
            $wconfig = $this->wconfig->config;
            
            $config = new_table('cms', 'config');
            
            $configList = array();
            foreach ($config->execute()->select('config_group,config_key')->get_result() as $item){
                $configList[$item['config_key']] = true;
            }
            
            foreach ($wconfig as $group => $item)
            {
                foreach ($item as $field => $ops)
                {
                    $data = array(
                        'config_group'  => $group,
                        'config_key'    => $field,
                        'config_value'  => (string)$this->input->post($field),
                        'config_last_update_user_id'        => $this->auth->getItem('user_id'),
                        'config_last_update_user_username'  => $this->auth->getItem('user_username'),
                        'config_last_update_date_time_int'  => current_date_time_to_int()
                    );
                    
                    $config->clear();
                    
                    if (isset($configList[$field])){
                        $config->where('config_key', $field)->update($data);
                    }
                    else{
                        $config->clear();
                        $config->insert($data);
                    }
                }
            }
	}
}
?>
