<?php @session_start();
require_once('../../../wp-config.php');
if(isset($_POST['package_id']) && isset($_POST['temple_id']))
{
	$temple_id=$_POST['temple_id'];
	$package_id=$_POST['package_id'];
	$templeprices=templeprices($temple_id, " and package_id='$package_id'");
	
	$price=$templeprices[0]->price;
	$_SESSION['shoopin_cart']['temple_id'][]=$temple_id;
	$_SESSION['shoopin_cart']['package_id'][]=$package_id;
	$_SESSION['shoopin_cart']['price'][]=$price;
	echo'<a href="'.get_option('home').'/shopping-cart" title="Shopping Cart">Shopping Cart:  '.count($_SESSION['shoopin_cart']['temple_id']).' item(s) - '.$currency_symbal.array_sum($_SESSION['shoopin_cart']['price']).'</a>';
}
else if(isset($_SESSION['shoopin_cart']))
{
	echo'<a href="'.get_option('home').'/shopping-cart" title="Shopping Cart">Shopping Cart:  '.count($_SESSION['shoopin_cart']['temple_id']).' item(s) - '.$currency_symbal.array_sum($_SESSION['shoopin_cart']['price']).'</a>';
}
else
{
	echo'Shopping Cart:  0 item(s) - '.$currency_symbal.'0.00';
}