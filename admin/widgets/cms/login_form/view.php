<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading" style="background:#368ee0; border: none;  border-left:solid 5px #368ee0; border-right:solid 5px #368ee0">
        <h1 style="color: #FFF !important"><img src="public/admin/image/lockscreen.png" alt="" />Đăng nhập vào hệ thống</h1>
    </div>
    <div class="content" style="min-height: 150px; border-top:none !important; border:solid 5px #368ee0; overflow: hidden;">
        <?php if ($message){ ?>
        <div class="warning"><?php echo $message; ?></div>
        <?php } ?>
        <form action="" onsubmit="return false;" method="post" enctype="multipart/form-data" id="form">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;" rowspan="4"><img width="87px" height="114px" src="public/admin/image/login.png" alt="Please enter your login details." /></td>
                </tr>
                <tr>
                    <td>Tên đăng nhập:<br />
                        <input type="text" id="username" value="" style="margin-top: 4px;" size="30" />
                        <br /><br />
                        Mật khẩu:<br />
                        <input type="password" id="password" value="" style="margin-top: 4px;" size="30" />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: right;"><a onclick="jsAdmin.login();" class="button">Đăng Nhập</a></td>
                </tr>
            </table>
            <?php $this->security->set_action('admin_login'); ?>
        </form>
    </div>
</div>                   
<script language="javascript" type="text/javascript">
    $(document).ready(function()
    {
        $('title').html('Đăng Nhập');
        location.hash = 'cms/login';
        $('#navigation').remove();
        $('#footer').remove();
    });
</script>