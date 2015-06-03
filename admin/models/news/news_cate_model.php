<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_cate_model
{
    private $__cate = null;
            
    function __construct(){
        $this->__cate = new_table('news', 'cate');
    }
    
    function edit($data, $cate_id)
    {
        $this->__cate->clear();
        if ($this->__cate->where('cate_id', $cate_id)->validate($data, 'update'))
        {
            $info = $this->__cate->execute()->get_result(0);
            
            if ($info && $this->__cate->update($data))
            {
                $data_update = array();
                lang_field_data($data_update, $info, 'post_ref_cate_title_short', 'cate_title_short');
                lang_field_data($data_update, $info, 'post_ref_cate_slug', 'cate_slug');
                lang_field_data($data_update, $info, 'post_ref_cate_slug_int', 'cate_slug_int');
                new_table('news', 'post')->where('post_ref_cate_id', $cate_id)->update($data_update);
                return true;
            }
            return false;
        }
        return $this->__page->get_error();
    }
    
    function quick_edit($field, $value, $id)
    {
        if ($field == 'cate_sort'){
            $data = array(
                'cate_sort' => $value
            );
            if ($this->__cate->where('cate_id', $id)->validate($data)){
                $this->__cate->update($data);
                return true;
            }
            return false;
        }
        else if ($field == 'cate_ref_parent_id'){
            $data = array(
                'cate_ref_parent_id' => $value
            );
            if ($this->__cate->where('cate_id', $id)->validate($data)){
                $this->__cate->update($data);
                return true;
            }
            return false;
        }
        return false;
    }
    
    function add($data)
    {
        $this->__cate->clear();
        if ($this->__cate->validate($data)){
            return $this->__cate->insert($data);
        }
        return $this->__cate->get_error();
    }
    
    function updateEditting($cate_id){
        $CI = get_instance();
        $this->__cate->clear();
        $this->__cate->where('cate_id', $cate_id)->update(array(
            'editting_date_time_int'    => current_date_time_to_int(),
            'editting_user_username'    => $CI->auth->getItem('user_username'),
            'editting_token'            => $CI->security->get_csrf_hash()
        ));
    }
    
    function delete($list_id)
    {
        $this->__cate->clear();
        $cate = $this->__cate->select('cate_id, cate_total_post,cate_ref_parent_id')->where('cate_id', $list_id)->execute()->get_result(0);
        if (!$cate || $cate['cate_total_post'] > 0){
            return 2; // Post Exists
        }
        
        if ($this->__cate->delete('cate_id = '.(int)$list_id)){
            $this->__cate->clear();
            $this->__cate->where('cate_ref_parent_id', $cate['cate_id'])->update(array(
                'cate_ref_parent_id' => $cate['cate_ref_parent_id']
            ));
            return true;
        }
        
        return 2;
    }
    
    function getDetail($filter = array()){
        $this->__cate->clear();
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        if (isset($filter['cate_id'])){
            $this->__cate->where('cate_id', $filter['cate_id']);
        }
        return $this->__cate->execute()->get_result(0);
    }
    
    function countList($filter = array())
    {
        $this->__cate->clear();
        if (isset($filter['cate_id']) && $filter['cate_id']){
            $this->__cate->where('cate_id', $filter['cate_id']);
        }
        if (isset($filter['cate_add_user_username_int']) && $filter['cate_add_user_username_int']){
            $this->__cate->where('cate_add_user_username_int', $filter['cate_add_user_username_int']);
        }
        return $this->__cate->count();
    }
    
    function clear(){
        $this->__cate->clear();
    }
    
    function getList($filter = array())
    {
        $this->__cate->clear_select();
        
        if (isset($filter['select'])){
            $this->__cate->select($filter['select']);
        }
        
        if (isset($filter['order_by']) && isset($filter['order_type']))
        {
            $sort_by = array('cate_id', 'cate_sort', 'cate_total_post');
            if (!in_array($filter['order_by'], $sort_by)){
                $filter['order_by'] = 'cate_id';
            }
            
            $sort_type = array('asc', 'desc');
            if (!in_array($filter['order_type'], $sort_type)){
                $sort_type = 'desc';
            }
            $this->__cate->order_by($filter['order_by'], $filter['order_type']);
        }
        
        if (isset($filter['limit']) && isset($filter['start'])){
            $this->__cate->limit($filter['start'], $filter['limit']);
        }
        
        return $this->__cate->execute()->get_result();
    }
    
    function show_main_list($menus, $id_parent = 0, $dem = 0) 
    {
        // Step1
        $data = array();
        $menu_callback = array();
        $n = count($menus);
        for ($i = 0; $i < $n; $i++) {
            if ($menus[$i]['cate_ref_parent_id'] == $id_parent) {
                $data[] = $menus[$i];
            } else {
                $menu_callback[] = $menus[$i];
            }
        }

        // Step 2
        if ($data) { 
                foreach ($data as $item){ ?>
                <tr>
                    <td class="center"><?php echo $item['cate_id']; ?></td>
                    <td class="left">
                        <strong style="color:blue"><?php for($i = 0; $i < $dem; $i++){ echo '-------|'; } ?></strong>
                         <?php echo $item[lang_field('cate_title_short')]; ?>
                        <?php _editting_message($item); ?>
                    </td>
                    <td>
                        <select class="quick-edit" data-field="cate_ref_parent_id" data-id="<?php echo $item['cate_id']; ?>" id="parent_id_wrapper_<?php echo $item['cate_id']; ?>" style="width:100%">
                            
                        </select>
                    </td>
                    <td class="center"><?php echo $item['cate_total_post']; ?></td>
                    <td class="center"><input type="text" style="width:50px; text-align: center" class="quick-edit" data-field="cate_sort" data-id="<?php echo $item['cate_id']; ?>" value="<?php echo $item['cate_sort']; ?>" onkeypress="return onlyNumbers(event);" /></td>
                    <td class="left"><?php echo $item['cate_add_user_username']; ?></td>
                    <td class="right">
                        <?php if (!_is_editting($item)){ ?>
                        <a title="Sửa" idval="<?php echo $item['cate_id']; ?>" href="admin.php" class="edit-click"><span class=" wrapper color-icons pencil_co"></span></a>
                        <a title="Xóa" idval="<?php echo $item['cate_id']; ?>" href="admin.php" class="delete-click"><span class=" wrapper color-icons cross_co"></span></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php $this->show_main_list($menu_callback, $item['cate_id'], $dem + 1); ?>
            <?php } ?>
        <?php
        }
    }
    
    function to_js_list($menus){
        echo '<script language="javascript"> var cate = new Array(); var tmp = {};';
        foreach ($menus as $item){
            echo 'tmp = {};';
            foreach ($item as $key => $val)
            {
                echo 'tmp.'.$key.'="'.$val.'";';
            }
            echo 'cate.push(tmp);';
        }
        echo '</script>';
    }
}
?>
