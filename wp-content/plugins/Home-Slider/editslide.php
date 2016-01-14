<h2>View &amp; Edit Slide</h2>
<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$id=$_REQUEST['id'];
$slide = $slide = sliders($id);

$title=$slide[0]->title;
$image=$slide[0]->image;
$detail=$slide[0]->detail;
$link=$slide[0]->link;

$error=array();


if(isset($_POST['updateslide']))
{
	$title=$_POST['title'];
	if(trim($title)=='')
	{
		array_push($error,'Please enter title.');
	}
	$detail=$_POST['detail'];
	$link=$_POST['link'];
	$file='slide';
	$alias='slide-'.$id;
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
					if (file_exists("../wp-content/uploads/slides/" . $image))
					{
						unlink("../wp-content/uploads/slides/" .$image);
					}
					
					$exts=explode('.',$_FILES[$file]["name"]);
					$exten='.'.$exts[count($exts)-1];
					$altername=$alias.$exten;
					  move_uploaded_file($_FILES[$file]["tmp_name"],
					  "../wp-content/uploads/slides/" . $_FILES[$file]["name"]);
					  
					  rename("../wp-content/uploads/slides/".$_FILES[$file]["name"], "../wp-content/uploads/slides/$altername");
					  
					$image=$altername;
				}
			}
		}
	}
	
	
	
	if(count($error)<=0)
	{
		
		$time=time();
		
		$sql="UPDATE `".$prefix."sliders` set image='$image', title='$title', detail='$detail', link='$link' where id='$id'";
		
		$result = $wpdb->query( $sql );
		
		$url=get_option('home').'/wp-admin/admin.php?page=sliders&update=succ';
		echo"<script>window.location='".$url."'</script>";
		
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
	  <input name="id" type="hidden" value="<?php _e($id); ?>" />
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
            <td align="left" valign="top" class="field">
             <input type="file" name="slide" <?php if(trim($image)=='' || trim($image)=='0'){_e('class="required"');} ?> />
            <br style="clear:both;" />
            <?php if(trim($image)!='' || trim($image)!='0'){?><img src="<?php echo get_option('home'); ?>/wp-content/uploads/slides/<?php echo $image; ?>" width="100" alt="<?php _e($title); ?>" /><?php } ?>
            </td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Detail :</td>
            <td align="left" valign="top" class="field" colspan="3"><textarea name="detail" rows="3" cols="50"><?php _e($detail); ?></textarea></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Url :</td>
            <td align="left" valign="top" class="field"><input type="text" name="link" value="<?php _e($link); ?>" class="feidls_input url"/></td>
        </tr>
        <tr>
        	<td align="left" valign="top" class="name">&nbsp;</td>
            <td align="left" valign="top" class="field" colspan="3">
            	<input type="submit" name="updateslide" value="Save" title="Save" />&nbsp;&nbsp;
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