<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_templesgod` where id='$id'" );
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=ManageTemplesGod&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 ?>