<?php
require_once('../../../../wp-config.php');
global $wpdb, $current_user;
get_currentuserinfo();
$prefix=$wpdb->base_prefix;
$zone1=get_option('timezone_string');
date_default_timezone_set($zone1);
$title='Temple Booking';
$price=array_sum($_SESSION['shoopin_cart']['price']);

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
$gateway_name='Payumoney';
$item_name='';

if(isset($_SESSION['shoopin_cart']))
{
	$order_total=$price;
	$order_subtotal=$price;
	$order_shipping=0;
	$order_tax=0;
	$coupon_discount=0;
	$coupon_code='';
	$order_discount=0;
	$usermessage=$_SESSION['shoopin_cart']['usermessage'];
	$ip=getRealIpAddr();
	$sql="INSERT INTO `".$prefix."orders` (`user_id`,`order_total`,`order_subtotal`,`order_tax`,`order_shipping`,`coupon_discount`, `coupon_code`,`order_discount`, `order_currency`, `order_status`, `cdate`, `mdate`, `ip_address`, `gateway_name`, `usermessage`) VALUES ('$user_id', '$order_total', '$order_subtotal', '$order_tax', '$order_shipping', '$coupon_discount','$coupon_code', '$order_discount', '$currency', 'P', now(), now(), '$ip', '$gateway_name','$usermessage')";
	
	$result = $wpdb->query( $sql );
	$order_id=$wpdb->insert_id;
	
	$cnt=1;
	for($i=0;$i<count($_SESSION['shoopin_cart']['temple_id']);$i++)
	{
		$temple = templedetail($_SESSION['shoopin_cart']['temple_id'][$i]);
		$package=packagedetail($_SESSION['shoopin_cart']['package_id'][$i]);
		$package_date=$_SESSION['shoopin_cart']['poojadate'][$i];
		$product_item_price=$_SESSION['shoopin_cart']['price'][$i];
		$temple_id=$_SESSION['shoopin_cart']['temple_id'][$i];
		$product_quantity=1;
		$product_final_price=($_SESSION['shoopin_cart']['price'][$i]*$product_quantity);
		$order_item_name=$temple[0]->name.' ('.$package[0]->title.')';
		$package_name=$package[0]->title;
		$temple_name=$temple[0]->name;
		$package_type_id=$package[0]->package_type_id;
		$package_id=$package[0]->id;
		$packagetypes=packagetypedetail($package_type_id);
		$package_type_name=$packagetypes[0]->package_type;
		$commission2=$product_quantity*$patr->marketer_commission;
		$commission3=$product_quantity*$patr->bc_commission;
		$totalbccommission=$totalbccommission+$commission3;
		
		$sql="INSERT INTO `".$prefix."order_item` (`order_id`,`user_id`,`temple_id`, `package_type_id`, `package_id`,`temple_name`,`package_name`, `package_type_name`,`product_quantity`, `product_item_price`,`product_final_price`, `order_item_currency`, `order_status`, `cdate`, `mdate`, `package_date`) VALUES ('$order_id', '$user_id', '$temple_id', '$package_type_id', '$package_id', '$temple_name', '$package_name', '$package_type_name','$product_quantity', '$product_item_price', '$product_final_price', '$currency', 'P', now(), now(),'$package_date')";
		$result = $wpdb->query( $sql );
		
		$item_name.=' Temple - '.$temple[0]->name.' Package - '.$package[0]->title;
		
		$cnt++;
	}
	unset($_SESSION['shoopin_cart']);
}

$payumode=get_option( 'payumode' );
$curconversion=get_option( 'curconversion' );
// Merchant key here as provided by Payu
$MERCHANT_KEY = get_option( 'payumerchantkey' );
// Merchant Salt as provided by Payu
$SALT = get_option( 'payusalt' );
// End point - change to https://secure.payu.in for LIVE mode
if($payumode=='test')
{
	$PAYU_BASE_URL = "https://test.payu.in";
}
else if($payumode=='live')
{
	$PAYU_BASE_URL = "https://secure.payu.in";
}
$action = '';

$txnid = $order_id;
$postingvalues=array(
	'key'=>$MERCHANT_KEY,
	'hash'=>$hash,
	'txnid'=>$order_id,
	'amount'=>($price*$curconversion),
	'firstname'=>$fname,
	'email'=>$email,
	'phone'=>$phone,
	'productinfo'=>$item_name,
	'surl'=>get_option('home').'/wp-content/themes/temple/gateways/payumoneysuccess.php',
	'furl'=>get_option('home').'/wp-content/themes/temple/gateways/payumoneyfailure.php',
	'curl'=>get_option('home'),
	'service_provider'=>'payu_paisa',
	'lastname'=>$lname,
	'address1'=>$address,
	'address2'=>$address2,
	'city'=>$city,
	'state'=>$state,
	'country'=>$country,
	'zipcode'=>$zipcode
);

$posted = array();
if(!empty($postingvalues)) {
    //print_r($_POST);
  foreach($postingvalues as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;
if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = $order_id;
} else {
  $txnid = $posted['txnid'];
}

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
	
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;

    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
	$postingvalues['hash']=$hash;
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
	  
	  <?php 
			
		foreach($postingvalues as $key=>$value){ ?>
		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value ?>" />
		<?php } ?>
    </form>
	<script type="text/javascript">
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
	submitPayuForm();
  </script>
 
