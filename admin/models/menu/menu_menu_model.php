<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_menu_model
{
    function add($data)
    {
        $menu = new_table('menu', 'menu');
        if ($menu->validate($data))
        {
            if ($data['menu_ref_parent_id']){
                $menu_check = new_table('menu', 'menu')->where('menu_id', $data['menu_ref_parent_id'])->count();
                if ($menu_check <= 0){
                    return array(
                        'menu_ref_parent_id' => 'Không tìm thấy menu cha'
                    );
                }
            }
            return $menu->insert($data);
        }
        return $menu->get_error();
    }
    
    function update($data, $menu_id)
    {
        $menu = new_table('menu', 'menu');
        if ($menu->where('menu_id', $menu_id)->validate($data, 'update')){
            return $menu->update($data);
        }
        return false;
    }
    
    function delete($menu_id){
        $menu = new_table('menu', 'menu');
        $current = $menu->where('menu_id', $menu_id)->execute()->get_result(0);
        if ($current){
            $menu->clear()->delete("menu_id = ".(int)$menu_id);
            $menu->clear()->where('menu_ref_parent_id', $current['menu_id'])->update(array(
                'menu_ref_parent_id' => $current['menu_ref_parent_id']
            ));
            return true;
        }
        return false;
    }
    
    function getDetail($filter = array())
    {
        $menu = new_table('menu','menu');
        if (isset($filter['menu_id'])){
            $menu->where('menu_id', (int)$filter['menu_id']);
        }
        return $menu->execute()->get_result(0);
    }
    
    function getList($filter = array())
    {
        $menu = new_table('menu', 'menu');
        if (isset($filter['menu_position'])){
            $menu->where('menu_position', $filter['menu_position']);
        }
        if (isset($filter['order_by']) && isset($filter['order_type'])){
            $menu->order_by($filter['order_by'], $filter['order_type']);
        }
        return $menu->execute()->get_result();
    }
}
?>
