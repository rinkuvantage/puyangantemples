<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();

$temple_id=$_REQUEST['id'];
//echo "$temple_id" ;
				

$querystr = "SELECT * FROM ".$prefix."temple_temples";
$temples = $wpdb->get_results($querystr, OBJECT);

$querystr = "SELECT * FROM ".$prefix."temple_god";
$gods = $wpdb->get_results($querystr, OBJECT);


if(isset($_POST['registration']))
{
	$temple_id=$_POST['temple_id'];
	if(trim($temple_id)=='')
	{
		$temple_id=0;
	}
	$god_id=$_POST['god_id'];
	if(count($error)<=0)
	{
		for($i = 0; $i < count($god_id); $i++){
            //echo $god_id[$i];
            //$carGroups = mysql_query("INSERT INTO car_groups VALUES('$company','$god_id[$i]]')");
			$sql="INSERT INTO `".$prefix."temple_templesgod` (`temple_id`, `god_id`, `updated_on`) VALUES ('$temple_id', '$god_id[$i]', now())"; 
			$result = $wpdb->query( $sql );
			if($result==1)
			{
				$url=get_option('home').'/wp-admin/admin.php?page=ManageTemplesGod&add=succ';
				echo"<script>window.location='".$url."'</script>";
			}
        }
	}
}

?>
<style type="text/css">
.error
{
	color:#CC0000;
}
.donotshowerror label.error
{
	display: none !important;
}
label.error
{
	margin-left:10px;
}
input.error, select.error,textarea.error, checkbox.error
{
	color:#000000;
	border:1px solid #CC0000 !important;
}
input[type='checkbox'].error
{
	border: solid #CC0000;
	outline:1px solid #CC0000 !important;
}
.personal_info{float:left; width:160px;}
.e-mail{ clear:both;}
.adress{ width:168px; float:left; text-align:left; font-size:13px; color:#454546;}
.field{ float:left; width:600px;}
input[type="checkbox"]{ width:0 !important; height:0px !important; padding:0 !important; border:1px solid #c7cecf;  border:1px solid #c7cecf; margin:0px !important; background:#f0f0f0; }
.dropdown-menu a
{
	color:#000 !important;
	text-decoration:none;
}
.field input, .field select{ width:324px; height:30px; padding:0 !important; border:1px solid #c7cecf;  border:1px solid #c7cecf; margin:0px 0px 10px 0; background:#f0f0f0; }
.field textarea{ width:500px; padding:0 !important; border:1px solid #c7cecf;  border:1px solid #c7cecf; margin:0px 0px 10px 0; background:#f0f0f0; }
.profile .green-submit-btn input[type="submit"], .profile .green-submit-btn input[type="button"]{ width:152px; border:1px solid #b4babb; height: 45px; line-height:45px; text-align:center; color:#000; font-size:17px; font-weight:bold; border-radius:5px; display:block; font-family:Arial, Helvetica, sans-serif; cursor:pointer; }
.profile .green-submit-btn input[type="button"]{ margin-left:20px;}
.field .wp-core-ui input, .field .wp-core-ui select{ width:auto; height:auto;}
input, select, textarea{float:left;}
.clr{clear:both; margin-top:10px;}.mr5{margin-right:5px;}
.fl{float:left;}.removeday, .addday{float:left; color:#FF0000; font-size:18px; text-decoration:none; margin-left:10px;}.addday{color:#0000FF;}
.tt{float:left; width:70px;}
.sparator{width:600px; margin:5px 0px; height:1px; border-bottom:1px solid #000000;} 
.ml10{margin-left:10px;}
</style>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
});
</script>
<h2>Add Temples God</h2>

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
<?php 
if($temple_id>0)
{ 
	$temple_id = $temple_id; 
	
	$temple = templedetail($temple_id);
	$temple_name = $temple[0]->temple;
?>  
        	<form action="" method="post" name="register_spcialist" id="register_spcialist">
                <div class="e-mail">
                    <div class="adress">Temple:  </div>
                    <div class="field">
                    <input type="hidden" name="temple_id" value="<?php echo "$temple_id" ;?>" readonly="readonly"/>
                    <input type="text" name="temple" value="<?php echo "$temple_name" ;?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="e-mail">
                    <div class="adress">God:  </div>
                    <div class="field">
					<?php
						foreach($gods as $temgod)
						{
					?>	
                    	<input type="checkbox" value="<?php _e($temgod->id); ?>" name="god_id[]"/><?php _e($temgod->god); ?>
						<br/>
					<?php		
						}
					?>
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
            
<?php
}
else
{
?>
<form action="" method="post" name="register_spcialist" id="register_spcialist">
                <div class="e-mail">
                    <div class="adress">Temple:  </div>
                    <div class="field">
                    	<select name="temple_id">
                        	<?php
								foreach($temples as $temple)
								{
							?>	<option value="<?php _e($temple->id); ?>"><?php _e($temple->temple); ?></option>
							<?php		
								}
							?>
                        </select>
                    </div>
                </div>
                <div class="e-mail">
                    <div class="adress">God:  </div>
                    <div class="field">
					<?php
						foreach($gods as $temgod)
						{
					?>	
                    	<input type="checkbox" value="<?php _e($temgod->id); ?>" name="god_id[]"/><?php _e($temgod->god); ?>
						<br/>
					<?php		
						}
					?>
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
<?php 
}
?>
            </div>
        </div>
<div class="clr"></div>

<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=ManageTemplesGod'; ?>';
}
</script>