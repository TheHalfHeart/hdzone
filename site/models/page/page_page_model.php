<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page_page_model
{
    private $__page = null;
            
    function __construct(){
        $this->__page = new_table('page', 'page');
    }
    
    // Get Detail
    function getDetail($filter = array()){
        $this->__page->clear();
        if (isset($filter['select'])){
            $this->__page->select($filter['select']);
        }
        if (isset($filter['page_slug_int'._LANG])){
            $this->__page->where('page_slug_int'._LANG, $filter['page_slug_int'._LANG]);
        }
        
        return $this->__page->execute()->get_result(0);
    }
}
?>
