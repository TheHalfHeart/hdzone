<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_user_model
{
    private $__user = null;
    
    function __construct() {
        $this->__user = new_table('cms', 'user');
    }
    
    // Detail
    function getDetail($filter)
    {
        $this->__user->clear();
        
        if (isset($filter['select'])){
            $this->__user->select($filter['select']);
        }
        
        if (isset($filter['user_id'])){
            $this->__user->where('user_id', (int)$filter['user_id']);
        }
        
        if (isset($filter['user_username_int'])){
            $this->__user->where('user_username_int', $filter['user_username_int']);
        }
        
        return $this->__user->execute()->get_result(0);
    }
}
?>
