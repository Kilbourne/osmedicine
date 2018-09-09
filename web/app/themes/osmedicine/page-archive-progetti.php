<?php
/**
 * Template Name: Archivio Progetti Speciali
 */
?>

<?php
use Roots\Sage\Extras;
use Roots\Sage\Setup;


get_template_part('templates/page', 'header');
 if (Setup\display_sidebar_mobile()) : ?>
          <aside class="sidebar">
            <?php get_template_part('templates/sidebar-mobile'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
<div class="progetti-speciali-wrapper">
<?php
$p_s = get_terms([ 'taxonomy' => 'progetti-speciali' ]);
if($p_s){
  foreach ($p_s as $p) {
    ?>
      <div class="progetto-speciale">
        <div class="progetto-speciale-container">
          <div class="progetto-title">
            <a href="<?php echo get_term_link($p) ?>" class="progetto-speciale-title-link">
              <span class="progetto-speciale-title-label"><?php echo $p->name ?></span>
            </a>
          </div>
        </div>
      </div>

    <?php
  }
?>
</div>
<?php
}else{

}



