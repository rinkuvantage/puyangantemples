<?php 
 /*
Template Name: Package Temples
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();

$package_type_id='';
$title='';
$detail='';
if(isset($_REQUEST['pid']) && trim($_REQUEST['pid'])!='' && trim($_REQUEST['pid'])>0)
{
	$package_type_id=$_REQUEST['pid'];
	$package=packagetypedetail($package_type_id);
	if(count($package)>0){
		$title=$package[0]->package_type.' Temples';
		$detail=$package[0]->description;
	}
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
						_e($detail);
						endwhile;	?>
      </div>
    </div>
	<div class="clr"></div>
	<?php 
	
	?>
	
	<?php _e(package_temples($package_type_id)); ?>
	
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 