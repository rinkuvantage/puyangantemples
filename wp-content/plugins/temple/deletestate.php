<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_city` where state_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_districts` where state_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_state` where id='$id'" );
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=TempleState&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}
?>