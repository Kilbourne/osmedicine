<article <?php post_class(); ?>>
<div class="article-content-wrapper">
<div class="article-image-wrapper">
  <?php the_post_thumbnail(); ?>
</div>
  <header>
  <?php if ( is_home() || is_single() ) { ?>
  	<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
  <?php  }else{ ?>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php  } ?>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</div>
</article>
