<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Redirect
function redirect_404(){
    header("Location: ".  get_instance()->config->base_url(), TRUE, '301');
    exit();
}

function redirect_301($uri){
    header("Location: ".$uri, TRUE, '301');
    exit();
}

function show_main_cate($menus, $id_parent = 0, $is_first = true)
{
    // Step1
    $menu_tmp = array();
    $menu_callback = array();
    $n = count($menus);
    for ($i = 0; $i < $n; $i++)
    {
        if ($menus[$i]['cate_ref_parent_id'] == $id_parent){
            $menu_tmp[] = $menus[$i];
        }
        else{
            $menu_callback[] = $menus[$i];
        }
    }

    // Step 2
    if ($menu_tmp)
    {
        echo '<ul '.($is_first ? 'class="expandable-menu"' : '').'>';
        foreach ($menu_tmp as $item) 
        {
            echo '<li id="menu_cate_'.$item['cate_id'].'">';
                echo '<a href="'.  get_instance()->config->base_url($item['cate_slug'._LANG]).'" class="dark-color active-hover">'.((!$is_first) ? '<b class="middle-color">&rsaquo;</b>' : '').' '.$item['cate_title_short'._LANG].' '.((!$is_first) ? '<small class="middle-color">('.$item['cate_total_post'].')</small>' : '').'</a>';
            show_main_cate($menu_callback, $item['cate_id'], false);
            echo '</li>';
            if ($is_first) echo '<li class="sidebar-divider"></li>';
        }
        echo '</ul>';
    }
}


function show_main_menu($menus, $id, $id_parent = 0, $is_first = true)
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
        echo '<ul '.($is_first ? 'class="'.$id.'"' : '').'>';
        foreach ($menu_tmp as $item) 
        {
            echo '<li class="'.$item['menu_class'].'">';
                echo '<a href="'.$item['menu_link'._LANG].'" title="'.$item['menu_title'._LANG].'">'.$item['menu_title'._LANG].'</a>';
            show_main_menu($menu_callback, $id, $item['menu_id'], false);
            echo '</li>';
        }
        echo '</ul>';
    }
}

