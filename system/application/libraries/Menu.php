<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu
{
    private $__position = array(
        1 => 'Menu Chính (Trái)'
    );
    
    // Lấy danh sách position
    function get_list_position(){
        return $this->__position;
    }
    
    // Kiểm tra có trong menu không
    function in_menu($key){
        return isset($this->__position[$key]);
    }
    
    // Lấy tên position
    function get_position_name($key){
        return isset($this->__position[$key]) ? $this->__position[$key] : false;
    }
    
    // Đưa danh sách menu thành đối tượng trong javascript
    function to_js_list($menus){
        echo '<script language="javascript"> var menus = new Array(); var tmp = {};';
        foreach ($menus as $item){
            echo 'tmp = {};';
            foreach ($item as $key => $val)
            {
                echo 'tmp.'.$key.'="'.$val.'";';
            }
            echo 'menus.push(tmp);';
        }
        echo '</script>';
    }
    
    // Đệ quy hiển thị menu trong admin
    function admin_show_list($menus, $id_parent = 0)
    {
        // Step1
        $menu_tmp = array();
        $menu_callback = array();
        $n = count($menus);
        for ($i = 0; $i < $n; $i++)
        {
            if ($menus[$i]['menu_ref_parent_id'] == $id_parent){
                $menu_tmp[] = $menus[$i];
            }
            else{
                $menu_callback[] = $menus[$i];
            }
        }

        // Step 2
        if ($menu_tmp)
        {
            echo '<ul>';
            foreach ($menu_tmp as $item) 
            {
                echo '<li>';
                echo '<div class="wrapperbox">
                        <a href="#" parentid="'.$item['menu_ref_parent_id'].'" idval="'.$item['menu_id'].'"><span style="display:inline-block; color: blue; width: 40px;">'.$item['menu_sort'].' > </span> '.$item[lang_default_field('menu_title')].'</a>
                        <div class="box-quickedit">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Tên Hiển Thị:</td>
                                        <td><div class="multilang" type="text" id="menu_title_'.$item['menu_id'].'" name="menu_title_'.$item['menu_id'].'" value="'._lang_val($item, 'menu_title', false).'" maxlength="500" size="100"></div></td>
                                    </tr>
                                    <tr>
                                        <td>Link:</td>
                                        <td><div class="multilang" type="text" id="menu_link_'.$item['menu_id'].'" name="menu_link_'.$item['menu_id'].'" value="'._lang_val($item, 'menu_link', false).'" maxlength="500" size="100"></div></td>
                                    </tr>
                                    <tr>
                                        <td>Class:</td>
                                        <td><input type="text" value="'.$item['menu_class'].'" size="100" id="menu_class_'.$item['menu_id'].'"></td>
                                    </tr>
                                    <tr>
                                        <td>Thứ tự:</td>
                                        <td>
                                            <input  onkeypress="return onlyNumbers(event)" type="text" value="'.$item['menu_sort'].'" size="10" id="menu_sort_'.$item['menu_id'].'">
                                            <span>Menu cha: </span>
                                            <select style="width:100px;" id="menu_ref_parent_id_'.$item['menu_id'].'">
                                            </select>
                                            <span>Tab hiển thị: </span>
                                            <select style="width: 80px;" id="menu_target_'.$item['menu_id'].'">
                                                <option value="1">Hiện tại</option>
                                                <option value="2" '.(($item['menu_target'] == '2') ? 'selected="selected"' : '').'>Tab mới</option>
                                            </select>
                                            <input type="button" value="Lưu" idval="'.$item['menu_id'].'" class="btn-save-menu"/>
                                            <input type="button" value="Xóa" idval="'.$item['menu_id'].'" class="btn-delete-menu"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>';
                $this->admin_show_list($menu_callback, $item['menu_id']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
} 


?>
