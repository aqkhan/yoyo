<?php
/*
 * WordPress Ninja by A Q Khan ( aqkhan@iintellect.co.uk )
 * Contains most of basic WP functions and some high level custom code shit.
 * Version 0.1
 * Last Updated: March 26, 2016
 */

//== BASIC LEVEL SHIT ==//

//-- Uncomment the code below to change URL of the website --//
/*if(get_option('siteurl') != 'http://localhost/target_url') {
    update_option('siteurl','http://localhost/target_url');
    wp_die("siteurl URL Changed!", "siteurl Updated");
}
if(get_option('home') != 'http://localhost/target_url') {
    //echo "<h1>Home URL: {get_option('home')}</h1>";
    update_option('home','http://localhost/target_url');
    die("home URL Changed!", "home Updated");
}*/

error_reporting(E_ALL);

//-- Load Custom CSS --//
function load_scripts() {
    wp_enqueue_style('main-stylesheet', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'load_scripts', 12);

//-- Load Custom JS --//
//-- Load jQuery the proper way --//
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 10);
function my_jquery_enqueue() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.12.2.min.js', false, null);
    wp_enqueue_script('jquery');
    //-- Load Bootstrap (version 3.1.1 minified)--//
}

//-- Load Bootstrap (version 3.1.1 minified)--//
function load_bootstrap() {
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.min.css');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js');
}
add_action('wp_enqueue_scripts', 'load_bootstrap', 11);

//-- Print Conditional Scripts (Bootstrap or Browser Compatibility scripts) --//
function conditional_scripts() {
    echo '
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    ';
}
add_action( 'wp_print_styles', 'conditional_scripts', 13 );


//-- Include Admin Panel or custom include files to your theme --//
//include_once(dirname(__FILE__) . '/includes/admin.php');

//-- Disabling Admin Bar --//
add_filter('show_admin_bar', '__return_false');

//-- Add feature image to posts --//
add_theme_support( 'post-thumbnails' );

//-- Register theme menus --//
function register_my_menus() {
    register_nav_menus(
        array( 'primary-menu' => __( 'Public Menu' ),'footer-menu' => __( 'Footer Menu' ) )
    );
}
add_action( 'init', 'register_my_menus' );

//-- Registering Sidebar --//
register_sidebar(array(
    'name' => __( 'Sidebar Name' ),
    'id' => 'sidebar-id',
    'description' => __( 'Sidebar Description' ),
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));

//-- Custom Excerpt --//
function excerpt($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    $excerpt = implode(' ',$excerpt).' ...';
    echo $excerpt;
}

//-- AJAX Sample function and hook below --//
function name_of_function() {
    //-- Do something here
}
//add_action('wp_ajax_name_of_function', 'name_of_function');
//add_action('wp_ajax_nopriv_name_of_function', 'name_of_function');

// \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\ // \\

//== ADVANCE LEVEL SHIT ==//

//-- Custom Role --//
/*
function my_custom_role() {
    add_role(
        'role_id',
        __( 'Role Name' ),
        array(
            'read'         => true,  // true allows this capability
            'edit_posts'   => false,
            'delete_posts' => false, // Use false to explicitly deny
        ));
}
add_action( 'init', 'my_custom_role' );
*/

//-- WordPress Session --//
/*
function register_session(){
    if( !session_id() )
        session_start();
}
add_action('init','register_session');
*/

//-- Password protect website --//
/*
function website_down() {
    if(!empty($_REQUEST['aqk_unlock'])) {
        $pass = $_REQUEST['aqk_unlock'];
        if($pass === 'password') {
            $_SESSION['unlock_aqk'] = 'true';
        }
    }
    if(!isset($_SESSION['unlock_aqk']) && empty($_SESSION['unlock_aqk'])) {
        wp_die('Good Sir, You just broke the internet', 'You are not suppose to be here');
    }
}
add_action('wp_head', 'website_down');
*/

//-- Resize and PRINT images (Needs a page to print image on ) --//
/*
function aqk_resize_image($absolute_path, $width, $height) {
    $resized = wp_get_image_editor( $absolute_path );
    if (! is_wp_error($resized)) {
        $resized->resize($width, $height, true);
        // Prionts Image
        $resized->stream($mime_type = 'image/png');
    }
}
function aqk_print_image($absolute_path, $width, $height) {
    echo '<img src="http://your-address.com/page-name-where-above-function-is-used/?resize_me=' . $absolute_path . '&resize_me_w=' . $width . '&resize_me_h=' . $height . '" alt="Resized by A Q Khan">';
}
*/

//-- Pagination --//
/*
function con_pagination($pages = '', $range = 2){
    $showitems = ($range * 2)+1;
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages){
            $pages = 1; }
    }
    if(1 != $pages){
        echo "<div class='pagination'>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
        if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<li><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
            }
        }
        if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
        if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
        echo "</div>\n";
    }
}
*/