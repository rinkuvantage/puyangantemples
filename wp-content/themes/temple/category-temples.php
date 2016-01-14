<?php 
 /*
Template Name: Category Temples
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();

$category_id='';
$title='';
if(isset($_REQUEST['cid']) && trim($_REQUEST['cid'])!='' && trim($_REQUEST['cid'])>0)
{
	$category_id=$_REQUEST['cid'];
	$category=Categorydetail($category_id);
	if(count($category)>0){$title=$category[0]->category;}
}
?>

<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content">
  	<h1><?php _e($title); ?></h1>
    <div class="science_box">
      <div class="all_temple1">
        <?php	 while (have_posts()) : the_post(); 
						the_content();
						endwhile;	?>
      </div>
    </div>
	<div class="clr"></div>
	<?php 
	
	?>
	
	<?php _e(category_temples($category_id)); ?>
	
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 