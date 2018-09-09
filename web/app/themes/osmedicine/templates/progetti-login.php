<?php $term = get_queried_object(); ?>
<div class="progetti-login-container">
   <div class="progetti-login-wrapper">
      <h3>Inserici il tuo codice di sicurezza per accedere all'area <?php echo $term->name ?> </h3>
     <form id="progetti-login" class="progetti-login">
       <div>

         <input type="text" id="codice_progetti_speciali" name="codice_progetti_speciali" value="" placeholder="Inserisci il codice">
         <span class="progetti-login-erros" ></span>
         <input type="submit" value="Accedi">
         <a href="<?php echo home_url() ?>"><?php _e('Ritorna alla home'); ?></a>
       </div>
     </form>
   </div>
 </div>
 <?php
 add_action('wp_footer',function(){
  $ajax_nonce = wp_create_nonce( "progetti_login" );
  ob_start();

  ?>
 <script>
  (function(){
    var input_cleaned = false;
   jQuery('#progetti-login').submit(function(e){
    e.preventDefault();
    jQuery('#codice_progetti_speciali').attr('disabled','disabled');
    var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
    var codice = jQuery('#progetti-login input').val();
    var errorEl = jQuery('.progetti-login-erros');
    if( !codice || codice === ''){
      errorEl.text('Per favore inserisci un codice');
      return;
    }else{
      errorEl.text('');
    }

    jQuery.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        action:'check_progetti_speciali_code',
        security: '<?php echo $ajax_nonce; ?>',
        codice: codice

      },
    })
    .done(function(data) {
      if(data.success) location.reload();
      else errorEl.text('Il codice inserito non è valido');
      jQuery('#codice_progetti_speciali').removeAttr('disabled','disabled');
    })
    .fail(function() {
      errorEl.text('C\'è stato un problema. Per favore riprova.');
      jQuery('#codice_progetti_speciali').removeAttr('disabled','disabled');
    });
    input_cleaned = false;
   })
   jQuery('#codice_progetti_speciali').change(function(e){
      if(!input_cleaned) { input_cleaned = false; errorEl.text(''); }
   });
 })();
 </script>
<?php
echo ob_get_clean();
},20);
 ?>
