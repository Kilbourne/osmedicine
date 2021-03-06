<?php use Roots\Sage\Extras; ?>
<header class="banner mast-head">
  <div class="container">
    <div class="mast-head-firstrow clearfix">
      <div class="left">
        <span><a href="<?= Extras\get_page_url_by_name('Chi siamo') ?>">CHI SIAMO</a></span><span><a href="<?= Extras\get_page_url_by_name('Contatti') ?>">CONTATTI</a></span><?php if(!is_user_logged_in ()){ ?><span><a href="<?= Extras\get_page_url_by_name('Login') ?>">LOGIN</a></span><span><a href="<?= Extras\get_page_url_by_name('Registrazione') ?>">REGISTRATI</a></span><?php }else{ ?><span><a href="<?= Extras\get_page_url_by_name('Guarda profilo') ?>">PROFILO</a></span><span><a href="<?php echo wp_logout_url( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ); ?>">LOGOUT</a></span><?php
        function not_root($blog){
          return $blog->userblog_id !==1;
        }

        $current_id = get_current_user_id();
        $blogs=get_blogs_of_user($current_id);
        $blogs=array_filter($blogs, "not_root");
        if(count($blogs)>0){ ?><span class="blog-list-wrap">AREE SPECIALISTICHE <ul class="blog-list">
          <?php foreach ($blogs as $key => $blog) {


            ?> <li class="blog-list-element hvr-fade <?php echo $blog->userblog_id === get_current_blog_id()?'active':''; ?>">
              <a href="<?php echo $blog->siteurl ; ?>" ><?php echo $blog->blogname ; ?></a>
            </li> <?php

          } ?>
        </ul> </span><?php
        if(get_current_blog_id()!==1 ){ ?>
        <span><a href="<?php echo network_site_url(); ?>">OPEN SOURCE IN MEDICINE</a> </span>
        <?php

        }}} ?>
      </div><?php
        if(get_current_blog_id()===1 ){ ?><div class="right social">
        <a href="https://www.facebook.com/Open-Source-in-Medicine-1280272665320711/"><span class="icon fb"></span></a><a href="https://twitter.com/OS_Medicine"><span class="icon twi"></span></a><a href="<?php bloginfo('rss2_url'); ?>"><span class="icon rss">
</span></a>
      </div>
      <?php } ?>
    </div>
    <div class="mast-head-secondrow">
    <?php   $display='<a href="'. get_home_url().'"><img src="'.get_field('header_background','option').'" alt=""><div class="left-icons-cont icons-cont"><svg class="left-icons" >
  <use xlink:href="'.get_stylesheet_directory_uri().'/dist/images/svg-def.svg#lateralt_logo_3"></use>
</svg></div><h1 class="header-title';
if( get_field('header_trapeze','option') ) { $display.= ' trapeze';}
$display.='" style=\' color:'.get_field('title_color','option').'; \'>'.get_field('header_title','option').'<span >'.get_field('header_subtitle','option').'</span></h1>'.do_shortcode('[responsive_menu_pro]' ).'<div class="right-icons-cont icons-cont"><svg class="right-icons" >
  <use xlink:href="'.get_stylesheet_directory_uri().'/dist/images/svg-def.svg#lateralt_logo_4"></use>
</svg></div></a>'; echo $display;?>
</div>
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
