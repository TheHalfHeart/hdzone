<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cms_config_widget extends MY_Widget 
{
    function index($filter = array()) 
    {   
        // Fill Data
        foreach ($filter as & $item){
            $item = quotes_to_entities($item);
        }
        
        $config = new_table('cms', 'config')->select('config_id,config_group,config_key,config_value')->execute()->get_result();
        
        $wconfig = $this->wconfig->config;
         
        foreach ($config as $item){
            if (isset($wconfig[$item['config_group']][$item['config_key']])){
                $wconfig[$item['config_group']][$item['config_key']]['value'] = $item['config_value'];
            }
        }
        
        // render to view
        $this->load->view('view', array
        (
                'config'            => $wconfig
        ));
    }
}
?>
