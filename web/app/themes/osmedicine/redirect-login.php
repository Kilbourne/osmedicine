<?php
/**
 * Template Name: Login redirect
 */
?>

<?php
use Roots\Sage\Extras;
$url=Extras\get_root_page_url_by_name($post->post_title);
wp_redirect( $url);
exit;
 ?>
