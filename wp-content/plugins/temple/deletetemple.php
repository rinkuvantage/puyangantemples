<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$temple = templedetail($id);
	$post_id=$temple[0]->post_id;
	$image=$temple[0]->image;
	if(trim($image)!='' && file_exists('../wp-content/uploads/temples/'.$image)){
		unlink('../wp-content/uploads/temples/'.$image);
	}
	if(trim($image)!='' && file_exists('../wp-content/uploads/temples/thumb/'.$image)){
		unlink('../wp-content/uploads/temples/thumb/'.$image);
	}
	$result=$wpdb->query( "DELETE FROM `".$prefix."posts` where ID='$post_id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_temples` where id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_templesgod` where temple_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_package_price` where temple_id='$id'" );
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_options` where temple_id='$id'" );
	$url=get_option('home').'/wp-admin/admin.php?page=Temples&del=succ';
		echo"<script>window.location='".$url."'</script>";
?>