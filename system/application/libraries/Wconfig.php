<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wconfig 
{
    public $config = array
    (
        'common' => array(
            'logo' => array(
                'type' => 'image',
                'title' => 'Logo',
                'value' => ''
            ),
            'desc' => array(
                'type' => 'image',
                'title' => 'Text',
                'value' => ''
            )
        ),
        'seo_home_page' => array(
            'seo_home_page_title_vi' => array(
                'type' => 'text',
                'title' => 'Tiêu Đề',
                'value' => ''
            ),
            'seo_home_page_keywords_vi' => array(
                'type' => 'text',
                'title' => 'Keywords',
                'value' => ''
            ),
            'seo_home_page_description_vi' => array(
                'type' => 'text',
                'title' => 'Description',
                'value' => ''
            )
        ),
        'seo_webshop_page' => array(
            'seo_webshop_page_title_vi' => array(
                'type' => 'text',
                'title' => 'Tiêu Đề',
                'value' => ''
            ),
            'seo_webshop_page_keywords_vi' => array(
                'type' => 'text',
                'title' => 'Keywords',
                'value' => ''
            ),
            'seo_webshop_page_description_vi' => array(
                'type' => 'text',
                'title' => 'Description',
                'value' => ''
            )
        ),
        'seo_product_page' => array(
            'seo_product_page_title_vi' => array(
                'type' => 'text',
                'title' => 'Tiêu Đề',
                'value' => ''
            ),
            'seo_product_page_keywords_vi' => array(
                'type' => 'text',
                'title' => 'Keywords',
                'value' => ''
            ),
            'seo_product_page_description_vi' => array(
                'type' => 'text',
                'title' => 'Description',
                'value' => ''
            )
        ),
        'social' => array(
            'social_youtube' => array(
                'type' => 'text',
                'title' => 'Youtube',
                'value' => ''
            ),
            'social_twitter' => array(
                'type' => 'text',
                'title' => 'Twitter',
                'value' => ''
            ),
            'social_google' => array(
                'type' => 'text',
                'title' => 'Google',
                'value' => ''
            ),
            'social_printers' => array(
                'type' => 'text',
                'title' => 'Printers',
                'value' => ''
            ),
            'social_facebook' => array(
                'type' => 'text',
                'title' => 'Facebook',
                'value' => ''
            )
        ),
        'contact' => array(
            'contact_company_name_vi' => array(
                'type' => 'text',
                'title' => 'Tên Công Ty',
                'value' => ''
            ),
            'contact_phone' => array(
                'type' => 'text',
                'title' => 'Phone',
                'value' => ''
            ),
            'contact_website' => array(
                'type' => 'text',
                'title' => 'Website',
                'value' => ''
            ),
            'contact_email' => array(
                'type' => 'text',
                'title' => 'Email Liên Hệ',
                'value' => ''
            ),
            'contact_address_vi' => array(
                'type' => 'text',
                'title' => 'Địa Chỉ',
                'value' => ''
            )
        )
    );
    
    function __construct() 
    {
        foreach (new_table('cms', 'config')->select('config_key,config_value,config_group')->execute()->get_result() as $item){
            if (isset($this->config[$item['config_group']][$item['config_key']])){
                $this->config[$item['config_group']][$item['config_key']]['value'] = $item['config_value'];
            }
        }
    }
    
    function item($group, $key){
        return isset($this->config[$group][$key]) ? $this->config[$group][$key]['value'] : false;
    }
}

?>
