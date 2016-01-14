<?php 
@session_start();

/*

Plugin Name: Orders

Plugin URI: http://www.vantagewebtech.com

Description: Temple Directory features such as Temples listings, Packages, Online Bookings, managed pages such as Astrology  etc.,

Author: Priyanka Chhabra

Version: 10.6.14

Author URI: http://www.vantagewebtech.com

*/
//*************** Admin function ***************
//this function is used for checking login details


if(!isset($_REQUEST['ho']) || ($_REQUEST['ho']=='Manage_temples1') )
{
	function Manage_Orders1() {
		include('listorders.php');
	}
}
if(isset($_REQUEST['ho']))
{
	$page=$_REQUEST['ho'];
	switch($page)
	{
		
		case 'editorder':
		function includesetting_files() {
			include('editorder.php');
		}
		break;
		case 'deleteorder':
		function includesetting_files() {
			include('deleteorder.php');
		}
		break;
	}
	function manageOrder_actions33() {
		add_menu_page("Orders", "Manage Orders", 1, "Orders", "includesetting_files");
	}
	add_action('admin_menu', 'manageOrder_actions33');
}
function orderstatus($status)
{
	if($status=='P'){ return 'Pending';}
	else if($status=='C'){ return 'Confirmed';}
	else if($status=='S'){ return 'Completed';}
}
/* Manage Menu */

function manageOrder_admin_actions() {
	
	add_menu_page("Orders", "Manage Orders", 1, "Orders", "Manage_Orders1");
	
}
if(!isset($_REQUEST['ho']) )
{
	add_action('admin_menu', 'manageOrder_admin_actions');
}

function orders($id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($id!='')
	{
		$cond.=" and order_id='$id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr = "SELECT * FROM ".$prefix."orders where order_id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function orderitems($cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	
	$querystr = "SELECT * FROM ".$prefix."order_item where order_item_id!='' $cnd";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}


function order_direc_install() {
   global $wpdb;
   //global $product_db_version;

$sql14 = "CREATE TABLE `".$wpdb->prefix."orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `order_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `order_subtotal` decimal(15,2) DEFAULT NULL,
  `order_tax` decimal(10,2) DEFAULT NULL,
  `order_shipping` decimal(10,2) DEFAULT NULL,
  `coupon_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `order_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_currency` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `order_status` char(1) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ip_address` varchar(20) NOT NULL DEFAULT '',
  `order_from` varchar(20) NOT NULL DEFAULT 'website',
  `gateway_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `usermessage` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `idx_orders_user_id` (`user_id`)
)";

$sql15 = "CREATE TABLE `".$wpdb->prefix."order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temple_id` int(11) DEFAULT NULL,
  `package_type_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `temple_name` varchar(400) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `package_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `package_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `coupon_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `item_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `package_date` date DEFAULT NULL,
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `product_id` int(11) DEFAULT '0',
  `product_quantity` int(11) DEFAULT '0',
  `product_item_price` decimal(15,2) DEFAULT NULL,
  `product_final_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_item_currency` varchar(16) DEFAULT NULL,
  `order_status` char(1) DEFAULT NULL,
  `item_type` varchar(20) NOT NULL DEFAULT 'temple',
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `idx_order_item_order_id` (`order_id`)
)";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   dbDelta($sql14);
   dbDelta($sql15);
}

register_activation_hook(__FILE__,'order_direc_install');
?>