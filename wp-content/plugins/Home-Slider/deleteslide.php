<?php if(isset($_REQUEST['ho']) || ($_REQUEST['ho']=='deleteslide') )
{ 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	
	$slide = sliders($_REQUEST['id']);
	$bigimage=$slide[0]->image;
	if (file_exists("../wp-content/uploads/slides/" . $bigimage))
	{
		unlink("../wp-content/uploads/slides/" .$bigimage);
	}
	$result=$wpdb->query( "DELETE FROM `".$prefix."sliders` where id=".$_REQUEST['id'] ); 
	if($result==1) {
		$url=get_option('home').'/wp-admin/admin.php?page=sliders&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 } ?>