<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use WP_Widget;
use WP_Error;
/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


function loop_category($category){
  $idObj = get_category_by_slug($category);
  $cat_name = $idObj->name;
  if($category==='news'){$number=4;}else{$number=1;}
  $args = array(
    'posts_per_page'   => $number,
    'category_name'    => $category,
  );
  $posts_array = get_posts( $args );

  $length=count($posts_array);
  if($length>0){
  echo '<a href="'. get_category_link( $idObj->cat_ID ).' " ><h3 class="big-article-title">'.$cat_name.'</h3></a>';
  global $post;
  foreach ( $posts_array as $key=>$post ) { setup_postdata( $post );
    if($key===0){
      get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format());
    }else{
      if($key===1){ echo '<ul class="other-post-list length'.($length-1).'">';}

        get_template_part('templates/content','post-intro');
      if($key===$length){ echo '</ul>'; }
    }
 }
  wp_reset_postdata();
    }
}




add_filter('widget_text', 'do_shortcode');









add_filter('wp_nav_menu',__NAMESPACE__ . '\\custom_menu', 10, 2);
function custom_menu($nav_menu,$args){
   if(  ! $args->theme_location == 'primary_navigation' ){
      return $nav_menu.'<div class="right social">
        <span class="icon fb"></span><span class="icon twi"></span><span class="icon rss"></span>
      </div>';
   }
   return $nav_menu;
}
add_filter('wp_nav_menu_items',__NAMESPACE__ . '\\add_search_box_to_menu', 10, 2);
function add_search_box_to_menu( $items, $args ) {
    if( $args->theme_location == 'primary_navigation' ){
        $items=$items.'<li class="menu-item search" >'.get_search_form(false).'</li>';
    }else{

        if(!is_user_logged_in ()){
          $items=$items.'<li class="hvr-fade menu-item"><a href="'. get_page_url_by_name('Login') .'">Login</a></li><li class="hvr-fade menu-item"><a href="'. get_page_url_by_name('Registrazione') .'">Registrati</a></li>';
        }else{
          $items=$items.'<li class="hvr-fade menu-item"><a href="'. get_page_url_by_name('Guarda profilo') .'">Profilo</a></li>';
        }
    }
    return $items;


}

function acf_load_color_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();

$blogs_array=wp_get_sites(  );

foreach ($blogs_array as $key => $blog) {
  $id=$blog["blog_id"];
  $details=get_blog_details($id);

  if($id!==1 && !is_user_member_of_blog( get_current_user_id(), $id )){
    $field['choices'][ $id ] = $details->blogname;
  }

}
// se è vuoto l'utente è iscritto a tutti i subsite quindi nascondi
  if(empty($fields['choices'])){}

    return $field;

}

add_filter('acf/load_field/name=subsito', __NAMESPACE__ . '\\acf_load_color_field_choices');

function OSM_validate_code() {
    if ( ! wp_verify_nonce( $_POST['_nonce'], 'OSM_validate_code-nonce' ) )
        die ( 'Non autorizzato!');
          ob_clean();
$current_user_id=get_current_user_id( );
$user_info=get_userdata( $current_user_id );

    $code=isset( $_POST['code'] ) ? strtoupper( sanitize_text_field($_POST['code'] )) : '';
    $baweic_options = get_option( 'baweic_options' );
  $subsite=isset( $baweic_options['codes']['all'][$code] ) ? $baweic_options['codes']['all'][$code] : '';
      $blogs_array=wp_get_sites(  );
      $subsite_id='';
    foreach ($blogs_array as $key => $blog) {
      $id=$blog["blog_id"];
      $details=get_blog_details($id);

        $empty=false;
        $path=$details->path;
        $path_arr=explode( "/", $path );
        $count=count($path_arr);
        $slug = $path_arr[$count-2];
        if($subsite===$slug) $subsite_id=$id;

      }


//wp_send_json_error(array( $baweic_options['codes'],$subsite));
    if ( $code ==='' ) {

    $data=  '<p class="error">'.sprintf(__( '<strong>ERROR</strong>: Please insert a code.', 'sage' ), $subsite).'</p>' ;
    wp_send_json_error($data);
  }  elseif ( $subsite ==='' || $subsite_id ==='' || ! isset($baweic_options['codes'][$subsite] ) || ! array_key_exists( $code, $baweic_options['codes'][$subsite] ) ) {

    $data=  __( '<p class="error"><strong>ERROR</strong>: Wrong Invitation Code.</p>', 'sage' ) ;
    wp_send_json_error($data);
  } elseif ( isset( $baweic_options['codes'][$subsite][ $code ] ) && ! $baweic_options['codes'][$subsite][ $code ]['leftcount'] ){

    $data=  __( '<p class="error"><strong>ERROR</strong>: This Invitation Code is already used.</p>', 'sage' ) ;
    wp_send_json_error($data);
  } else {

    $baweic_options['codes'][$subsite][ $code ]['leftcount']--;
    $baweic_options['codes'][$subsite][ $code ]['users'][] =  $user_info->user_login;
    update_option( 'baweic_options', $baweic_options );

      $registe=add_user_to_blog( $subsite_id, $current_user_id, 'subscriber' );
      if($registe){
        // set usermeta
        $details=get_blog_details($subsite_id);
        $url=$details->siteurl;
        $name=$details->blogname;
        $data_text=sprintf('<p class="success"><strong>SUCCESS</strong>: Registered to %s restricted area.</p>', $subsite);
        $data= array('data'=>$data_text,'url'=>$url,'name'=>$name);
        wp_send_json_success( $data );
      }


    }
          wp_die();
}
add_action( 'wp_ajax_validate_code', __NAMESPACE__ . '\\OSM_validate_code' );
add_action( 'wp_ajax_nopriv_validate_code', __NAMESPACE__ . '\\OSM_validate_code' );

