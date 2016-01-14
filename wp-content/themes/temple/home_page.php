<?php 
 /*
Template Name: Home
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();
?>

<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content">
    <?php _e(do_shortcode('[Home Page Temple]')); ?>
    <div class="clr"></div>
    <div class="science_box">
      <div class="all_temple1">
        <?php	 while (have_posts()) : the_post(); 
						the_content();
						endwhile;	?>
      </div>
    </div>
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 