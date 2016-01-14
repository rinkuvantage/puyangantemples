<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$temple_id=$_REQUEST['temple_id'];

$link='&ho=listgallery&temple_id='.$temple_id;
				
$error=array();
if(isset($_POST['addcity']))
{
	
	$title=$_POST['title'];
	
	if(count($error)<=0)
	{		
		$sql="INSERT INTO `".$prefix."temple_gallery_images` (`temple_id`, `title`) VALUES ('$temple_id',  '$title')";
		$result = $wpdb->query( $sql );
		$id = $wpdb->insert_id;
		$file='image';
		if(isset($_FILES[$file]['name']))
		{
			if (!is_dir('../wp-content/uploads/temples/')) {
				mkdir('../wp-content/uploads/temples');
			}
			if (!is_dir('../wp-content/uploads/temples/gallery')) {
				mkdir('../wp-content/uploads/temples/gallery');
			}
			if (!is_dir('../wp-content/uploads/temples/gallery/thumb')) {
				mkdir('../wp-content/uploads/temples/gallery/thumb');
			}
			if($_FILES[$file]['name']!='')
			{
				if ( (strtolower($_FILES[$file]["type"]) == "image/gif")
				|| (strtolower($_FILES[$file]["type"]) == "image/jpeg")
				|| (strtolower($_FILES[$file]["type"]) == "image/jpg")
				|| (strtolower($_FILES[$file]["type"]) == "image/png")
				|| (strtolower($_FILES[$file]["type"]) == "image/pjpeg"))
				  {
					if ($_FILES[$file]["error"] > 0)
					{
						 echo "Error: " . $_FILES[$file]["error"] . "<br />";
					}
					else
					{
						$alias='image-'.$id;
						$exts=explode('.',$_FILES[$file]["name"]);
						$exten='.'.$exts[count($exts)-1];
						$altername=$alias.$exten;
						move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/temples/gallery/" . $_FILES[$file]["name"]);
						rename("../wp-content/uploads/temples/gallery/".$_FILES[$file]["name"], "../wp-content/uploads/temples/gallery/$altername");
						
						require_once('class.img2thumb.php');
						$Img2Thumb = new Img2Thumb( "../wp-content/uploads/temples/gallery/".$altername, '300', '300', "../wp-content/uploads/temples/gallery/thumb/".$altername, 0, 255, 255, 255 );

						$sql="UPDATE `".$prefix."temple_gallery_images` set image='$altername' where id='$id'";
						$result = $wpdb->query( $sql );
					}
				}
			}
		}
		if($result==1)
		{
			$url=get_option('home').'/wp-admin/admin.php?page=Temples&add=succ'.$link;
			echo"<script>window.location='".$url."'</script>";
		}
	}
}

?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
});
</script>
<h2>Add Photo</h2>

	<div class="profile donotshowerror">
    	<?php if(count($error)>0)
		  { ?>
		<div class="tabletitle"><span class="error">Error</span></div>
		<table width="700" class="from_main" border="0" cellpadding="0" cellspacing="0">
		  <?php 
		    for($i=0;$i<count($error);$i++)
			{
		 ?>
			<tr>
				<td align="left" valign="top" class="name"><span class="error"><?php echo $error[$i]; ?></span></td>
			</tr>
	     <?php	
	       }
		 ?>
		</table>
		<div class="clr mt20"></div>
	 <?php } ?>
        <div class="right donotshowerror">

        	<form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
			
				<input type="hidden" name="temple_id" value="<?php _e($temple_id); ?>"/>
				
                <div class="e-mail">
                    <div class="adress">Title :  </div>
                    <div class="field"><input type="text" name="title" value="<?php _e($title); ?>" /></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Image *:  </div>
                    <div class="field"><input type="file" class="required" name="image"/></div>
                </div>
                <div class="clr"></div>
                <div class="e-mail">
                    <div class="adress">&nbsp;&nbsp;</div>
                    <div class="field" style="margin-top:10px;">
                        <div class="green-submit-btn">
                        	<input type="submit" name="addcity" value="SUBMIT" class="registration_btn"/> <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
                       </div>
                    </div>
                </div>
             </form>
            </div>
        </div>
<div class="clr"></div>

<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=Temples'.$link; ?>';
}
</script>