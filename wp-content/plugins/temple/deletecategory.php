<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_categories` where id='$id'" );
	
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=ManageCategories&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}
?>