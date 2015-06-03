<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "home";
$route['404_override'] = 'home';

// HOME
$route['([a-z0-9-]+)\.html'] = 'page/index/$1';

// HOME
$route['page/([0-9]+)'] = 'home/index/$1';

// MAU WEB HOME
$route['web-shop'] = 'product/home/index';
$route['web-shop/page/([0-9]+)'] = 'product/home/index/$1';

// MAU WEB CATEGORY
$route['web-shop/([a-z0-9-]+)'] = 'product/category/index/$1';
$route['web-shop/([a-z0-9-]+)/page/([0-9]+)'] = 'product/category/index/$1/$2';

// MAU WEB
$route['web-shop/([a-z0-9-]+)-([0-9]+)\.html'] = 'product/detail/index/$1/$2';

// SAN PHAM HOME
$route['san-pham'] = 'news/home/index';
$route['san-pham/page/([0-9]+)'] = 'news/home/index/$1';

// SAN PHAM CATEGORY
$route['san-pham/([a-z0-9-]+)'] = 'news/category/index/$1';
$route['san-pham/([a-z0-9-]+)/page/([0-9]+)'] = 'news/category/index/$1/$2';

// SAN PHAM
$route['san-pham/([a-z0-9-]+)-([0-9]+)\.html'] = 'news/detail/index/$1/$2';