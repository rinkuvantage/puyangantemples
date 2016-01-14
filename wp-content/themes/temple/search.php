<?php 
 
@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();
$categories=categorydetail();
$states = Statedetail();
$seachtext='';
$cnd='';
$searchlink='?s=';
if(isset($_REQUEST['s']) && trim($_REQUEST['s'])!='')
{
	$seachtext=$_REQUEST['s'];
	$srchtext=strtolower($seachtext);
	$cnd.=" and ( (lower(name) like '%$srchtext%' || lower(address) like '%$srchtext%' || lower(description) like '%$srchtext%' || lower(inthetemple) like '%$srchtext%' || lower(openinghours) like '%$srchtext%' || lower(heighlight) like '%$srchtext%' || lower(location) like '%$srchtext%' || lower(nearrailway) like '%$srchtext%' || lower(nearairport) like '%$srchtext%' || lower(general_info) like '%$srchtext%') ) ";
	$searchlink='?s='.$seachtext;
}
$category_id='';
if(isset($_REQUEST['category_id']) && trim($_REQUEST['category_id'])!='')
{
	$category_id=$_REQUEST['category_id'];
	$cnd.=" and category_id='$category_id'";
	$searchlink.='&category_id='.$category_id;
}
$state_id='';
if(isset($_REQUEST['state_id']) && trim($_REQUEST['state_id'])!='')
{
	$state_id=$_REQUEST['state_id'];
	$cnd.=" and state_id='$state_id'";
	$searchlink.='&state_id='.$state_id;
}
$city_id='';
if(isset($_REQUEST['city_id']) && trim($_REQUEST['city_id'])!='')
{
	$city_id=$_REQUEST['city_id'];
	$cnd.=" and city_id='$city_id'";
	$searchlink.='&city_id='.$city_id;
}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#state_id').live('change',function(){
		var state_id=jQuery(this).val();
		var url='<?php echo get_stylesheet_directory_uri(); ?>/findcity.php';
		jQuery.post(url, {state_id:state_id},
		function(data)
		{
			jQuery('.listcity').html(data);
		});
	});
	
	var state_id=jQuery('#state_id').val();
	if(jQuery.trim(state_id)!=''){
		var url='<?php echo get_stylesheet_directory_uri(); ?>/findcity.php';
		jQuery.post(url, {state_id:state_id,city_id:'<?php echo $city_id; ?>'},
		function(data)
		{
			jQuery('.listcity').html(data);
		});
	}
});
</script>
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content advancedsearch">
  	<h1>Search</h1>
	<div class="clr"></div>
	<div class="searchform">
		<form name="search" id="search" action="<?php echo get_option('home'); ?>" method="get">
			<table align="center" width="70%" cellpadding="3" cellspacing="3" border="0">
				<tr>
					<td align="left" valign="top">Keyword</td>
					<td align="left" valign="top"><input type="text" name="s" id="s" value="<?php _e($seachtext); ?>" /></td>
				</tr>
				<tr>
					<td align="left" valign="top">Category</td>
					<td align="left" valign="top">
						<select name="category_id">
							<option value="">-Select-</option>
							<?php if(count($categories)>0){foreach($categories as $category){ ?>
							<option value="<?php _e($category->id); ?>"<?php if($category_id==$category->id){echo' selected="selected"';} ?>><?php _e($category->category); ?></option>
							<?php }} ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">State</td>
					<td align="left" valign="top">
						<select name="state_id" id="state_id">
                        <option value="">-Select-</option>
                        	<?php if(count($states)>0){foreach($states as $st){?>	
                            	<option value="<?php _e($st->id); ?>"<?php if($state_id==$st->id){_e(' selected="selected"');} ?>><?php _e($st->state); ?></option>
							<?php }}?>
                        </select>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">City</td>
					<td align="left" valign="top" class="listcity">
						<select name="city_id" id="city_id">
                        <option value="">-Select-</option>
                        </select>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top"><input type="submit" value="Search" /></td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clr"></div>
	<?php $sch=search_temples($cnd,$searchlink);if(trim($sch)!=''){_e($sch);}else{ ?>
	<p>Search result not found.</p>
	<?php } ?>
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 