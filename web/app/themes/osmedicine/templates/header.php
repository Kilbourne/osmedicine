<?php use Roots\Sage\Extras; ?>
<header class="banner mast-head">
  <div class="container">
    <div class="mast-head-firstrow clearfix">
      <div class="left">
        <span><a href="<?= Extras\get_page_url_by_name('Chi siamo') ?>">CHI SIAMO</a></span><span><a href="<?= Extras\get_page_url_by_name('Contatti') ?>">CONTATTI</a></span><?php if(!is_user_logged_in ()){ ?><span><a href="<?= Extras\get_page_url_by_name('Login') ?>">LOGIN</a></span><span><a href="<?= Extras\get_page_url_by_name('Registrazione') ?>">REGISTRATI</a></span><?php }else{ ?><span><a href="<?= Extras\get_page_url_by_name('Guarda profilo') ?>">PROFILO</a></span><?php 
        function not_root($blog){
          return $blog->userblog_id !==1;
        }
        
        $current_id = get_current_user_id();
        $blogs=get_blogs_of_user($current_id);        
        if(count($blogs)>0){ ?><span class="blog-list-wrap">AREE SPECIALISTICHE <ul class="blog-list">
          <?php foreach ($blogs as $key => $blog) {
            
            if($blog->userblog_id !== get_current_blog_id()){
            ?> <li class="blog-list-element hvr-fade">
              <a href="<?php echo $blog->siteurl ; ?>" ><?php echo $blog->blogname ; ?></a>
            </li> <?php
            }
          } ?>
        </ul> </span><?php }} ?>
      </div><div class="right social">
        <span class="icon fb"></span><span class="icon twi"></span><span class="icon rss"></span>  
      </div>
    </div>
    <div class="mast-head-secondrow"><a href="<?php echo get_home_url(); ?> "><img src="<?php   echo get_field('header_background','option');?>" alt=""></a><div class="left-icons-cont icons-cont"><svg class="left-icons" >
  <use xlink:href="#lateralt_logo_3"></use>
</svg></div><h1 class="header-title <?php if( get_field('header_trapeze','option') ) { echo 'trapeze';} ?>" style=" color:<?php echo get_field('title_color','option');   ?>; "><?php   echo get_field('header_title','option');?><span ><?php   echo get_field('header_subtitle','option');?></span></h1><?php do_shortcode('[responsive_menu_pro]
' ); ?><div class="right-icons-cont icons-cont"><svg class="right-icons" >
  <use xlink:href="#lateralt_logo_4"></use>
</svg></div></div>  
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
