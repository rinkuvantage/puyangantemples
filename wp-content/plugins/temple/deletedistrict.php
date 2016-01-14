<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$city = Districtdetail($id);
	$state_id = $city[0]->state_id;
	$link='&ho=listdistricts&state_id='.$state_id;
	$url=get_option('home').'/wp-admin/admin.php?page=TempleState'.$link;
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_city` where district_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_districts` where id='$id'" );
	
	if($result==1) { 
		$url=$url.'&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 ?>