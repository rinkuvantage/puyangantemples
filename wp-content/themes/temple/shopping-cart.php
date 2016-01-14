<?php 
 /*
Template Name: Shopping Cart
*/

@session_start();
global $wpdb,$post;
$prefix=$wpdb->base_prefix;
get_header();
//unset($_SESSION['shoopin_cart']);
if(isset($_POST['updatecart']))
{
	unset($_SESSION['shoopin_cart']);
	if(isset($_POST['cartid']) && count($_POST['cartid'])>0)
	{
		foreach($_POST['cartid'] as $id)
		{
			unset($_POST['ids'][$id]);
		}
	}
	if(isset($_POST['ids']))
	{
		foreach($_POST['ids'] as $id)
		{
			$temple_id=$_POST['temple_id'][$id];
			$package_id=$_POST['package_id'][$id];
			$templeprices=templeprices($temple_id, " and package_id='$package_id'");
			$price=$templeprices[0]->price;
			$_SESSION['shoopin_cart']['temple_id'][]=$temple_id;
			$_SESSION['shoopin_cart']['package_id'][]=$package_id;
			$_SESSION['shoopin_cart']['price'][]=$price;
			$_SESSION['shoopin_cart']['poojadate'][]=$_POST['poojadate'][$id];
		}
	}
	$_SESSION['message']='You cart is updated.';
	echo"<script>window.location='';</script>";
	exit();
}
if(isset($_POST['proceed']))
{
	unset($_SESSION['shoopin_cart']);
	if(isset($_POST['cartid']) && count($_POST['cartid'])>0)
	{
		foreach($_POST['cartid'] as $id)
		{
			unset($_POST['ids'][$id]);
		}
	}
	if(isset($_POST['ids']))
	{
		foreach($_POST['ids'] as $id)
		{
			$temple_id=$_POST['temple_id'][$id];
			$package_id=$_POST['package_id'][$id];
			$templeprices=templeprices($temple_id, " and package_id='$package_id'");
			$price=$templeprices[0]->price;
			$_SESSION['shoopin_cart']['temple_id'][]=$temple_id;
			$_SESSION['shoopin_cart']['package_id'][]=$package_id;
			$_SESSION['shoopin_cart']['price'][]=$price;
			$_SESSION['shoopin_cart']['poojadate'][]=$_POST['poojadate'][$id];
		}
	}
	$_SESSION['message']='Proceed for the check out process.';
	echo"<script>window.location='".get_option('home')."/check-out';</script>";
	exit();
	/*wp_redirect(get_option('home').'/check-out'); 
	exit;*/
}
/*echo'<pre>';
print_r($_SESSION['shoopin_cart']);
echo'</pre>';*/
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var p = jQuery('div.mid_content');
	var offset = p.offset();
	jQuery('html, body').animate({scrollTop : offset.top},1000);
	jQuery(".poojadate").datepicker({ 
		minDate: +1,
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		yearRange: "<?php echo date('Y'); ?>:<?php echo date('Y')+10; ?>",
		showButtonPanel: true
	}).val();
});
</script>
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content" id="cart">
  <?php if(isset($_SESSION['message']) && trim($_SESSION['message'])!=''){echo'<div class="status">'.$_SESSION['message'].'</div>'; $_SESSION['message']='';} ?>
  	<h1><?php the_title(); ?></h1>
	<?php if(isset($_SESSION['shoopin_cart'])){ ?>	
	<form name="shoppingcart" action="" method="get">
	<table cellpadding="3" cellspacing="3" border="0" class="shoppingcarttable">
		<tr>
			<th valign="top" align="left">#</th>
			<th valign="top" align="left">Temple Name</th>
			<th valign="top" align="left">Pooja Date</th>
			<th valign="top" align="left">Cost <?php _e($currency_symbal); ?></th>
			<th valign="top" align="left">Del</th>
		</tr>
		<?php for($i=0;$i<count($_SESSION['shoopin_cart']['temple_id']);$i++){ $j=$i+1;
		$temple = templedetail($_SESSION['shoopin_cart']['temple_id'][$i]);
		if(isset($_SESSION['shoopin_cart']['poojadate'][$i]))
		{
			$poojadate=$_SESSION['shoopin_cart']['poojadate'][$i];
		}else{
			$poojadate=date('Y-m-d',strtotime( date('Y-m-d')." +1 day" ));
		}
		$package=packagedetail($_SESSION['shoopin_cart']['package_id'][$i]);
		?>
		<tr>
			<td valign="top" align="left"><?php echo $j; ?></td>
			<td valign="top" align="left"><?php _e($temple[0]->name); ?><br /><span class="pckg"><?php _e($package[0]->title); ?></span></td>
			<td valign="top" align="left"><input type="text" name="poojadate[]" class="poojadate" readonly="" value="<?php echo $poojadate; ?>" /></td>
			<td valign="top" align="left"><?php _e($currency_symbal.$_SESSION['shoopin_cart']['price'][$i]); ?></td>
			<td valign="top" align="left">
				<input type="checkbox" name="cartid[]" value="<?php echo $i; ?>" />
				<input type="hidden" name="temple_id[]" value="<?php _e($_SESSION['shoopin_cart']['temple_id'][$i]); ?>" />
				<input type="hidden" name="package_id[]" value="<?php _e($_SESSION['shoopin_cart']['package_id'][$i]); ?>" />
				<input type="hidden" name="ids[]" value="<?php echo $i; ?>" />
				</td>
		</tr>
		<?php } ?>
		<tr class="totalprice">
			<td valign="top" align="right" colspan="4">
				Total Amount : 	<?php _e($currency_symbal.array_sum($_SESSION['shoopin_cart']['price'])); ?>
			</td>
			<td valign="top" align="left">&nbsp;</td>
		</tr>
		<tr class="proceed">
		<td valign="top" align="left" colspan="2">&nbsp;</td>
			<td valign="top" align="left" colspan="3">
				<input type="submit" name="updatecart" value="Update" />
				<input type="submit" name="proceed" value="Proceed To Checkout" />
			</td>
			
		</tr>
	</table>
	</form>
	<?php }else{ ?>
	<p>Cart is empty!</p>
	<?php } ?>
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 