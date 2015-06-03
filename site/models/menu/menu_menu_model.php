<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_menu_model
{
    function getList($position, $order_type = 'asc')
    {
        $menu = new_table('menu', 'menu');
        $menu->where('menu_position', $position);
        $menu->order_by('menu_sort', $order_type);
        return $menu->execute()->get_result();
    }
}
?>
