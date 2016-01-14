<?php 
 /*
Template Name: Ten Temples
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
	<?php //$disticts=Districtdetail();
	$querystr = "SELECT d.* FROM ".$prefix."temple_temples as t,".$prefix."temple_districts as d where d.id=t.district_id group by d.id";
	$disticts = $wpdb->get_results($querystr, OBJECT);
	$district_id='-1';
	
	if(count($disticts)>0){
	if(isset($_REQUEST['dist']) && trim($_REQUEST['dist'])!='' && trim($_REQUEST['dist'])>0)
	{
		$district_id=$_REQUEST['dist'];
	}else{ $district_id=$disticts[0]->id;}
	?>
	<ul class="districlist tabs">
		<?php foreach($disticts as $distict){ ?>
		<li<?php if($district_id==$distict->id){echo' class="selected"';} ?>><a href="<?php echo get_permalink() ?>?dist=<?php echo $distict->id; ?>" title="<?php _e($distict->district); ?>"><?php _e($distict->district); ?></a></li>
		<?php } ?>
	</ul>
	<div class="clr"></div>
	<?php _e(ten_temples($district_id)); ?>
	<?php } ?>
	
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 