
<div class="progetti-login-container">
   <div class="progetti-login-wrapper">
     <form id="progetti-login" class="progetti-login">
       <div>
         <label><?php  _e('Inserisci il codice')  ?></label>
         <input type="text" name="codice_progetti_speciali" value="">
         <span class="progetti-login-erros" ></span>
         <div><a href="<?php home_url() ?>"><?php _e('Ritorna alla home'); ?></a><input type="submit" value="Accedi"></div>

       </div>
     </form>
   </div>
 </div>
 <?php
 add_action('wp_footer',function(){
  //nonces
  ob_start();

  ?>
 <script>
   jQuery('#progetti-login').submit(function(e){
    var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
    e.preventDefault();
    jQuery.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        action:'check_progetti_speciali_code',
        codice: jQuery('#progetti-login input').val()

      },
    })
    .done(function(data) {
      if(data.success) location.reload();

    })
    .fail(function() {
      console.log("error");
    });

   })
 </script>
<?php
echo ob_get_clean();
},20);
 ?>
