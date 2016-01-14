<?php 
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$pack = packagedetail($id);
	$package_type_id = $pack[0]->package_type_id;
	
	$link='&ho=listpackages&id='.$package_type_id;
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_package_price` where package_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_packages` where id='$id'" );
	
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=ManagePackages&del=succ'.$link;
		echo"<script>window.location='".$url."'</script>";
	}
?>