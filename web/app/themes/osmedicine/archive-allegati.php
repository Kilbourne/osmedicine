<?php
use Roots\Sage\Extras;
use Roots\Sage\Setup;
get_template_part('templates/page', 'header');

      if (Setup\display_sidebar_mobile() ){ ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile'); ?>
          </aside><!-- /.sidebar -->
  <?php
    }


if(!is_integer(get_query_var('year'))){
  global $wp_rewrite;
  $post_type='allegati';
    $post_type_slug = $post_type->rewrite['slug'] ? $post_type->rewrite['slug'] : $post_type->name;
$link = $wp_rewrite->get_year_permastruct();

    if ( !empty($link) ) {
        $link = str_replace('%year%', $year, $link);
        $link=home_url( "$link?post_type=$post_type_slug" );
}
  wp_redirect( $link ); exit;
}else{
$year=get_query_var('year')==0?date('Y'):get_query_var('year');

  echo '<p class="allegati-intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
  <section class="allegati-wrapper">



        ';?>
<!--<div class="years-list-wrapper">
   <ul class="years-list"><?php //wp_get_archives(array('type'=>'yearly','post_type'     => 'allegati')); ?></ul>
 </div>-->

<?php
if (have_posts()) :

    ?>

    <ul class="year-row allegati-list">
      <time class="anno"><?php     echo $year; ?></time>
      <?php while (have_posts()) : the_post();
    global $post; $allegato=$post;
                  $allegato_id=$post->ID;
                $file=get_field('file_allegato',$allegato_id)?get_field('file_allegato',$allegato_id):false;
              ?>
                <li>
                <div><a href=" <?php  echo $file.'&masterkey=zYvirology16' ; ?> "><h5><?php   echo get_the_title( $allegato_id ); ?>  </h5><?php echo get_the_post_thumbnail( $allegato_id ); ?></a></div>
                 </li>
<?php endwhile; ?>

    </ul>


    </section>
<?php  endif;} ?>
<?php if (Setup\display_sidebar_mobile()) : ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile-2'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>