function get_page_url_by_name($name){
    $page=get_page_by_title( $name );
    return get_page_link( $page->ID );
}
function get_root_page_url_by_name($name){
  switch_to_blog( 1 );
  $url=get_page_url_by_name($name);
  restore_current_blog();
  return $url;
}
if(function_exists('acf_add_options_page')) {

  acf_add_options_page();

}
function wpdocs_custom_excerpt_length( $length ) {
    return 35;
}
add_filter( 'excerpt_length', __NAMESPACE__ . '\\wpdocs_custom_excerpt_length', 999 );
function excerpt_count_js(){

if ('post' === get_post_type()) {

      echo '<script>jQuery(document).ready(function(){
jQuery("#postexcerpt .handlediv").after("<div style=\"position:absolute;top:12px;right:34px;color:#666;\"><small>Excerpt length: </small><span id=\"excerpt_counter\"></span><small><span style=\"font-weight:bold; padding-left:7px;\">character(s).</span></small></div>");
     jQuery("span#excerpt_counter").text(jQuery("#excerpt").val().length);
        jQuery("#excerpt").keyup( function() {

     jQuery("span#excerpt_counter").text(jQuery("#excerpt").val().length);
   });

});</script>';
}
}
add_action( 'admin_head-post.php', __NAMESPACE__ . '\\excerpt_count_js');
add_action( 'admin_head-post-new.php', __NAMESPACE__ . '\\excerpt_count_js');

add_filter('author_rewrite_rules', __NAMESPACE__ . '\\no_author_base_rewrite_rules');
function no_author_base_rewrite_rules($author_rewrite) {
    global $wpdb;
    $author_rewrite = array();
    $authors = $wpdb->get_results("SELECT user_nicename AS nicename from $wpdb->users");
    foreach($authors as $author) {
        $author_rewrite["({$author->nicename})/page/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
        $author_rewrite["({$author->nicename})/?$"] = 'index.php?author_name=$matches[1]';
    }
    return $author_rewrite;
}

if( !is_admin() ) {
add_action('init', __NAMESPACE__ . '\\author_rewrite_so_22115103');
}

function author_rewrite_so_22115103() {
   global $wp_rewrite;
   if( 'author' == $wp_rewrite->author_base ) $wp_rewrite->author_base = null;
}

//add_filter( 'get_the_author_user_url', __NAMESPACE__ . '\\guest_author_url' );
add_filter( 'the_author', __NAMESPACE__ . '\\guest_author_link' );
//add_filter( 'get_the_author_display_name', __NAMESPACE__ . '\\guest_author_name' );

function guest_author_url($url) {
  global $post;
  $guest_name = get_field('autore');
  if ( !!$guest_name ) {
    return '#';
  }
  return $url;
}

function guest_author_link($name) {
  global $post;


  $guest_name = get_field('autore');

if( !!$guest_name ) {
  //echo var_dump($guest_name);
    return $guest_name;
  }else{
  return $name;
  }
}

function guest_author_name( $name ) {
  global $post;
  $guest_name = get_field('autore');
  if ( $guest_name ) return $guest_name;
  return $name;
}
add_filter('upme_custom_profile_pic',__NAMESPACE__ . '\\opensource_profile_pic');
function opensource_profile_pic($pic){
  return '';
}

function my_special_nav_class( $classes, $item ) {
  if(in_array('current-menu-item', $classes))$classes[] = 'hvr-sweep-to-right';

        $classes[] = 'hvr-fade';


    return $classes;

}

add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\\my_special_nav_class', 10, 2 );
?>
