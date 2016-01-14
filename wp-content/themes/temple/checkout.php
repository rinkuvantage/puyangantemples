<?php //@ob_start();
 /*
Template Name: Checkout
*/
@ob_start();
@session_start();
/*if(isset($_SESSION['shoopin_cart']['user_id']) && trim($_SESSION['shoopin_cart']['user_id'])>0)
{
	
	wp_clear_auth_cookie();
	wp_set_auth_cookie($_SESSION['shoopin_cart']['user_id']);
	unset($_SESSION['shoopin_cart']['user_id']);
	wp_redirect(get_permalink().'/?step=payment'); 
	exit;
}*/
global $wpdb, $current_user;
get_currentuserinfo();
$prefix=$wpdb->base_prefix;
get_header();
$paymentpage=false;
$errors=array();

if(isset($_REQUEST['step']) && trim($_REQUEST['step'])=='payment')
{
	$paymentpage=true;
}
if($paymentpage && !is_user_logged_in())
{
	$_SESSION['message']='Please proceed for checkout process first.';
	echo"<script>window.location='".get_permalink()."'</script>";
	exit();
}
if(is_user_logged_in())
{
	$user_id=$current_user->ID;
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
}

if(trim($gender)==''){$gender='Male';}
if(trim($differentshipping)==''){$differentshipping='no';}
if(isset($_POST['updateproceed']))
{
	$fname=$_POST['fname'];
	if(trim($fname)=='')
	{
		array_push($errors,'Please enter your first name.');
	}
	$lname=$_POST['lname'];
	if(trim($lname)=='')
	{
		array_push($errors,'Please enter your last name.');
	}
	if(!is_user_logged_in())
	{
		$email=$_POST['email'];
		$checkwpemail=checkWPFieldexist('user_email',$email);
		$checkwpusername=checkWPFieldexist('user_login',$email);
		if(trim($email)=='')
		{
			array_push($errors,'Please enter your e-mail address.');
		}
		else if( count($checkwpemail)>0 || count($checkwpusername)>0) 
		{
			array_push($errors,'E-mail address exist please try another.');
		}
	}
	$address=$_POST['address'];
	if(trim($address)=='')
	{
		array_push($errors,'Please enter your address.');
	}
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	if(trim($city)=='')
	{
		array_push($errors,'Please enter your city name.');
	}
	$zipcode=$_POST['zipcode'];
	if(trim($zipcode)=='')
	{
		array_push($errors,'Please enter your zipcode.');
	}
	$state=$_POST['state'];
	if(trim($state)=='')
	{
		array_push($errors,'Please enter your state.');
	}
	$phone=$_POST['phone'];
	if(trim($phone)=='')
	{
		array_push($errors,'Please enter your phone number.');
	}
	if(isset($_POST['differentshipping']))
	{
		$differentshipping='yes';
		$ship_fname=$_POST['ship_fname'];
		if(trim($ship_fname)=='')
		{
			array_push($errors,'Please enter your shipping first name.');
		}
		$ship_lname=$_POST['ship_lname'];
		if(trim($ship_lname)=='')
		{
			array_push($errors,'Please enter your shipping last name.');
		}
		$ship_address=$_POST['ship_address'];
		if(trim($ship_address)=='')
		{
			array_push($errors,'Please enter your shipping address.');
		}
		$ship_address2=$_POST['ship_address2'];
		$ship_city=$_POST['ship_city'];
		if(trim($ship_city)=='')
		{
			array_push($errors,'Please enter your shipping city name.');
		}
		$ship_zipcode=$_POST['ship_zipcode'];
		if(trim($ship_zipcode)=='')
		{
			array_push($errors,'Please enter your shipping zipcode.');
		}
		$ship_state=$_POST['ship_state'];
		if(trim($ship_state)=='')
		{
			array_push($errors,'Please enter your shipping state.');
		}
		$ship_phone=$_POST['ship_phone'];
		if(trim($ship_phone)=='')
		{
			array_push($errors,'Please enter your shipping phone number.');
		}
		$ship_country=$_POST['ship_country'];
	}
	else
	{
		$ship_fname=$_POST['fname'];
		$ship_lname=$_POST['lname'];
		$ship_address=$_POST['address'];
		$ship_address2=$_POST['address2'];
		$ship_city=$_POST['city'];
		$ship_zipcode=$_POST['zipcode'];
		$ship_state=$_POST['state'];
		$ship_phone=$_POST['phone'];
		$ship_country=$_POST['country'];
	}
	$country=$_POST['country'];
	$gender=$_POST['gender'];
	$_SESSION['shoopin_cart']['usermessage']=$_POST['usermessage'];
	if(count($errors)<=0)
	{
		if(is_user_logged_in())
		{
			$new=get_user_meta( $user_id, 'first_name');
			if(empty($new)){add_user_meta( $user_id, 'first_name', $fname );}
			else{update_user_meta( $user_id, 'first_name', $fname );}
			
			$new=get_user_meta( $user_id, 'last_name');
			if(empty($new)){add_user_meta( $user_id, 'last_name', $lname );}
			else{update_user_meta( $user_id, 'last_name', $lname );}
			
			$new=get_user_meta( $user_id, 'address');
			if(empty($new)){add_user_meta( $user_id, 'address', $address );}
			else{update_user_meta( $user_id, 'address', $address );}
			$new=get_user_meta( $user_id, 'address2');
			if(empty($new)){add_user_meta( $user_id, 'address2', $address2 );}
			else{update_user_meta( $user_id, 'address2', $address2 );}
			$new=get_user_meta( $user_id, 'city');
			if(empty($new)){add_user_meta( $user_id, 'city', $city );}
			else{update_user_meta( $user_id, 'city', $city );}
			
			$new=get_user_meta( $user_id, 'zipcode');
			if(empty($new)){add_user_meta( $user_id, 'zipcode', $zipcode );}
			else{update_user_meta( $user_id, 'zipcode', $zipcode );}
			$new=get_user_meta( $user_id, 'state');
			if(empty($new)){add_user_meta( $user_id, 'state', $state );}
			else{update_user_meta( $user_id, 'state', $state );}
			
			$new=get_user_meta( $user_id, 'phone');
			if(empty($new)){add_user_meta( $user_id, 'phone', $phone );}
			else{update_user_meta( $user_id, 'phone', $phone );}
			
			$new=get_user_meta( $user_id, 'country');
			if(empty($new)){add_user_meta( $user_id, 'country', $country );}
			else{update_user_meta( $user_id, 'country', $country );}
			
			$new=get_user_meta( $user_id, 'gender');
			if(empty($new)){add_user_meta( $user_id, 'gender', $gender );}
			else{update_user_meta( $user_id, 'gender', $gender );}
			
			$new=get_user_meta( $user_id, 'ship_fname');
			if(empty($new)){add_user_meta( $user_id, 'ship_fname', $ship_fname );}
			else{update_user_meta( $user_id, 'ship_fname', $ship_fname );}
			
			$new=get_user_meta( $user_id, 'ship_lname');
			if(empty($new)){add_user_meta( $user_id, 'ship_lname', $ship_lname );}
			else{update_user_meta( $user_id, 'ship_lname', $ship_lname );}
			$new=get_user_meta( $user_id, 'ship_address');
			if(empty($new)){add_user_meta( $user_id, 'ship_address', $ship_address );}
			else{update_user_meta( $user_id, 'ship_address', $ship_address );}
			
			$new=get_user_meta( $user_id, 'ship_address2');
			if(empty($new)){add_user_meta( $user_id, 'ship_address2', $ship_address2 );}
			else{update_user_meta( $user_id, 'ship_address2', $ship_address2 );}
			
			$new=get_user_meta( $user_id, 'ship_city');
			if(empty($new)){add_user_meta( $user_id, 'ship_city', $ship_city );}
			else{update_user_meta( $user_id, 'ship_city', $ship_city );}
			
			$new=get_user_meta( $user_id, 'ship_zipcode');
			if(empty($new)){add_user_meta( $user_id, 'ship_zipcode', $ship_zipcode );}
			else{update_user_meta( $user_id, 'ship_zipcode', $ship_zipcode );}
			
			$new=get_user_meta( $user_id, 'ship_state');
			if(empty($new)){add_user_meta( $user_id, 'ship_state', $ship_state );}
			else{update_user_meta( $user_id, 'ship_state', $ship_state );}
			
			$new=get_user_meta( $user_id, 'ship_phone');
			if(empty($new)){add_user_meta( $user_id, 'ship_phone', $ship_phone );}
			else{update_user_meta( $user_id, 'ship_phone', $ship_phone );}
			$new=get_user_meta( $user_id, 'ship_country');
			if(empty($new)){add_user_meta( $user_id, 'ship_country', $ship_country );}
			else{update_user_meta( $user_id, 'ship_country', $ship_country );}
			
			$new=get_user_meta( $user_id, 'differentshipping');
			if(empty($new)){add_user_meta( $user_id, 'differentshipping', $differentshipping );}
			else{update_user_meta( $user_id, 'differentshipping', $differentshipping );}
			
		}
		else
		{
			$pwd=generatePassword(6,8);
			$pass=md5($pwd);
			$sql="INSERT INTO `".$prefix."users` (`user_login`, `user_pass`,`user_email`,`user_nicename`, `user_registered`, `display_name`) VALUES ('$email', '$pass', '$email', '$fname', now(),'$fname')";
			$result = $wpdb->query( $sql );
			if($result==1)
			{
	
				
				$usrname=$email;
				$url = 'http://www.puyangan.com/register.php';
				$fields = array(
								'usrname' => $usrname,
								'email' => $email,
								'fname' => $fname,
								'pwd' => $pwd
								);
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string, '&');
				//open connection
				$ch = curl_init();
				//set the url, number of POST vars, POST data
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				//execute post
				$result=curl_exec($ch);
				curl_close($ch);
				$wpuser_id=$wpdb->insert_id;
				wp_set_password($pwd,$wpuser_id);
				add_user_meta( $wpuser_id, 'first_name', $fname );
				add_user_meta( $wpuser_id, 'last_name', $lname );
				add_user_meta( $wpuser_id, 'address', $address );
				add_user_meta( $wpuser_id, 'address2', $address2 );
				add_user_meta( $wpuser_id, 'city', $city );
				add_user_meta( $wpuser_id, 'zipcode', $zipcode );
				add_user_meta( $wpuser_id, 'state', $state );
				add_user_meta( $wpuser_id, 'phone', $phone );
				add_user_meta( $wpuser_id, 'country', $country );
				add_user_meta( $wpuser_id, 'gender', $gender );
				add_user_meta( $wpuser_id, 'ship_fname', $ship_fname );
				add_user_meta( $wpuser_id, 'ship_lname', $ship_lname );
				add_user_meta( $wpuser_id, 'ship_address', $ship_address );
				add_user_meta( $wpuser_id, 'ship_address2', $ship_address2 );
				add_user_meta( $wpuser_id, 'ship_city', $ship_city );
				add_user_meta( $wpuser_id, 'ship_zipcode', $ship_zipcode );
				add_user_meta( $wpuser_id, 'ship_state', $ship_state );
				add_user_meta( $wpuser_id, 'ship_phone', $ship_phone );
				add_user_meta( $wpuser_id, 'ship_country', $ship_country );
				add_user_meta( $wpuser_id, 'differentshipping', $differentshipping );
				add_user_meta( $wpuser_id, 'rich_editing', 'true' );
				add_user_meta( $wpuser_id, 'comment_shortcuts', 'false' );
				add_user_meta( $wpuser_id, 'admin_color', 'fresh' );
				add_user_meta( $wpuser_id, 'show_admin_bar_front', 'true' );
				add_user_meta( $wpuser_id, 'use_ssl', '0' );
				add_user_meta( $wpuser_id, 'aim', '' );
				add_user_meta( $wpuser_id, 'yim', '' );
				add_user_meta( $wpuser_id, 'jabber', '' );
				add_user_meta( $wpuser_id, 'show_welcome_panel', '2' );
	
				$capkey=$prefix.'capabilities';
				$capvalue=serialize(array('subscriber'=>1));
				$sql="INSERT INTO `".$prefix."usermeta` (`user_id`, `meta_key`,`meta_value`) VALUES ('$wpuser_id', '$capkey', '$capvalue')";
				$result = $wpdb->query( $sql );
				add_user_meta( $wpuser_id, $prefix.'user_level', 0 );
				
				$to      = 	$email;
				$subject = get_option('blogname').' : Registration Confirmation';	
				$from = get_option('admin_email');
				$fromname=get_option('blogname');
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
				
				$message="Dear ".$fname." ".$lname;
				$message.=",<br /><br />Thank you for registering with ".$fromname.".<br />You can view or change your information by logging in to your account with the following login details:<br /><br />";
				$message.='Email: '.$email;
				$message.='<br />Password: '.$pwd;
				
				$message.='<br /><br />Thank You';
				@mail($to, $subject, $message, $headers);
				
				$to      = 	get_option('admin_email');
				$subject = get_option('blogname').' : Registration Confirmation';	
				$from = $email;
				$fromname=get_option('blogname');
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
				
				$message="Dear Admin";
				$message.=",<br /><br />New user is registered on ".$fromname.".<br />Some detail is given below:<br /><br />";
				$message.='Email: '.$email;
				$message.='<br />First Name: '.$fname;
				$message.='<br />Last Name: '.$lname;
				
				$message.='<br /><br />Thank You';
				@mail($to, $subject, $message, $headers);
				
				//$_SESSION['shoopin_cart']['user_id']=$wpuser_id;
				wp_clear_auth_cookie();
				wp_set_auth_cookie($wpuser_id);
				/*unset($_SESSION['shoopin_cart']['user_id']);
				wp_redirect(get_permalink().'/?step=payment'); 
				exit;*/
				
			}
		}
		$_SESSION['message']='Please proceed for payment.';
		echo"<script>window.location='".get_permalink()."/?step=payment'</script>";
		exit();	
	}
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
	jQuery('#loginform').validate();
	jQuery('#loginform input#user_pass, #loginform input#user_login').addClass('required');
	jQuery("#shoppingcart").validate();
	jQuery(".poojadate").datepicker({ 
		minDate: +1,
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		yearRange: "<?php echo date('Y'); ?>:<?php echo date('Y')+10; ?>",
		showButtonPanel: true
	}).val();
	<?php if($differentshipping=='yes'){ ?>
	jQuery('.shippingform input[type="text"]').attr('disabled',false);
	jQuery('.shippingform select').attr('disabled',false);
	<?php }else{ ?>
	jQuery('.shippingform input[type="text"]').attr('disabled',true);
	jQuery('.shippingform select').attr('disabled',true);
	<?php } ?>
	jQuery('#differentshipping').change( function(){
		if(jQuery(this).prop('checked'))
		{
			jQuery('.shippingform input[type="text"]').attr('disabled',false);
			jQuery('.shippingform select').attr('disabled',false);
		}
		else
		{
			jQuery('.shippingform input[type="text"]').attr('disabled',true);
			jQuery('.shippingform select').attr('disabled',true);
		}
	});
});
</script>
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content checkout" id="cart">
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
	if(isset($_SESSION['shoopin_cart']))
	{ 
		if($paymentpage)
		{
			?>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#shoppingcart").live('submit', function() {
					  if (jQuery("input[name='gateway']:checked").val() == 'paypal') {
						jQuery('#loadingajax').css('display','block');
						jQuery.ajax({
								url: '<?php echo bloginfo('template_url') ?>/gateways/paypal.php?pg=paypal',
								success: function(data) {
								jQuery('#loadingajax').html(data);
								}
							});
					  }
					  else if (jQuery("input[name='gateway']:checked").val() == 'payumoney') {
						jQuery('#loadingajax').css('display','block');
						jQuery.ajax({
								url: '<?php echo bloginfo('template_url') ?>/gateways/payumoney.php',
								success: function(data) {
								jQuery('#loadingajax').html(data);
								}
							});
					  }
					  else
					  {
						 jQuery('.errors').html('<span class="error">Please select alteast one payment gateway.</span>');
					  }
					  return false;
				});
			});
			</script>
			
			<form name="shoppingcart" id="shoppingcart" action="" method="post">
				<table cellpadding="3" cellspacing="3" border="0" class="shoppingcarttable">
					<tr>
						<th valign="top" align="left">#</th>
						<th valign="top" align="left">Temple Name</th>
						<th valign="top" align="left">Pooja Date</th>
						<th valign="top" align="right">Cost <?php _e($currency_symbal); ?></th>
					</tr>
					<?php for($i=0;$i<count($_SESSION['shoopin_cart']['temple_id']);$i++){ $j=$i+1;
					$temple = templedetail($_SESSION['shoopin_cart']['temple_id'][$i]);
					
					$poojadate=$_SESSION['shoopin_cart']['poojadate'][$i];
					
					$package=packagedetail($_SESSION['shoopin_cart']['package_id'][$i]);
					?>
					<tr>
						<td valign="top" align="left"><?php echo $j; ?></td>
						<td valign="top" align="left"><?php _e($temple[0]->name); ?><br /><span class="pckg"><?php _e($package[0]->title); ?></span></td>
						<td valign="top" align="left"><?php echo $poojadate; ?></td>
						<td valign="top" align="right"><?php _e($currency_symbal.$_SESSION['shoopin_cart']['price'][$i]); ?></td>
					</tr>
					<?php } ?>
					<tr class="totalprice">
						<td valign="top" align="right" colspan="4">
							Total Amount : 	<?php _e($currency_symbal.array_sum($_SESSION['shoopin_cart']['price'])); ?>
						</td>
					</tr>
				</table>
				<div class="paymentgateways">
					<div class="field">
						<input type="radio" id="paypal" name="gateway" value="paypal"<?php if($gateway=='paypal'){_e(' checked="checked"');} ?> />
						<label for="paypal">Paypal</label>
					</div>
					<div class="field">
						<input type="radio" id="payumoney" name="gateway" value="payumoney"<?php if($gateway=='payumoney'){_e(' checked="checked"');} ?> />
						<label for="payumoney">Payumoney</label>
					</div>
					
					<div class="clr"></div>
					<div class="errors"></div>
					<div class="clr"></div>
					<div class="checkoutbtn">
						<input type="submit" name="payments" id="payments" value="Proceed For Payments" />
					</div>
					<div id="loadingajax"></div>
				</div>
				
				</form>
			<?php
		}
		else
		{
			
			if(!is_user_logged_in())
			{
				echo do_shortcode('[Login]');
				echo'<div class="clr"></div><h4>New User</h4>';
			}
			
			?>
			
			<form name="shoppingcart" id="shoppingcart" action="" method="post">
				<div class="formtitle">Senders Information</div>
					<div class="clr"></div>
					<div class="newregisterform">
					<?php if(!is_user_logged_in()){ ?>
					<div class="field">
						<label for="email">Email Address*</label>
						<input type="text" name="email" id="email" class="required email" value="<?php _e($email); ?>" />
					</div>
					<?php } ?>
					<div class="field">
						<label for="fname">First Name*</label>
						<input type="text" name="fname" id="fname" class="required" value="<?php _e($fname); ?>" />
					</div>
					<div class="field">
						<label for="lname">Last Name*</label>
						<input type="text" name="lname" id="lname" class="required" value="<?php _e($lname); ?>" />
					</div>
					<div class="field">
						<label for="address">Address*</label>
						<input type="text" name="address" id="address" class="required" value="<?php _e($address); ?>" />
						<div class="clr"></div>
						<input type="text" name="address2" id="address2" value="<?php _e($address2); ?>" />
					</div>
					<div class="field">
						<label for="city">City*</label>
						<input type="text" name="city" id="city" class="required" value="<?php _e($city); ?>" />
					</div>
					<div class="field">
						<label for="zipcode">Zip Code*</label>
						<input type="text" name="zipcode" id="zipcode" class="required" value="<?php _e($zipcode); ?>" />
					</div>
					<div class="field">
						<label for="state">State*</label>
						<input type="text" name="state" id="state" class="required" value="<?php _e($state); ?>" />
					</div>
					<div class="field">
						<label for="country">Country*</label>
						<select name="country" id="country">
							<?php if(count($countries)>0){foreach($countries as $ctry){ ?>
							<option value="<?php _e($ctry); ?>"<?php if($country==$ctry){_e(' selected="selected"');}?>><?php _e($ctry); ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="field">
						<label for="phone">Phone*</label>
						<input type="text" name="phone" id="phone" class="required" value="<?php _e($phone); ?>" />
					</div>
					<div class="field">
						<label for="gender">Gender*</label>
						Male <input type="radio" name="gender" value="Male"<?php if($gender=='Male'){_e(' checked="checked"');} ?> />
						Female <input type="radio" name="gender" value="Female"<?php if($gender=='Female'){_e(' checked="checked"');} ?> />
					</div>
				</div>
				<div class="clr"></div>
				<div class="formtitle">Recipient Information</div>
					<div class="clr"></div>
					<div class="newregisterform shippingform">
					<div class="field">
						<input type="checkbox" id="differentshipping" name="differentshipping"<?php if($differentshipping=='yes'){_e(' checked="checked"');} ?> value="yes" />
						<label for="differentshipping">Check this box for different shipping address</label>
						
					</div>
					<div class="field">
						<label for="ship_fname">First Name*</label>
						<input type="text" name="ship_fname" id="ship_fname" class="required" value="<?php _e($ship_fname); ?>" />
					</div>
					<div class="field">
						<label for="ship_lname">Last Name*</label>
						<input type="text" name="ship_lname" id="ship_lname" class="required" value="<?php _e($ship_lname); ?>" />
					</div>
					<div class="field">
						<label for="ship_address">Address*</label>
						<input type="text" name="ship_address" id="ship_address" class="required" value="<?php _e($ship_address); ?>" />
						<div class="clr"></div>
						<input type="text" name="ship_address2" id="ship_address2" value="<?php _e($ship_address2); ?>" />
					</div>
					<div class="field">
						<label for="ship_city">City*</label>
						<input type="text" name="ship_city" id="ship_city" class="required" value="<?php _e($ship_city); ?>" />
					</div>
					<div class="field">
						<label for="ship_zipcode">Zip Code*</label>
						<input type="text" name="ship_zipcode" id="ship_zipcode" class="required" value="<?php _e($ship_zipcode); ?>" />
					</div>
					<div class="field">
						<label for="ship_state">State*</label>
						<input type="text" name="ship_state" id="ship_state" class="required" value="<?php _e($ship_state); ?>" />
					</div>
					<div class="field">
						<label for="ship_country">Country*</label>
						<select name="ship_country" id="ship_country">
							<?php if(count($countries)>0){foreach($countries as $ctry){ ?>
							<option value="<?php _e($ctry); ?>"<?php if($ship_country==$ctry){_e(' selected="selected"');}?>><?php _e($ctry); ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="field">
						<label for="ship_phone">Phone*</label>
						<input type="text" name="ship_phone" id="ship_phone" class="required" value="<?php _e($ship_phone); ?>" />
					</div>
					<div class="checkoutcomment">
					<div class="field">
						<label for="usermessage">Message</label>
						<textarea name="usermessage" rows="3" cols="80" id="usermessage"><?php _e($usermessage); ?></textarea>
					</div>
					</div>
					<div class="checkoutbtn">
						<input type="reset" name="clearform" value="Clear" />
						<input type="submit" name="updateproceed" value="Save &amp; Proceed" />
					</div>
				</div>
			</form>
		<?php } ?>
<?php }else{ ?>
	<p>Cart is empty!</p>
	<?php } ?>
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 