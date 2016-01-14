<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();

if(isset($_POST['registration']))
{
	$package=$_POST['package'];
	if(trim($package)=='')
	{
		array_push($error,'Please enter package.');
	}
	$description=$_POST['description'];
	
	if(count($error)<=0)
	{
		$sql="INSERT INTO `".$prefix."temple_package_types` (`package_type`, `description`, `add_date`) VALUES ('$package', '$description', now())";
		$result = $wpdb->query( $sql );
		if($result==1)
		{
			$package_type_id = $wpdb->insert_id;
			$file='image';
			$alias='package-'.$package_type_id;
			if(isset($_FILES[$file]['name']))
			{
				if (!is_dir('../wp-content/uploads/packages')) {
					mkdir('../wp-content/uploads/packages');
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
							$exts=explode('.',$_FILES[$file]["name"]);
							$exten='.'.$exts[count($exts)-1];
							$altername=$alias.$exten;
							move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/packages/" . $_FILES[$file]["name"]);
							rename("../wp-content/uploads/packages/".$_FILES[$file]["name"], "../wp-content/uploads/packages/$altername");
	
							$sql="UPDATE `".$prefix."temple_package_types` set image='$altername' where id='$package_type_id'";
							$result = $wpdb->query( $sql );
						}
					}
				}
			}
			$url=get_option('home').'/wp-admin/admin.php?page=ManagePackages&add=succ';
			echo"<script>window.location='".$url."'</script>";
		}
	}
}

?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
});
</script>
<h2>Add Package Type</h2>

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
	<?php	} ?>
		</table>
		<div class="clr mt20"></div>
	 <?php } ?>
        <div class="right donotshowerror">
        	<form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
                <div class="e-mail">
                    <div class="adress">Package Type:  </div>
                    <div class="field"><input type="text" name="package" value="<?php _e($package); ?>" class="required"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Image:  </div>
                    <div class="field"><input type="file" name="image" /></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Detail:  </div>
                    <div class="field">
						<textarea name="description" rows="5" cols="100"><?php _e($description); ?></textarea>
					</div>
                </div>
                <div class="clr"></div>
                <div class="e-mail">
                    <div class="adress">&nbsp;&nbsp;</div>
                    <div class="field" style="margin-top:10px;">
                        <div class="green-submit-btn">
                        	<input type="submit" name="registration" value="SUBMIT" class="registration_btn"/> <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
                       
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
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=ManagePackages'; ?>';
}
</script>