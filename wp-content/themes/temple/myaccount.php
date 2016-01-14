<?php 
 /*
Template Name: My Account
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
if(isset($_POST['updateaccount']))
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
	$pwd=$_POST['pwd'];
	$pwd2=$_POST['pwd2'];
	if(trim($pwd2)=='' && isset($_POST['pwd']) && trim($pwd)!='')
	{
		array_push($errors,'Please enter your confirm password.');
	}
	
	if(trim($pwd)!=trim($pwd2) && trim($pwd)!='')
	{
		array_push($errors,'Password is not same as confirm password.');
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
		$differentshipping='no';
	}
	$country=$_POST['country'];
	$gender=$_POST['gender'];
	if(count($errors)<=0)
	{
		if(trim($pwd)!='')
		{
			wp_set_password($pwd,$user_id);
			wp_clear_auth_cookie();
			wp_set_auth_cookie($user_id);
			
			$url = 'http://www.puyangan.com/updateuser.php';
			$fields = array(
							'email' => $email,
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
		}
		
			
			
		//echo $user_id;
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
		
		$_SESSION['message']='Your account updated successfully.';
		echo"<script>window.location='".get_permalink()."'</script>";
		exit();	
	}
}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var p = jQuery('div.mid_content');
	var offset = p.offset();
	jQuery('html, body').animate({scrollTop : offset.top},1000);
	
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
	jQuery("#registrations").validate({
	  rules: {
		pwd: {
		  minlength: 4
		},
		pwd2: {
		  minlength: 4,
		  equalTo:'#pwd'
		}
	},
	  messages: {
			pwd: {
				minlength: "Password must contain a minimum of 4 characters"
			},
			pwd2: {
				minlength: "Password must contain a minimum of 4 characters.",
				equalTo: "Confirm password does not match the password."
			}
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
	?>
			
		<form name="registrations" id="registrations" action="" method="post">
			<div class="formtitle">Senders Information</div>
				<div class="clr"></div>
				<div class="newregisterform">
				<div class="field">
					<label for="email">Email Address*</label><span><?php _e($email); ?></span>
				</div>
				<div class="field">
					<label for="fname">First Name*</label>
					<input type="text" name="fname" id="fname" class="required" value="<?php _e($fname); ?>" />
				</div>
				<div class="field">
					<label for="lname">Last Name*</label>
					<input type="text" name="lname" id="lname" class="required" value="<?php _e($lname); ?>" />
				</div>
				<div class="field">
					<label for="pwd">New Password</label>
					<input type="password" name="pwd" id="pwd" value="" />
				</div>
				<div class="field">
					<label for="pwd2">Confirm Password</label>
					<input type="password" name="pwd2" id="pwd2" value="" />
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
				<div class="checkoutbtn">
					<input type="submit" name="updateaccount" value="Update Account" />
				</div>
			</div>
		</form>
		
  </div>
  <?php get_sidebar('right'); ?>
  <div class="clr"></div>
</div>
<?php 
get_footer(); 