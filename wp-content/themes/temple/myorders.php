<?php 
 /*
Template Name: My Orders
*/
@ob_start();
@session_start();
global $wpdb, $current_user;
get_currentuserinfo();
$prefix=$wpdb->base_prefix;
get_header();
$errors=array();

if(!is_user_logged_in())
{
	$_SESSION['message']='Please login first.';
	echo"<script>window.location='".get_option('home')."/login'</script>";
	exit();
}
else
{
	$user_id=$current_user->ID;
	$userdata=get_userdata( $user_id );
	$email=$userdata->user_email ;	
	$fname=$userdata->first_name;
	$lname=$userdata->last_name;
	$totalrec=20;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	$showdetail=false;
	if(isset($_REQUEST['oid']) && trim($_REQUEST['oid'])!='')
	{
		$order_id=$_REQUEST['oid'];
		$showdetail=true;
		$orders=orders($order_id, " and user_id='$user_id'");
		$order=$orders[0];
		$orderstatus=$order->order_status;
		$orderitems=orderitems(" and order_id='$order_id' and user_id='$user_id'");
	}
	else
	{
		$cond=" and user_id='$user_id' order by order_id desc";
		$orders=orders('', $cond." limit $limitstart, $totalrec");
		
		$querystr = "SELECT count(*) as total FROM ".$prefix."orders where order_id!='' $cond";
		$total = $wpdb->get_results($querystr, OBJECT);
	}
}

?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var p = jQuery('div.mid_content');
	var offset = p.offset();
	jQuery('html, body').animate({scrollTop : offset.top},1000);
	
});
</script>
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content page_content">
  <?php if(isset($_SESSION['message']) && trim($_SESSION['message'])!=''){echo'<div class="status">'.$_SESSION['message'].'</div>'; $_SESSION['message']='';} ?>
  	<h1><?php the_title(); ?></h1>
	<?php 
	
	if(count($errors)>0)
	{
		foreach($errors as $error)
		{
			echo '<div class="error">'.$error.'</div><div class="clr"></div>';
		}
	}
	if($showdetail)
	{
		if(count($orderitems)>0){ ?>
		<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="orderitems">
			<tr>
				<th valign="top" align="left"><?php _e("Temple Name" ); ?></th>
				<th valign="top" align="left"><?php _e("Package" ); ?></th>
				<th valign="top" align="left"><?php _e("Pooja Date" ); ?></th>
				<th valign="top" align="left"><?php _e("Cost".$currency_symbal); ?></th>
			</tr>
		<?php 
			$cnt=$limitstart+1; 
			foreach($orderitems as $orderitem)
			{ 
		?>
		  <tr>
			<td valign="top" align="left"><?php _e($orderitem->temple_name); ?></td>
			<td valign="top" align="left"><?php _e($orderitem->package_name); ?></td>
			<td valign="top" align="left"><?php echo date('jS F Y',strtotime($orderitem->package_date)); ?></td>
			<td valign="top" align="left"><?php echo $currency_symbal.$orderitem->product_item_price; ?></td>
		  </tr>
		  <?php $cnt++; } ?>
		  <tr>
			<td valign="top" align="left" colspan="2">&nbsp;</td>
			<td valign="top" align="left"><strong>Total Amount</strong></td>
			<td valign="top" align="left"><?php echo $currency_symbal.number_format($order->order_total, 2, '.', ''); ?></td>
		  </tr>
		</table>
		<?php 
		} 
		else
		{
			echo "<strong>No Order Item!</strong>" ;
		}
		?>
		<table width="50%" align="left" border="0" cellpadding="0" cellspacing="0" class="orderdetail">
			<tr>
				<th valign="top" align="left">Order Id</th>
				<td valign="top" align="left"><?php _e($order->order_id); ?></td>
			</tr>
			<tr>
				<th valign="top" align="left">Order Date</th>
				<td valign="top" align="left"><?php echo date('jS F Y h:i A',strtotime($order->cdate)); ?></td>
			</tr>
			<tr>
				<th valign="top" align="left">Order Status</th>
				<td valign="top" align="left"><?php echo orderstatus($order->order_status); ?></td>
			</tr>
			<tr>
				<th valign="top" align="left">Payment Gateway</th>
				<td valign="top" align="left"><?php _e($order->gateway_name); ?></td>
			</tr>
			<tr>
				<th valign="top" align="left">Your IP</th>
				<td valign="top" align="left"><?php _e($order->ip_address); ?></td>
			</tr>
			<tr>
				<th valign="top" align="left">Your Message</th>
				<td valign="top" align="left"><?php _e($order->usermessage); ?></td>
			</tr>
		</table>
		<div class="clr"></div>
		<div class="backtoorders"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">Back</a></div>
		<?php
				
	}
	else
	{
		if(count($orders)>0){
		?>
		<table cellpadding="3" cellspacing="3" border="0" class="listorders">
			<tr>
				<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
				<th valign="top" align="left"><?php _e("Order Id" ); ?></th>
				<th valign="top" align="left"><?php _e("Email" ); ?></th>
				<th valign="top" align="left"><?php _e("Date and Time" ); ?></th>
				<th valign="top" align="left"><?php _e("Status" ); ?></th>
				<th valign="top" align="left"><?php _e("Actions" ); ?></th>
			</tr>
			<?php 
			$cnt=$limitstart+1; 
			foreach($orders as $order)
			{ 
		?>
		  <tr>
			<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
			<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->order_id); ?></td>
			<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($email); ?></td>
			<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo date('jS F Y h:i A',strtotime($order->cdate)); ?></td>
			<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo orderstatus($order->order_status); ?></td>
			<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
				<a href="<?php _e(get_permalink()); ?>?oid=<?php _e($order->order_id); ?>" title="View Detail">View Detail</a>
			</td>
		  </tr>
		  <?php $cnt++; } ?>
		</table>
		
	<?php 
		if($total[0]->total>count($orders))
		{
			$url=get_permalink().'?pagedid=';
			echo pagination($totalrec,$pageid,$url,$total[0]->total);
		}
	}else{ ?>
	<p>There is no order</p>
<?php }} ?>
  </div>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 