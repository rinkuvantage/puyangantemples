<?php 
 /*
Template Name: Without Right Sidebar
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var p = jQuery('div.mid_content');
	var offset = p.offset();
	jQuery('html, body').animate({scrollTop : offset.top},1000);
	
});
</script>
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content page_content">
    <div class="clr"></div>
    <div class="science_box">
      <div class="all_temple1">
        <?php	 while (have_posts()) : the_post(); 
						the_content();
						endwhile;	?>
      </div>
    </div>
  </div>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 