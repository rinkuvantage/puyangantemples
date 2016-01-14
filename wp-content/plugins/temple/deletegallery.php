<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$pack = templegallery(''," and id='$id'");
	$temple_id = $pack[0]->temple_id;
	$image = $pack[0]->image;
	$link='&ho=listgallery&temple_id='.$temple_id;
	if(trim($image)!='' && file_exists('../wp-content/uploads/temples/gallery/'.$image)){
		unlink('../wp-content/uploads/temples/gallery/'.$image);
	}
	if(trim($image)!='' && file_exists('../wp-content/uploads/temples/gallery/thumb/'.$image)){
		unlink('../wp-content/uploads/temples/gallery/thumb/'.$image);
	}
	$result=$wpdb->query( "DELETE FROM `".$prefix."temple_gallery_images` where id='$id'" );
	
	$url=get_option('home').'/wp-admin/admin.php?page=Temples&del=succ'.$link;
	echo"<script>window.location='".$url."'</script>";
?>