<?php 
 /*
Template Name: Star Temples
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();

?>

<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content">
  	<h1><?php the_title(); ?></h1>
    <div class="science_box">
      <div class="all_temple1">
        <?php	 while (have_posts()) : the_post(); 
						the_content();
						endwhile;	?>
      </div>
    </div>
	<div class="clr"></div>
	<?php $starts=Stardetail();
	$star_id='-1';
	
	if(count($starts)>0){
	if(isset($_REQUEST['star']) && trim($_REQUEST['star'])!='' && trim($_REQUEST['star'])>0)
	{
		$star_id=$_REQUEST['star'];
	}else{ $star_id=$starts[0]->id;}
	?>
	<ul class="districlist tabs">
		<?php foreach($starts as $star){ ?>
		<li<?php if($star_id==$star->id){echo' class="selected"';} ?>><a href="<?php echo get_permalink() ?>?star=<?php echo $star->id; ?>" title="<?php _e($star->star); ?>"><?php _e($star->star); ?></a></li>
		<?php } ?>
	</ul>
	<div class="clr"></div>
	<?php _e(star_temples($star_id)); ?>
	<?php } ?>
	
	
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 