<h2>Add Slide</h2>
<?php 
session_start();
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();

if(isset($_POST['download']))
{
	$title=$_POST['title'];
	if(trim($title)=='')
	{
		array_push($error,'Please enter title.');
	}
	$detail=$_POST['detail'];
	$link=$_POST['link'];
	
	if(count($error)<=0)
	{
		$time=time();
		$sql="INSERT INTO `".$prefix."sliders` (`title`, `detail`, `link`) VALUES ('$title', '$detail', '$link')";
		$result = $wpdb->query( $sql );
		if($result==1)
		{
			$lastid=$wpdb->insert_id;
			$alias='slide-'.$lastid;
			
			$file='slide';
			if(isset($_FILES[$file]['name']))
			{
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
							if (!is_dir('../wp-content/uploads/slides')) {
								mkdir('../wp-content/uploads/slides');
							}
							
							$exts=explode('.',$_FILES[$file]["name"]);
							$exten='.'.$exts[count($exts)-1];
							$altername=$alias.$exten;
							move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/slides/" . $_FILES[$file]["name"]);
							rename("../wp-content/uploads/slides/".$_FILES[$file]["name"], "../wp-content/uploads/slides/$altername");
							$sql="UPDATE `".$prefix."sliders` set image='$altername' where id='$lastid'";
							$result = $wpdb->query( $sql );
						}
					}
				}
			}
			
			$url=get_option('home').'/wp-admin/admin.php?page=sliders&add=succ';
			echo"<script>window.location='".$url."'</script>";
		}
	}
}			

?>
<link href="<?php echo plugin_dir_url( __FILE__ );?>css/pagedesign.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#register_spcialist").validate();
});

</script>

	  <form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
		<?php if(count($error)>0)
	  { ?>
	<div class="tabletitle"><span class="error">Error</span></div>
        <table width="700" class="from_main" border="0" cellpadding="5" cellspacing="5">
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
	<div class="clr"></div>
    <table width="700" class="from_main" border="0" cellpadding="5" cellspacing="5">
        <tr>
        	<td align="left" valign="top" class="name">Title :<span class="error">*</span></td>
            <td align="left" valign="top" class="field"><input type="text" name="title" value="<?php _e($title); ?>" class="feidls_input required"/></td>
        </tr>
        <tr>
        	<td align="left" valign="top" class="name">Slide :<span class="error">*</span></td>
            <td align="left" valign="top" class="field"><input type="file" name="slide" class="required"/></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Detail :</td>
            <td align="left" valign="top" class="field" colspan="3">
			<textarea name="detail" rows="3" cols="50"><?php _e($detail); ?></textarea>
			</td>
        </tr>
    	 <tr>
        	<td align="left" valign="top" class="name">Url :</td>
            <td align="left" valign="top" class="field"><input type="text" name="link" value="<?php _e($link); ?>" class="feidls_input url"/></td>
        </tr>
    	<tr>
        	<td align="left" valign="top" class="name">&nbsp;</td>
            <td align="left" valign="top" class="field" colspan="3">
            	<input type="submit" name="download" value="Submit" title="Submit" />&nbsp;&nbsp;
                <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
            </td>
        </tr>
    </table>
		</form>
<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=sliders'; ?>';
}
</script>