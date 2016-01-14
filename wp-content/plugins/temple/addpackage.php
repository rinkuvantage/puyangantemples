<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$package_type_id=$_REQUEST['id'];

$link='&ho=listpackages&id='.$package_type_id;
				
$packagetypes =packagetypedetail();
$error=array();
if(isset($_POST['addcity']))
{
	
	$title=$_POST['title'];
	if(trim($title)=='')
	{
		array_push($error,'Please enter package.');
	}
	$short_desc=$_POST['short_desc'];
	$description=$_POST['description'];
	
	if(count($error)<=0)
	{		
		$sql="INSERT INTO `".$prefix."temple_packages` (`package_type_id`, `title`,`short_desc`, `description`, `add_date`) VALUES ('$package_type_id',  '$title', '$short_desc', '$description', now())";
		$result = $wpdb->query( $sql );
		
		if($result==1)
		{
			$url=get_option('home').'/wp-admin/admin.php?page=ManagePackages&add=succ'.$link;
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
<h2>Add Package</h2>

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

        	<form action="" method="post" name="register_spcialist" id="register_spcialist">
			<?php 
				if($package_type_id>0)
				{ 
				?>
				<input type="hidden" name="id" value="<?php _e($package_type_id); ?>"/>
				<?php 
				}else{ 
				?>
                <div class="e-mail">
                    <div class="adress">Package Type :  </div>
                    <div class="field">
                         
						
                        <select name="id" class="required">
                        	<?php
								foreach($packagetypes as $st)
								{
							?>	
                            	<option value="<?php _e($st->id); ?>"><?php _e($st->package_type); ?></option>
							<?php		
								}
							?>
                        </select>
                        
                    </div>
                </div>
				<?php }?>
                <div class="e-mail">
                    <div class="adress">Package :  </div>
                    <div class="field"><input type="text" name="title" value="<?php _e($title); ?>" class="required" /></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Short Description:  </div>
                    <div class="field">
						<textarea name="short_desc" rows="5" cols="100"><?php _e($short_desc); ?></textarea>
					</div>
                </div>
				<div class="e-mail">
                    <div class="adress">Detail:  </div>
                    <div class="field">
						<textarea name="description" rows="10" cols="100"><?php _e($description); ?></textarea>
					</div>
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
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=ManagePackages'.$link; ?>';
}
</script>