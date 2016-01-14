<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();

if(isset($_POST['registration']))
{
	$category=$_POST['category'];
	if(trim($category)=='')
	{
		array_push($error,'Please enter Category.');
	}
	$showcount=$_POST['showcount'];
	if(count($error)<=0)
	{
		$sql="INSERT INTO `".$prefix."temple_categories` (`category`, `updated_on`, `showcount`) VALUES ('$category', now(), '$showcount')";
		$result = $wpdb->query( $sql );
		if($result==1)
		{
			$url=get_option('home').'/wp-admin/admin.php?page=ManageCategories&add=succ';
			echo"<script>window.location='".$url."'</script>";
		}
	}
}

?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
});
</script>
<h2>Add Category</h2>

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
        	<form action="" method="post" name="register_spcialist" id="register_spcialist">
                <div class="e-mail">
                    <div class="adress">Category:  </div>
                    <div class="field"><input type="text" name="category" value="<?php _e($category); ?>" class="required"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Show Temples:  </div>
                    <div class="field">
						<select name="showcount">
							<option value="0"<?php if($showcount=='0'){_e(' selected="selected"');} ?>>No</option>
							<option value="1"<?php if($showcount=='1'){_e(' selected="selected"');} ?>>Yes</option>
						</select>
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
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=ManageCategories'; ?>';
}
</script>