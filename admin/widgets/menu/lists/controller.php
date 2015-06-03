<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_lists_widget extends MY_Widget 
{ 
	public function index()
	{
            $this->load->library('menu');
            $this->load->model('menu/menu_menu_model');
            
            $filter = array(
                'menu_position' => $this->input->get('position'),
                'order_by'      => 'menu_sort',
                'order_type'    => 'asc'
            );
            
            if (!$this->menu->in_menu($filter['menu_position'])){
                $filter['menu_position'] = '1';
            }
            
            $menus = $this->menu_menu_model->getList($filter);
            
            $this->load->view('view', array(
                'filter'    => $filter,
                'menus'     => $menus,
                'current_position_key' => $filter['menu_position'],
                'curent_position_name' => $this->menu->get_position_name($filter['menu_position']),
                'position'  => $this->menu->get_list_position()
            )); 
	}
        
}
?>
