<?php 
	$categories=get_the_category();
	$cat=get_category( $categories[0] );
 ?>
<time class="updated <?php echo $cat->slug.'-cat-bg-color';?>" datetime="<?= get_post_time('c', true); ?>"><span class="day"><?= get_the_date
('d'); ?></span><span class="month"><?= get_the_date('M Y'); ?></span> </time>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="single-title-wrap">
<p class="byline author vcard" ><?= __('Di', 'sage'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?= get_the_author(); ?></a></p>
      <?php 




	if(count($categories)>0){
	?>
	<ul class="entry-category-list">
	<?php
	foreach ($categories as $key => $category) {
		$cat = get_category( $category );
		?>
	<li class="entry-category <?php echo $cat->slug.'-cat-bg-color';?>">
		<a href="<?= get_category_link( $category ); ?>"><?= $cat->name; ?></a>
	</li>
	<?php
	}
	?>
	</ul> 
	<?php
	}

?>
      </div>      