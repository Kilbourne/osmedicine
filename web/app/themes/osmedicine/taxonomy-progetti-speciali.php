
<?php
  if(!OSM_Progetti_Plugin::progetto_speciale_protect()){
    get_template_part('templates/progetti-login');
  }
  // Benvenuto
 ?>
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
  $post_type='pubblicazioni';
    $post_type_slug = $post_type->rewrite['slug'] ? $post_type->rewrite['slug'] : $post_type->name;
$link = $wp_rewrite->get_year_permastruct();

    if ( !empty($link) ) {
        $link = str_replace('%year%', $year, $link);
        $link=home_url( "$link?post_type=$post_type_slug" );
}
  wp_redirect( $link ); exit;
}else{
$year=get_query_var('year')==0?date('Y'):get_query_var('year');
$intro=get_field('desc_intro','option')?get_field('desc_intro','option'):'';
  echo $intro.'<section class="allegati-wrapper">



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
                <div><a href=" <?php  echo $file ; ?> "><h5><?php   echo get_the_title( $allegato_id ); ?>  </h5><?php echo get_the_post_thumbnail( $allegato_id ); ?></a></div>
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


