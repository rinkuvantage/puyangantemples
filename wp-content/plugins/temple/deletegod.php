<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$temgod = Statedetail($id);
	$god=$temgod[0]->god;
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_god` where id='$id'" );
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=ManageGod&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 ?>