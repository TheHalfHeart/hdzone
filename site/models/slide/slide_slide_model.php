<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Slide_slide_model
{
    private $__slide = null;
            
    function __construct(){
        $this->__slide = new_table('slide', 'slide');
    }
    
    // Get List
    function getList($position)
    {
        $this->__slide->clear();
        $this->__slide->where('slide_timer_date_time_int', current_date_time_to_int(), '<=');
        $this->__slide->where('slide_position', $position);
        $this->__slide->order_by('slide_timer_date_time_int', 'desc');
        return $this->__slide->execute()->get_result();
    }
}
?>
