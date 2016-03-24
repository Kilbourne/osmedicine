<?php use Roots\Sage\Setup;while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <?php get_template_part('templates/date-meta'); ?>
    </header>
    <?php if(!!get_field('show_full_image') ){ ?>
        <div class="full-image-wrap"><?php  the_post_thumbnail('full' ); ?></div>
      <?php } ?>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
       <?php if (Setup\display_sidebar_mobile()) : ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      <div class="post-pagination"><div class="prev"><?php previous_post_link('<span>&laquo;</span> %link',__('Articolo Precedente','sage')); ?></div> <div class="next"><?php next_post_link(' %link <span>&raquo;</span>',__('Articolo Successivo','sage')); ?></div></div>   
      
      
<?php
       
       
    
       $categories=wp_get_post_categories($post->ID);
        $orig_post = $post;
     $args=array( 
            'category__in' => $categories,
            'post__not_in' => array($post->ID),
            'posts_per_page'=>3,
            'order'=>'ASC'
          );  
     $my_query = new wp_query( $args );
     $count = $my_query->post_count;
     if ( $my_query->have_posts() ) {
     
        ?>
<div class="related-posts">
<h3>Articoli Correlati</h3>
   <ul class="related-post-list <?php echo 'l'.$count; ?>">
        <?php
         while( $my_query->have_posts() ) {
    $my_query->the_post(); ?>

<li class="related-post">
  <div class="related-wrap">
  <div class="related-post-img-wrap">
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
  </div>  
  <div class="related-post-date"><?php echo get_the_date(); ?></div> <br/> 
  <h4 class="related-post-title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></h4></a>
  </div>
</li>   

    <?php
  }
    ?>
    </ul>
 </div> 
    <?php
     }
    $post = $orig_post;
    wp_reset_query();

     

       
      ?>
    </footer>
    <?php // comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>

