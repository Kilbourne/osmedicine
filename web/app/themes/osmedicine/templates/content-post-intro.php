<li <?php post_class(); ?>>

<div class="article-image-wrapper">
	<?php the_post_thumbnail(); ?>
</div><div class="article-content-wrapper">
  <header>
    <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</div>
</li>
