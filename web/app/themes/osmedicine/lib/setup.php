<?php

namespace Roots\Sage\Setup;
include "Mobile_Detect.php";
use Roots\Sage\Assets;
use Mobile_Detect;
/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  //add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
  set_post_thumbnail_size( 420);
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Mobile first sidebar', 'sage'),
    'id'            => 'sidebar-mobile',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
    register_sidebar([
    'name'          => __('Mobile second sidebar', 'sage'),
    'id'            => 'sidebar-mobile-2',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;
$detect = new Mobile_Detect;



  isset($display) || !$detect->isMobile() && $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_singular( 'post' ),
    //is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

function display_sidebar_mobile() {
  static $display;
$detect = new Mobile_Detect;



  isset($display) || $detect->isMobile() && $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_singular( 'post' ),
    //is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar_mobile', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_deregister_script('jquery' );
  wp_enqueue_style('sage-css', Assets\asset_path('styles/main.css'), false, null);
wp_enqueue_script( 'jquery', Assets\asset_path('scripts/jquery.js'), false, null, true );
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage-js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
  wp_localize_script( 'sage-js', 'OSM', array(
        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
    'nonce'     => wp_create_nonce( 'OSM_validate_code-nonce' ))
  );
  $css_target = isset($bodhi_svgs_options['css_target']) ?'img.'. $bodhi_svgs_options['css_target']:'img.';
wp_localize_script( 'sage-js', 'cssTarget', $css_target );
wp_localize_script(
            'sage-js',
            'soliloquy_ajax',
            array(
                'ajax'           => admin_url( 'admin-ajax.php' ),
                'ajax_nonce'     => wp_create_nonce( 'soliloquy-ajax-nonce' ),
            )
        );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets1', 1);
function assets1() {
  wp_enqueue_script( 'defer', Assets\asset_path('scripts/defer.js'), [], null, false );

  }
function js_async_attr($tag){

    # Do not add async to these scripts
    $scripts_to_exclude = array('jquery','mediaelement-and-player','query-monitor');
    $scripts_to_include = array('dist/scripts/main','wp-embed');
    foreach($scripts_to_exclude as $exclude_script){
        if(true == strpos($tag, $exclude_script ) )
        return $tag;
    }
foreach($scripts_to_include as $include_script){
        if(true == strpos($tag, $include_script ) )
        return str_replace( ' src', ' async="async" src', $tag );
    }
    return $tag;
    # Add async to all remaining scripts


}
  if(!is_admin()){
add_filter( 'script_loader_tag', __NAMESPACE__ . '\\js_async_attr', 10 );
  }
