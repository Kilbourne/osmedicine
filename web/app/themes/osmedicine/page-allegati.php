<?php
use Roots\Sage\Extras;
use Roots\Sage\Setup;
function posts_by_year_plus_category() {
  // array to use for results
  $years = array();

  // get posts from WP
  $allegati = get_posts(array(
'post_type' => 'allegati','posts_per_page' => -1, 'orderby' => 'date'
  ));

  // loop through posts, populating $years arrays
  if($allegati){
	  foreach($allegati as $allegato) {
	  	$category = wp_get_post_categories( $allegato->ID );

	  	$category = count($category)>0?get_category($category[0])->name:'-';

	  	if(! isset($years[date('Y', strtotime($allegato->post_date))])) $years[date('Y', strtotime($allegato->post_date))] = array();

	  	//if(! is_array($years[date('Y', strtotime($allegato->post_date))][$category])) $years[date('Y', strtotime($allegato->post_date))][$category] = array();
	    $years[date('Y', strtotime($allegato->post_date))][] = $allegato->ID;
	  }
  }
  // reverse sort by year


  return $years;
}
$years = posts_by_year_plus_category();
get_template_part('templates/page', 'header');
	    if (Setup\display_sidebar_mobile() ){ ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile'); ?>
          </aside><!-- /.sidebar -->
  <?php
    }
if ($years) {
	echo '<p class="allegati-intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.	</p>
  <section class="allegati-wrapper">



				';


    foreach ($years as $key=>$anno) { ?>
    <ul class="year-row allegati-list">
      <time class="anno"><?php echo $key; ?></time>
      <?php foreach ($anno as $key2=>$allegato_id ) {
                  $allegato = get_post($allegato_id);
                $file=get_field('file_allegato',$allegato_id)?get_field('file_allegato',$allegato_id):false;
              ?>
                <li>
                <div><a href=" <?php  echo $file ; ?> "><h5><?php   echo get_the_title( $allegato_id ); ?>  </h5><?php echo get_the_post_thumbnail( $allegato_id ); ?></a></div>
                 </li>
                <?php } ?>

    </ul>
    <?php } ?>
    </section>
    <?php
}else{ ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php

}


 ?>
<?php if (Setup\display_sidebar_mobile()) : ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile-2'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
