<?php
add_action('init','progetto_speciale_redirect_not_logged');

function  progetto_speciale_redirect_not_logged(){
  if(is_admin() || !(is_progetto_speciale_template() ||  is_page_template('archive-progetti.php'))) return;
  if(!is_user_logged_in()){
    wp_redirect();
    die();
  }

}

function progetto_speciale_protect(){
  if(!is_progetto_speciale_template()) return;
   $term;
   if( get_user_meta('progetto-speciale_'.$term->term_id,wp_get_current_user() )) return;
   return get_template_part('templates/progetti-login');
}

function is_progetto_speciale_template(){ return ( is_tax('progetti-speciali') || is_single('progetti-speciali') ); };
/*



function progetto_speciale_check_code{}


function progetto_speciale_handle_code(){

}
*/
