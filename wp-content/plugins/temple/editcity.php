<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$id=$_REQUEST['id'];


$city = Citydetail($id);
$city_name = $city[0]->city;

$state_id = $city[0]->state_id;

$st = Statedetail($state_id);
$state = $st[0]->state;
$link='&ho=listcity&state_id='.$state_id;
$url=get_option('home').'/wp-admin/admin.php?page=TempleState'.$link;

if(isset($_POST['registration']))
{
	
	$city=$_POST['city'];
	if(trim($city)=='')
	{
		array_push($error,'Please enter city.');
	}
	if(count($error)<=0)
	{
		$sql="UPDATE `".$prefix."temple_city` set city='$city' where id='$id'";
		$result = $wpdb->query( $sql );
		
		$url=$url.'&update=succ';
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
<h2>Edit City </h2>

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
                    <div class="adress">City :  </div>
                    <div class="field"><input type="text" name="city" value="<?php _e($city_name); ?>" class="required"/>
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
	window.location='<?php echo $url; ?>';
}
</script>