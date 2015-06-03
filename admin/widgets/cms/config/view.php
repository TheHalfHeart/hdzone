<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="breadcrumb">
    <a href="admin.php#cms/dashboard">Trang Chủ</a> ::
    <a href="admin.php#cms/config">Cấu Hình</a>
</div>
<div class="box">
    <div class="heading">
        <h1><img alt="" src="public/admin/image/home.png">Cấu hình hệ thống</h1>
        <div class="buttons">
             <a class="button" id="click-save">Lưu</a>
        </div>
    </div>
    <div class="content">
        <div class="htabs" id="tabs">
            <?php foreach ($config as $key => $item){ ?>
            <a href="#tab-<?php echo $key; ?>"><?php echo ucfirst($key); ?></a>
            <?php } ?>
        </div>
        <form id="form" onsubmit=" return false;" method="post">
            <?php foreach ($config as $group => $item){ ?>
            <div id="tab-<?php echo $group; ?>">
                <table class="form">
                    <tbody>
                        <?php foreach ($item as $key => $cf){ ?>
                        <tr>
                            <td>
                                <strong><?php echo $cf['title']; ?></strong>
                            </td>
                            <td>
                                <?php switch ($cf['type']){         
                                case "text":{ ?>
                                    <input type="text" id="<?php echo $key; ?>" value="<?php _val($cf, 'value'); ?>" size="100" maxlength="555"/>
                                <?php break; }
                                case "text-multilang":{ ?>
                                    <div class="multilang" type="textarea" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php _lang_val($cf, 'value'); ?>" maxlength="1000" cols="100" rows="5"></div>
                                <?php break; }
                                case "image":{ ?>
                                    <?php _image_config($cf, 'value', $key); ?>
                                <?php break; }
                                case "ckeditor":{ ?>
                                    <textarea id="<?php echo $key; ?>" cols="100" rows="3"><?php _val($cf, 'value'); ?></textarea>
                                    <script language="javascript">
                                        jsAdmin.loadCkeditorSort('<?php echo $key; ?>');
                                    </script>
                                <?php break; }
                                case "ckeditor-multilang":{ ?>
                                    <textarea id="<?php echo $key; ?>" cols="100" rows="3"><?php _val($cf, 'value'); ?></textarea>
                                    <div class="multilang" type="ckeditor" toolbar="short" ck-module="config" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php _lang_val($cf, 'value'); ?>"></div>
                                <?php break; }
                                case "checkbox":{ ?>
                                    <?php foreach ($cf['options'] as $chkey => $chval){ ?>
                                    <?php $arr = explode('|', $cf['value']); ?>
                                    <input <?php echo (in_array($chkey, $arr)) ? 'checked' : ''; ?> type="checkbox" value="<?php echo $chkey; ?>" id="cb<?php echo $key.$chkey; ?>" name="<?php echo $key; ?>" />
                                    <label for="cb<?php echo $key.$chkey; ?>"><?php echo $chval; ?></label>
                                    <?php } ?>
                                <?php break; }
                                case "select" : { ?>
                                    <select id="<?php echo $key; ?>">
                                        <?php foreach ($cf['options'] as $sekey => $seval){ ?>
                                        <option <?php echo ($sekey == $cf['value']) ? 'selected' : ''; ?> value="<?php echo $sekey; ?>"><?php echo $seval; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php break; }
                                case "radio" : {?>
                                    <?php foreach ($cf['options'] as $rdkey => $rdval){ ?>
                                    <input <?php echo ($rdkey == $cf['value']) ? 'checked' : ''; ?> type="radio" name="<?php echo $key; ?>" value="<?php echo $rdkey; ?>" id="rd<?php echo $key.$rdkey; ?>" />
                                    <label for="rd<?php echo $key.$rdkey; ?>"><?php echo $rdval; ?></label>
                                    <?php } ?>
                                 <?php break; }
                                case "textarea" : { ?>
                                    <textarea id="<?php echo $key; ?>" cols="100" rows="5"><?php _val($cf, 'value'); ?></textarea>
                                <?php }
                                    ?>
                               <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </form>
    </div>
</div>
<script language="javscript" type="text/javascript">
    $(document).ready(function()
    {
        jsAdmin.ckfinder.connectorPath = jsAdmin.linkApi + '/ckfinder/config/connector/1000/Images';
        
        // Lang
        jsAdmin.loadLang();
        
        // Title Page
        jsAdmin.changeTitle('Cấu hình hệ thống');
        
        // Menu
        jsAdmin.changeMenu('cms/config');
        
        // Tabs
        jsAdmin.loadTabs('tabs');
        
        $('#click-save').click(function()
        {
            var data = {};
            <?php 
            foreach ($config as $group => $item){
                foreach ($item as $field => $ops){
                    switch ($ops['type']) {
                        case "text" : case "textarea" : case "select" : case "image" : {
                            echo "data['$field'] = $('#$field').val();";
                        break ;}
                        case "ckeditor" : {
                            echo "data['$field'] = CKEDITOR.instances['$field'].getData();";
                        break ;}
                        case "checkbox" : {
                            echo "data['$field'] = jsAdmin.getListCheckboxChecked('input[name=\"$field\"]:checked', '|');";
                        break ;}
                        case "radio" : {
                            echo "data['$field'] = $('input[name=\"$field\"]:checked').val();";
                        break ;}
                    }
                }
            }
            ?>
            
            jsAdmin.sendAjax('post', 'text', data, 'cms/config_edit', function (result)
            {
                jAlert('Cập nhật thành công', 'Thành công');
            });
            
        });
        
    });    
</script>

