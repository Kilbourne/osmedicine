<?php 
use Roots\Sage\Extras;
use Roots\Sage\Setup;
get_template_part('templates/page', 'header');
$user = new WP_User( 28 );
echo var_dump($user); ?>

<?php if (!have_posts()) { ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php }else{ ?>
<?php $default_category_id = get_option('default_category'); //echo var_dump($categories);
$default_category=get_category( $default_category_id );
echo '<div class="'.esc_html( $default_category->slug ).'">';
    Extras\loop_category($default_category->slug);
    echo'</div>';
}
    if (Setup\display_sidebar_mobile() ){ ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile'); ?>
          </aside><!-- /.sidebar -->
  <?php 
    }
     if (have_posts()) { 
$categories=get_categories( array(
  //'hide_empty'=>false ,
  'exclude'  => array( $default_category_id )
  ) );
  foreach ($categories as $key => $category) {
    echo '<div class="'.esc_html( $category->slug ).'">';
    Extras\loop_category($category->slug);
    echo'</div>';

    
  }
  }
 ?>
<?php if (Setup\display_sidebar_mobile()) : ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile-2'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>