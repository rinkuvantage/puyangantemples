<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$blog_id = $wpdb->blogid;
$state_id=$_REQUEST['state_id'];

$link='&ho=listdistricts&state_id='.$state_id;
$url=get_option('home').'/wp-admin/admin.php?page=TempleState'.$link;
				
$querystr = "SELECT * FROM ".$prefix."temple_state";
$states = $wpdb->get_results($querystr, OBJECT);
 
$error=array();
if(isset($_POST['adddistrict']))
{
	
	$district=$_POST['district'];
	if(trim($district)=='')
	{
		array_push($error,'Please enter district.');
	}
	
	if(count($error)<=0)
	{		$sql="INSERT INTO `".$prefix."temple_districts` (`state_id`, `district`,`updated_on`) VALUES ('$state_id',  '$district', now())";
			$result = $wpdb->query( $sql );
			
			if($result==1)
			{
				$url=$url.'&add=succ';
				echo"<script>window.location='".$url."'</script>";
			}
	}
}

?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
});
</script>
<h2>Add District</h2>

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
				if($state_id>0)
				{ 
				?>
				<input type="hidden" name="state_id" value="<?php _e($state_id); ?>"/>
				<?php 
				}else{ 
				?>
                <div class="e-mail">
                    <div class="adress">State :  </div>
                    <div class="field">
                         
						
                        <select name="id" class="required">
                        	<?php
								foreach($states as $st)
								{
							?>	
                            	<option value="<?php _e($st->id); ?>"><?php _e($st->state); ?></option>
							<?php		
								}
							?>
                        </select>
                        
                    </div>
                </div>
				<?php }?>
                <div class="e-mail">
                    <div class="adress">District :  </div>
                    <div class="field"><input type="text" name="district" class="required" /></div>
                </div>
                <div class="clr"></div>
                <div class="e-mail">
                    <div class="adress">&nbsp;&nbsp;</div>
                    <div class="field" style="margin-top:10px;">
                        <div class="green-submit-btn">
                        	<input type="submit" name="adddistrict" value="SUBMIT" class="registration_btn"/> <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
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
	window.location='<?php echo $url; ?>';
}
</script>