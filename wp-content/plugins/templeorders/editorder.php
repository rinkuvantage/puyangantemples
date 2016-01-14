<?php 
global $wpdb,$currency_symbal;
$prefix=$wpdb->base_prefix;
$error=array();
$order_id=$_REQUEST['id'];

$orders=orders($order_id);
$order=$orders[0];
$orderstatus=$order->order_status;
$orderitems=orderitems(" and order_id='$order_id'");

$user_id=$order->user_id;
$userdata=get_userdata( $user_id );
$email=$userdata->user_email ;	
$fname=$userdata->first_name;
$lname=$userdata->last_name;
$address = get_user_meta( $user_id, 'address', true );
$address2 = get_user_meta( $user_id, 'address2', true );
$city = get_user_meta( $user_id, 'city', true );
$zipcode = get_user_meta( $user_id, 'zipcode', true );
$state = get_user_meta( $user_id, 'state', true );
$country = get_user_meta( $user_id, 'country', true );
$phone = get_user_meta( $user_id, 'phone', true );
$gender = get_user_meta( $user_id, 'gender', true );
$differentshipping=get_user_meta( $user_id, 'differentshipping', true );

$ship_fname= get_user_meta( $user_id, 'ship_fname', true );
$ship_lname= get_user_meta( $user_id, 'ship_lname', true );
$ship_address = get_user_meta( $user_id, 'ship_address', true );
$ship_address2 = get_user_meta( $user_id, 'ship_address2', true );
$ship_city = get_user_meta( $user_id, 'ship_city', true );
$ship_zipcode = get_user_meta( $user_id, 'ship_zipcode', true );
$ship_state = get_user_meta( $user_id, 'ship_state', true );
$ship_country = get_user_meta( $user_id, 'ship_country', true );
$ship_phone = get_user_meta( $user_id, 'ship_phone', true );

$url=get_option('home').'/wp-admin/admin.php?page=Orders';

if(isset($_POST['updateorder']))
{
	
	$orderstatus=$_POST['orderstatus'];
	
	$sql="UPDATE `".$prefix."orders` set order_status='$orderstatus' where order_id='$order_id'";
	$result = $wpdb->query( $sql );
	
	$sql="UPDATE `".$prefix."order_item` set order_status='$orderstatus' where order_id='$order_id'";
	$result = $wpdb->query( $sql );
	
	if(($order->order_status=='C' && $orderstatus=='S') || ($order->order_status=='P' && $orderstatus=='S'))
	{
		$to      = $email;		
		$subject = get_option('blogname').' :: Temple booking is completed.';	
		$from = get_option('admin_email');
		//header information
		
		$attachments = array(WP_CONTENT_DIR.'/uploads/orders/order_confirmation_'.$order_id.'.pdf');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$fromname=get_option('blogname');
		$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
		
		$message="<b>Hello ".$fname." ".$lname.",</b><br /><br />";
		$message.='Thanks For booking from '.get_option('blogname').' You booking is successfully completed<br />Attached is your booking detail.';
		$message.='<br /><br />Thanks<div style="clear:both;margin-top:10px;"></div>'.get_option('blogname');
		
		wp_mail($to, $subject, $message, $headers, $attachments);
	}
	$url=$url.'&update=succ';
	echo"<script>window.location='".$url."'</script>";
}

?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/templeorders/css/pagedesign.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/templeorders/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/templeorders/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	
	jQuery("#register_spcialist").validate();
	
});
</script>
<h2>Order Detail </h2>

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
            	<input type="hidden" name="id" value="<?php _e($order_id); ?>" />
               
                <?php if(count($orderitems)>0){ ?>
				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
					<tr>
						<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Name" ); ?></th>
						<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Package" ); ?></th>
						<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Pooja Date" ); ?></th>
						<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Quantity" ); ?></th>
						<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Cost".$currency_symbal); ?></th>
					</tr>
				<?php 
					$cnt=$limitstart+1; 
					foreach($orderitems as $orderitem)
					{ 
				?>
				  <tr>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($orderitem->temple_name);if($orderitem->item_type=='product'){_e(' (Product)');} ?></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($orderitem->package_name); ?></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php if($orderitem->item_type=='temple'){echo date('jS F Y',strtotime($orderitem->package_date));} ?></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php if($orderitem->item_type=='product'){_e($orderitem->product_quantity);} ?></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo $currency_symbal.$orderitem->product_item_price; ?></td>
				  </tr>
				  <?php $cnt++; } ?>
				  <tr>
					<td valign="top" align="left" colspan="3" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><strong>Total Amount</strong></td>
					<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo $currency_symbal.number_format($order->order_total, 2, '.', ''); ?></td>
				  </tr>
				</table>
				<?php 
				} 
				else
				{
					echo "<strong>No Order Item!</strong>" ;
				}
				?>
				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" align="left">
							<table width="90%" align="left" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Order Id</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->order_id); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Order Date</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo date('jS F Y h:i A',strtotime($order->cdate)); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">User IP</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->ip_address); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">User Message</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->usermessage); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Payment Gateway</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->gateway_name); ?></th>
								</tr>
							</table>
						</td>
						<td valign="top" align="left">
							<table width="90%" align="left" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">First Name</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($fname); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Last Name</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($lname); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Email</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($email ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Phone number</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($phone ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Address</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($address.' '.$address2); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">City</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($city ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Stats</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($state ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Zipcode</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($zipcode ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Country</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($country ); ?></th>
								</tr>
								<tr>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">Gender</th>
									<th valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($gender ); ?></th>
								</tr>
								
							</table>
						</td>
					</tr>
				</table>
                <div class="e-mail">
                    <div class="adress">Status :  </div>
                    <div class="field">
					<select name="orderstatus">
						<option value="P"<?php if($orderstatus=='P'){_e(' selected="selected"');} ?>><?php echo orderstatus('P'); ?></option>
						<option value="C"<?php if($orderstatus=='C'){_e(' selected="selected"');} ?>><?php echo orderstatus('C'); ?></option>
						<option value="S"<?php if($orderstatus=='S'){_e(' selected="selected"');} ?>><?php echo orderstatus('S'); ?></option>
					</select>
					</div>
                </div>
                <div class="clr"></div>
                <div class="e-mail">
                    <div class="adress">&nbsp;&nbsp;</div>
                    <div class="field" style="margin-top:10px;">
                        <div class="green-submit-btn">
                        	<input type="submit" name="updateorder" value="Update" /> 
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