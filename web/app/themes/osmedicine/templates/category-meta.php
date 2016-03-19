<?php 

if(is_single()){
	$categories=get_the_category();

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
}
?>