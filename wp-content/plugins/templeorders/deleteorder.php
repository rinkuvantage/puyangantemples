<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$order_id=$_REQUEST['id'];
	$city = Districtdetail($id);
	$state_id = $city[0]->state_id;
	$url=get_option('home').'/wp-admin/admin.php?page=Orders';
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."order_item` where order_id='$order_id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."orders` where order_id='$order_id'" );
	
	if($result==1) { 
		$url=$url.'&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 ?>