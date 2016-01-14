<?php $packagetypes=packagetypedetail(); 
if(count($packagetypes)>0){
?>
<div class="right_sidebar">
    <div class="all_temple">
      <h1>suggested packages</h1>
      <ul class="left_ul right_ul">
	  <?php foreach($packagetypes as $packagetype){ ?>
        <li><a href="<?php echo get_option('home') ?>/package/?pid=<?php echo $packagetype->id; ?>" title="<?php _e($packagetype->package_type);?>">
		<?php if(trim($packagetype->image)!='' && file_exists('wp-content/uploads/packages/'.$packagetype->image)){ ?>
			<span class="pimage"><img src="<?php echo get_option('home').'/wp-content/uploads/packages/'.$packagetype->image; ?>" width="45" /></span>
			<?php } _e('<span>'.$packagetype->package_type.'<span>');?>
</a></li>
	<?php } ?>
       
      </ul>
    </div>
    <div class="clr"></div>
  </div>
  <?php } ?>