<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use WP_Widget;
use WP_Error;
use stdClass;
use Walker_Nav_Menu_Checklist;
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
  $current_blog_id = get_current_blog_id();
  $blog_details = get_blog_details($current_blog_id);
  $slug = str_replace('/','',$blog_details->path);
  $classes[]=$slug;
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




function not_root($blog){
          return $blog->userblog_id !==1;
}


add_filter('wp_nav_menu_items',__NAMESPACE__ . '\\custom_menu2', 10, 2);
function custom_menu2($items, $args){
   if(  ! $args->theme_location == 'primary_navigation' && is_user_logged_in () ){
    $display='';
        $current_id = get_current_user_id();
        $blogs=get_blogs_of_user($current_id);
        $blogs=array_filter($blogs, "not_root");
          if(count($blogs)>0){
            $display.='<li class=" menu-item menu-item-has-children blog-list-wrap"><span class="label" >AREE SPECIALISTICHE</span> <ul class="sub-menu blog-list">';
             foreach ($blogs as $key => $blog) {
              $active=$blog->userblog_id === get_current_blog_id()?'active':'';
              $display.='<li class="blog-list-element menu-item  '.  $active .' " ><a href="'. $blog->siteurl.'" >'. $blog->blogname .'</a></li>';
            }
            $display.='</ul> </li>';
            if(get_current_blog_id()!==1 ){
              $display.='<li class=" menu-item" ><a href="'.network_site_url().'">OPEN SOURCE IN MEDICINE</a> </li>';


        }}
$items.=$display;
}



   return $items;
}

add_filter('wp_nav_menu',__NAMESPACE__ . '\\custom_menu', 10, 2);
function custom_menu($nav_menu,$args){
   if(  ! $args->theme_location == 'primary_navigation' && get_current_blog_id()===1 ){
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
          $items=$items.'<li class=" menu-item"><a href="'. get_page_url_by_name('Login') .'">Login</a></li><li class=" menu-item"><a href="'. get_page_url_by_name('Registrazione') .'">Registrati</a></li>';
        }else{
          $items=$items.'<li class=" menu-item"><a href="'. get_page_url_by_name('Guarda profilo') .'">Profilo</a></li>';
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

add_filter( 'rest_authentication_errors', function( $result ) {
  if ( ! empty( $result ) ) {
    return $result;
  }
  if ( ! is_user_logged_in() ) {
    return new WP_Error( 'restx_logged_out', 'Sorry, you must be logged in to make a request.', array( 'status' => 401 ) );
  }

  return $result;
});
/*
function is_user_logged_in_rootsite(){
    switch_to_blog( 1 );
    global $user;
    $logged = is_user_logged_in() ? true : false;
    restore_current_blog();
    return $logged;
}
*/
add_action( 'rest_api_init', __NAMESPACE__ . '\\slug_register_subsites' );
function slug_register_subsites() {
    register_rest_field( 'user',
        'subsite',
        array(
            'get_callback'    => __NAMESPACE__ . '\\slug_get_subsites',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * Get the value of the "starship" field
 *
 * @param array $object Details of current post.
 * @param string $field_name Name of field.
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function slug_get_subsites( $object, $field_name, $request ) {
  $results=array();
  $blogs_array=get_blogs_of_user($object[ 'id' ]);

foreach ($blogs_array as $key => $blog) {

$id=$blog->userblog_id;
       $path=$blog->path;
        $path_arr=explode( "/", $path );
        $count=count($path_arr);
        $slug = $path_arr[$count-2];
 if($id!==1) $results[]=$slug;
 }

    return $results;

}
add_action('admin_head-nav-menus.php', __NAMESPACE__ . '\\wpclean_add_metabox_menu_posttype_archive');
function wpclean_add_metabox_menu_posttype_archive() {
add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', __NAMESPACE__ . '\\wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}

function wpclean_metabox_menu_posttype_archive() {
$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

if ($post_types) :
    $items = array();
    $loop_index = 999999;

    foreach ($post_types as $post_type) {
        $item = new stdClass();
        $loop_index++;

        $item->object_id = $loop_index;
        $item->db_id = 0;
        $item->object = 'post_type_' . $post_type->query_var;
        $item->menu_item_parent = 0;
        $item->type = 'custom';
        $item->title = $post_type->labels->name;
        $item->url = get_post_type_archive_link($post_type->query_var);
        $item->target = '';
        $item->attr_title = '';
        $item->classes = array();
        $item->xfn = '';

        $items[] = $item;
    }

    $walker = new Walker_Nav_Menu_Checklist(array());

    echo '<div id="posttype-archive" class="posttypediv">';
    echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
    echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
    echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    echo '<p class="button-controls">';
    echo '<span class="add-to-menu">';
    echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
    echo '<span class="spinner"></span>';
    echo '</span>';
    echo '</p>';

endif;
}
/*
add_action( 'transition_post_status', __NAMESPACE__ . '\\wpse118970_post_status_new', 10, 3 );
function wpse118970_post_status_new( $new_status, $old_status, $post ) {
    $post_types=array('allegati');
    if ( in_array($post->post_type, $post_types)  && $new_status == 'publish' && $old_status  != $new_status ) {
        $post->post_status = 'private';
        wp_update_post( $post );
    }
}
add_action( 'post_submitbox_misc_actions' , __NAMESPACE__ . '\\wpse118970_change_visibility_metabox' );
function wpse118970_change_visibility_metabox(){
  global $post;
    $post_types=array('allegati');
    if (! in_array($post->post_type, $post_types))
        return;
        $message = __('<strong>Nota:</strong> Gli '. $post->post_type .' pubblicati sono sempre <strong>privati</strong>.');
        $post->post_password = '';
        $visibility = 'private';
        $visibility_trans = __('Private');
    ?>
    <style type="text/css">
        .priv_pt_note {
            background-color: lightgreen;
            border: 1px solid green;
            border-radius: 2px;
            margin: 4px;
            padding: 4px;
        }
    </style>
    <script type="text/javascript">
        (function($){
            try {
                $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
                $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
            } catch(err){}
        }) (jQuery);
    </script>
    <div class="priv_pt_note">
        <?php echo $message; ?>
    </div>
    <?php
}
*/

function post_published_notification( $ID, $post ) {
$response = wp_remote_get( 'https://appslandingit.serversicuro.it/Menthalia/OSVirology/push_sviluppo.php' );
}
add_action( 'publish_allegati', __NAMESPACE__ . '\\post_published_notification', 10, 2 );
?>
