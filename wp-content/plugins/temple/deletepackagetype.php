<?php 
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_package_price` where package_type_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_packages` where package_type_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_package_types` where id='$id'" );
	
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=ManagePackages&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}
?>