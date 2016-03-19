<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <style type="text/css" media="screen">
  	<?php 
  	$categories=get_categories ( );
  	foreach ($categories as $key => $category) {
  		
  		$slug=$category->slug;
  		if(function_exists('rl_color')){
     	   $rl_category_color = rl_color($category->term_id);
    	}
    	echo '.'.$slug.' h3{
    		background-color:'.$rl_category_color.';		
    	}
    	.'.$slug.' h4 > a,.'.$slug.' h5 > a{
    		color:'.$rl_category_color.';			
    	}
    	.'.$slug.'-cat-color{
  			color:'.$rl_category_color.';
  		}
  		.'.$slug.'-cat-bg-color{
  			background-color:'.$rl_category_color.';

  		}
  		.'.$slug.'-cat-br-color{
  			border-color:'.$rl_category_color.';
  			
  		}
    	';
    }
  	 ?> 
  </style>
</head>
