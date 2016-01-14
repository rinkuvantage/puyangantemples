<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$id=$_REQUEST['id'];


$pack = packagedetail($id);
$package_type_id = $pack[0]->package_type_id;
$title = $pack[0]->title;
$short_desc = $pack[0]->short_desc;
$description = $pack[0]->description;

$link='&ho=listpackages&id='.$package_type_id;

if(isset($_POST['registration']))
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
		$sql="UPDATE `".$prefix."temple_packages` set title='$title', short_desc='$short_desc', description='$description' where id='$id'";
		$result = $wpdb->query( $sql );
		
		$url=get_option('home').'/wp-admin/admin.php?page=ManagePackages&update=succ'.$link;
		echo"<script>window.location='".$url."'</script>";
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
<h2>Edit Package </h2>

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
            	<input type="hidden" name="id" value="<?php _e($id); ?>" />
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
                        	<input type="submit" name="registration" value="SUBMIT" /> 
                            <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
                       
                         </div>
                    </div>
                </div>
                
            </form>
            
            </div>
            <div class="clr"></div>
        </div>
<div class="clr"></div>

<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=ManagePackages'.$link; ?>';
}
</script>