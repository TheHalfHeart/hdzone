<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Menu_add_widget extends MY_Widget 
    {
        function index($filter = array()) 
        {
            $this->load->library('menu');
            $this->load->model('menu/menu_menu_model');
            
            $position = (int)$this->input->get('position');
            
            foreach ($filter as & $item){
                $item = quotes_to_entities($item);
            }
            
            if (!isset($filter['menu_position'])){
                $filter['menu_position'] = $position;
            }
            
            if (!$this->menu->in_menu($filter['menu_position'])){
                return false;
            }
            
            $filter['order_by'] = 'menu_sort';
            $filter['order_type'] = 'asc';
            
            $menus = $this->menu_menu_model->getList($filter);
            
            $this->load->view('view', array
            (
                    'errors'    => $this->message->getError(),
                    'menus'     => $menus,
                    'message'   => $this->message->getMessage(),
                    'position'  => $this->menu->get_list_position(),
                    'filter'    => $filter
            ));
        }
    }
?>
