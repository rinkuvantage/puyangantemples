<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$pack = templecalendar(''," and id='$id'");
	$temple_id = $pack[0]->temple_id;
	$image = $pack[0]->image;
	$link='&ho=listcalendar&temple_id='.$temple_id;
	if(trim($image)!='' && file_exists('../wp-content/uploads/temples/calendar/'.$image)){
		unlink('../wp-content/uploads/temples/calendar/'.$image);
	}
	
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_calendar` where id='$id'" );
	
	$url=get_option('home').'/wp-admin/admin.php?page=Temples&del=succ'.$link;
	echo"<script>window.location='".$url."'</script>";
?>