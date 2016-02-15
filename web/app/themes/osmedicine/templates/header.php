<header class="banner mast-head">
  <div class="container">
    <div class="mast-head-firstrow clearfix">
      <div class="left">
        <span>CHI SIAMO</span>
        <span>CONTATTI</span>
        <span>REGISTRATI</span>        
      </div><div class="right social">
        <span class="icon fb"></span><span class="icon twi"></span> 
      </div>
    </div>
    <div class="mast-head-secondrow"></div>  
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
