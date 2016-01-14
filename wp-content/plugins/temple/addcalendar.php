<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$temple_id=$_REQUEST['temple_id'];

$link='&ho=listcalendar&temple_id='.$temple_id;
				
$error=array();
if(isset($_POST['addcity']))
{
	
	$cdate=$_POST['cdate'];
	if(trim($cdate)=='')
	{
		array($error,'Please enter date');
	}
	$special=$_POST['special'];
	$title=$_POST['title'];
	$worship=$_POST['worship'];
	
	if(count($error)<=0)
	{		
		$sql="INSERT INTO `".$prefix."temple_calendar` (`temple_id`, `cdate`, `special`, `worship`, `title`) VALUES ('$temple_id',  '$cdate',  '$special',  '$worship', '$title')";
		$result = $wpdb->query( $sql );
		$id = $wpdb->insert_id;
		$file='image';
		if(isset($_FILES[$file]['name']))
		{
			if (!is_dir('../wp-content/uploads/temples/')) {
				mkdir('../wp-content/uploads/temples');
			}
			if (!is_dir('../wp-content/uploads/temples/calendar')) {
				mkdir('../wp-content/uploads/temples/calendar');
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
						move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/temples/calendar/" . $_FILES[$file]["name"]);
						rename("../wp-content/uploads/temples/calendar/".$_FILES[$file]["name"], "../wp-content/uploads/temples/calendar/$altername");

						$sql="UPDATE `".$prefix."temple_calendar` set image='$altername' where id='$id'";
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
<link rel="stylesheet" type="text/css" href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/ui-lightness/jquery-ui-1.8.18.custom.css" />
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
	
	jQuery("#cdate").datepicker({ 
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true
	}).val();
});
</script>
<h2>Add New</h2>

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
                    <div class="field"><input type="text" name="title" class="required" value="<?php _e($title); ?>" /></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Date :  </div>
                    <div class="field"><input type="text" name="cdate" class="required" id="cdate" value="<?php _e($cdate); ?>" /></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Image :  </div>
                    <div class="field"><input type="file" name="image"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Special :  </div>
                    <div class="field"><textarea name="special" rows="3" cols="80"><?php _e($special); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Worship :  </div>
                    <div class="field"><textarea name="worship" rows="3" cols="80"><?php _e($worship); ?></textarea></div>
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