<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function prod_list_options()
{
    return array
    (
        'color' => array
        (
            'type' => 'radio',
            'text' => 'Màu Sắc',
            'options' => array(
                '1000' => 'Xanh',
                '1001' => 'Đỏ',
                '1002' => 'Tím',
                '1003' => 'Vàng',
            )
        ),
        'size' => array
        (
            'type' => 'radio',
            'text' => 'Kích Cỡ',
            'options' => array(
                '2000' => 'Xanh',
                '2001' => 'Đỏ',
                '2002' => 'Tím',
                '2003' => 'Vàng',
            )
        )
    );
}

?>
