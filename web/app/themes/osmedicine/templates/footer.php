<?php use Roots\Sage\Extras; ?>
<footer class="content-info">
  <div class="container">
    <?php //dynamic_sidebar('sidebar-footer'); ?>
    	<div class="info-rivista">     		
     		<p>Testata giornalistica registrata presso Tribunale di Napoli - Aut. n°32 del 18/05/2016</p>
     	</div>
     	<div class="footer-menu">
            <span><a href="<?= Extras\get_page_url_by_name('Chi siamo') ?>">Chi siamo</a></span><span><a href="<?= Extras\get_page_url_by_name('Contatti') ?>">Contatti</a></span><?php if(!is_user_logged_in ()){ ?><span><a href="<?= Extras\get_page_url_by_name('Login') ?>">Login</a></span><span><a href="<?= Extras\get_page_url_by_name('Registrazione') ?>">Registrati</a></span><?php }else{ ?><span><a href="<?= Extras\get_page_url_by_name('Guarda profilo') ?>">Profilo</a></span><?php } ?> <span><a href="<?= Extras\get_page_url_by_name('Privacy Policy') ?>">Privacy Policy</a></span><span><a href="<?= Extras\get_page_url_by_name('Termini e Condizioni') ?>">Termini e Condizioni</a></span>
     	</div>
     	<div class="info-menthalia">
     		<p>© 2016 Menthalia srl PI 06980851213  |  Piazzale Tecchio 49, 80125  Napoli</p>
     	</div> 	
  </div>
  <?php 
  if(get_current_blog_id() === 1){
    $analytics_code="UA-77520161-1";
  }elseif(get_bloginfo( 'name' )==="Open Source in Virology" ){
    $analytics_code="UA-77531534-1";
  }
   ?>
  <script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '<?php echo $analytics_code; ?>', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>

</footer>