// title
// revisit-after
// robots
// keywords
// description
// next_page, prev_page
// author_google_plus
// image
// section
// author_name
// page_type : website | object | article
// page_url
// published_time_int
// modified_time_int
// tags
function load_meta($filter = array())
{
    $CI = get_instance();
    
    echo "\t" . '<meta property="og:locale" content="vi_VN" />' . "\n";
    
    // Title
    if (!empty($filter['title'])) {
        echo "\t" . '<title>'.$filter['title'].'</title>' . "\n";
        echo "\t" . '<meta itemprop="name" content="' . $filter['title'] . '">' . "\n";
        echo "\t" . '<meta property="og:title" content="' . $filter['title'] . '" />' . "\n";
    }
    
    // Revisit After
    echo "\t" . '<meta name="revisit-after" content="'.(!empty($filter['revisit-after']) ? $filter['revisit-after'] : '1 days').'" />' . "\n";
    
    // Robots (noodp,noydir)
    echo "\t" . '<meta name="robots" content="'.(!empty($filter['robots']) ? $filter['robots'] : 'noodp,noydir').'"/>' . "\n";
    
    // Keywords
    if (!empty($filter['keywords'])) {
        echo "\t" . '<meta name="keywords" content="' . $filter['keywords'] . '"/>' . "\n";
    }
    
    // Description
    if (!empty($filter['description'])) {
        echo "\t" . '<meta name="description" content="' . $filter['description'] . '"/>' . "\n";
        echo "\t" . '<meta itemprop="description" content="' . $filter['description'] . '">' . "\n";
        echo "\t" . '<meta property="og:description" content="' . $filter['description'] . '" />' . "\n";
    }
    
    // Next page, prev page
    if (!empty($filter['next_page'])) {
        echo "\t" . '<link rel="next" href="' . $filter['next_page'] . '" />' . "\n";
    }
    if (!empty($filter['prev_page'])) {
        echo "\t" . '<link rel="prev" href="' . $filter['prev_page'] . '" />' . "\n";
    }
    
    // author_google_plus
    if (!empty($filter['author_google_plus'])) {
        echo "\t" . '<link rel="author" href="' . $filter['author_google_plus'] . '"/>' . "\n";
    }
    
    // Image
    if (!empty($filter['image'])) {
        echo "\t" . '<meta itemprop="image" content="' . $filter['image'] . '">' . "\n";
        echo "\t" . '<meta property="og:image" content="' . $filter['image'] . '" />' . "\n";
    }
    
    // Page Type
    if (!empty($filter['page_type'])) { // website | object | article
        echo "\t" . '<meta property="og:type" content="' . $filter['page_type'] . '" />' . "\n";
    }
    
    // Tags
    if (!empty($filter['tags']) && is_array($filter['tags'])) {
        foreach ($filter['tags'] as $tag){
            echo "\t" . '<meta property="article:tag" content="'.$tag.'"/>' . "\n";
        }
    }
    
    // Page Url
    if (!empty($filter['page_url'])) {
        echo "\t" . '<meta property="og:url" content="' . $filter['page_url'] . '" />' . "\n";
        echo "\t" . '<link rel="canonical" href="' . $filter['page_url'] . '" />' . "\n";
    }
    
    // Section
    if (isset($filter['section'])) {
        echo "\t" . '<meta property="article:section" content="' . $filter['section'] . '" />' . "\n";
    }
    
    // Author Name
    if (!empty($filter['author_name'])) {
        echo "\t" . '<meta property="article:author" content="' . $filter['author_name'] . '" />' . "\n";
    }
    
    // Published_time
    if (!empty($filter['published_time_int'])) {
        echo "\t" . '<meta property="article:published_time" content="' . date('c', $filter['published_time_int']) . '" />' . "\n";
    }

    if (!empty($filter['published_time_int']) && ($filter['published_time_int'] < $filter['modified_time_int'])) {
        echo "\t" . '<meta property="article:modified_time" content="' . date('c', $filter['modified_time_int']) . '" />' . "\n";
        echo "\t" . '<meta property="og:updated_time" content="' . date('c', $filter['modified_time_int']) . '" />' . "\n";
    }
    
    if ($CI->wconfig->item('social', 'social_facebook_id'))
        echo "\t" . '<meta property="fb:admins" content="'.$CI->wconfig->item('social', 'social_facebook').'" />' . "\n";
    
    if ($CI->wconfig->item('social', 'social_facebook_url'))
        echo "\t" . '<meta property="article:publisher" content="'.$CI->wconfig->item('social', 'social_facebook').'" />' . "\n";
    
    if ($CI->wconfig->item('social', 'social_google_plus_url'))
        echo "\t" . '<link rel="publisher" href="'.$CI->wconfig->item('social', 'social_google').'"/>' . "\n";
    
    echo "\t" . '<meta property="og:site_name" content="Gạch Cao Cấp" />' . "\n";
    echo "\t" . '<meta name="copyright" content="Copyright © 2014 by Gạch Cao Cấp" />' . "\n";
}


// LINK

function link_product_detail($item)
{
    $CI = get_instance();
    return $CI->config->base_url(LANG.'/'.$item['post_ref_cate_slug'._LANG].'/'.$item['post_slug'._LANG].'-'.$item['post_id'].'.html'); 
}

function link_product_category($item, $page = ''){
    $CI = get_instance();
    return $CI->config->base_url(LANG.'/'.$item['cate_slug'._LANG].( ($page) ? ((LANG == 'vi') ? ('/trang-'.$page) : ('/page-'.$page) ):'')); 
}

function link_product_home(){
    $CI = get_instance();
    return $CI->config->base_url((LANG == 'vi') ? 'san-pham' : 'product');
}

function link_contact($slug, $post_id=''){
    return $CI->config->base_url(LANG.'/'.$slug.'.html');
}


?>
