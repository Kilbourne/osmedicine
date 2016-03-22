<?php
/**
 * Template Name: Profile Page
 */
?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
  <?php if( get_current_blog_id() === 1){ ?>
<section class="subsite-invites-section">
  <h3><?php _e('Aree Specialistiche') ?></h3>
<?php
    $blogs_array=wp_get_sites(  );
    $empty=true;
    $registered_blogs=array();
    $unregistered_blogs=array();
    foreach ($blogs_array as $key => $blog) {
      $id=$blog["blog_id"];
      $details=get_blog_details($id);
      if(!is_user_member_of_blog( get_current_user_id(), $id )){
        $empty=false;
        $path=$details->path;
        $path_arr=explode( "/", $path );
        $count=count($path_arr);
        $slug = $path_arr[$count-2];

        $unregistered_blogs[$id]=array($details->blogname,$slug);
      }else{
        if($id!=1)$registered_blogs[$id]=$details->blogname;
      }
  }
  if(!$empty){
?>

<div class="insert-code-wrapper upme-profile-tab-panel">
  <h4 class="upme-separator" ><?php _e('Iscriviti alle sottoaree','sage') ?></h4>
  <!--
  <div class="subsite-wrapper code-field-wrapper">
    <div>
      <label for="subsite" class="upme-field-type" ><span><?php //_e('Area Specialistica','sage') ?></span></label>
    </div><div class="upme-field-value custom-select" >
      <select id="subsite" class="upme-input">
        <?php
        /*
          foreach ($unregistered_blogs as $key => $blog) {

            echo "<option value=".$key ." data-slug='".$blog[1] ."' >".$blog[0] ."</option>";
          }
          */
        ?>
      </select>
    </div>
  </div>
  -->
  <div class="code-wrapper code-field-wrapper">
     <div><label for="code" class="upme-field-type" ><span><?php _e('Codice d\'accesso','sage') ?></span> </label></div><div class="upme-field-value" ><input type="text" id="code"></div>
   </div>
  <div class="button-wrapper"><button class="code_check_button"><?php _e('Iscriviti','sage') ?></button></div>
</div>
<?php } ?>
<?php
if(count($registered_blogs)>0){
?>
<div class="registered-areas upme-profile-tab-panel">
  <h4 class="upme-separator" ><?php _e('Sottoaree abilitate','sage') ?></h4>

<ul class="registered-areas-list">
<?php
foreach ($registered_blogs as $key => $blog) {
  $details=get_blog_details($key);
  echo "<li><span>".$blog ."</span> - <span> <a href='".$details->siteurl."'>".__('Vai al sito','sage')."</a> </span></li>";
}
?>
</ul>
</div>
</section>
<?php


}
    } ?>
<?php endwhile; ?>
