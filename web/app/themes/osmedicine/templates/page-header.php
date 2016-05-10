<?php use Roots\Sage\Titles; ?>

<div class="page-header" <?php 	if(! in_array(true, array(is_page('allegati'),is_page('chi-siamo'),is_page('contatti'),is_page('privacy-policy'),is_page('termini_e_condizioni'))) ) echo 'hidden'; ?>>
  <h1><?= Titles\title(); ?></h1>
</div>
