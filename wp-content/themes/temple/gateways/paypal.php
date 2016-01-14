<?php @session_start();
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class


            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
//$this_script = 'http://freshbiz-game.com/dev/wp-content/plugins/manage-users/includes/paypal.php';

// if there is not action variable, set the default action of 'process'

if (empty($_GET['action'])) $_GET['action'] = 'process'; 
switch ($_GET['action']) 
{
   case 'process':      // Process and order...
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
		
		$paypalmode=get_option( 'paypalmode' );

		$gateway_name='Paypal';
		$businessid=get_option( 'paypalid' );
		
		$item_name='';
		$item_amount='';
		$item_quantity='';
		$item_shipping='';
		
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
			$sql="INSERT INTO `".$prefix."orders` (`user_id`,`order_total`,`order_subtotal`,`order_tax`,`order_shipping`,`coupon_discount`, `coupon_code`,`order_discount`, `order_currency`, `order_status`, `cdate`, `mdate`, `ip_address`, `gateway_name`, `usermessage`) VALUES ('$user_id', '$order_total', '$order_subtotal', '$order_tax', '$order_shipping', '$coupon_discount','$coupon_code', '$order_discount', '$currency', 'P', now(), now(), '$ip', '$gateway_name', '$usermessage')";
			
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
				
				$item_name.='&item_name_'.$cnt.'='.$order_item_name;
				$item_amount.='&amount_'.$cnt.'='.$product_item_price;
				$item_quantity.='&quantity_'.$cnt.'='.$product_quantity;
				
				$shipping=0;
		
				$item_shipping.='&shipping_'.$cnt.'='.($shipping);
				
				$cnt++;
			}
		}
		
		if($result==1)
		{
			if($paypalmode=='test')
			{
				$paypalurl='https://sandbox.paypal.com/cgi-bin/webscr';
			}
			else if($paypalmode=='live')
			{
				$paypalurl='https://www.paypal.com/cgi-bin/webscr';
			}
			$paypal=$paypalurl.'?cmd=_cart&custom='.$order_id.'&email='.$email.'&first_name='.$fname.'&last_name='.$lname.'&notify_url='.get_option('home').'/wp-content/themes/temple/gateways/paypal.php?action=ipn&cancel_return='.get_option('home').'&return='.get_option('home').'/thanks-you&upload=1&business='.$businessid.'&currency_code='.$currency.$item_name.$item_quantity.$item_amount.$item_shipping;
			
			unset($_SESSION['shoopin_cart']);
			
			 ?>
			 <div style="display:none;">
			<script language="javascript" type="text/javascript">
				window.location='<?php _e($paypal); ?>';
			</script>
			</div>
		<?php
			
		}
	
   
   break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
     	$p->validate_ipn();
	  	
		if(isset($p->ipn_data["txn_id"]) && isset($p->ipn_data["custom"]) && trim(strtolower($_REQUEST['payment_status']))=='completed')
		{
			$txn_id=$p->ipn_data['txn_id'];
			$order_id=$p->ipn_data['custom'];
		 	require_once('../../../../wp-config.php');
			global $wpdb;
			$prefix=$wpdb->base_prefix;
			if($order_id>0)
			{
				$sql="UPDATE `".$prefix."order_item` set order_status='C' where order_id='$order_id'";
				$result = $wpdb->query( $sql );
				
				$sql="UPDATE `".$prefix."orders` set txn_id='$txn_id', order_status='C' where order_id='$order_id'";
				$result = $wpdb->query( $sql );
				
				if($result==1)
				{
					$html='';
					$symbal=$currency_symbal;
					
					$html.='<style>
							td
							{
								padding: 2px 5px;
								text-align: left;
							}
							.invoice{
								text-align:center;
								border: 1px solid #000;
								padding: 2px 0px;
							}
							.clr
							{
								clear:both;
							}
							.useraddress
							{
								text-align:left;
								border: 1px solid #000;
								padding: 2px 0px;
							}
						
					</style>';
					
						
					$sql ="SELECT * FROM ".$prefix."orders where order_id='$order_id'";
					$payemnts = $wpdb->get_results($sql, OBJECT);
				
					$user_id=$payemnts[0]->user_id;
					
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
					$name=$fname.' '.$lname;
					
					$html='';
			
					$html.='<style>
					td
					{
						padding: 2px 5px;
						text-align: left;
					}
					.invoice{
						text-align:center;
						border: 1px solid #000;
						padding: 2px 0px;
					}
					.clr
					{
						clear:both;
					}
					h1{color:#752619;}
					table.bgtable{background-color:#f6f6f6;}
					table.bgtable h1{font-size:30px;}
					table td.title{color:#E09C2F;}
					table tr.gray td{background-color:#f6f6f6;}
					table.nexttable td{border: 1px solid #ffffff;}
					table.nexttable{margine-left:10px;}
					</style>';
					$html.='
					<table class="bgtable" width="800" border="0" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" colspan="2"><h1><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice</h1></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" colspan="2">&nbsp;</td>
					  </tr>
					  <tr>
						<td align="left" valign="top" width="500">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<table width="90%" border="0" cellpadding="0" cellspacing="0">
							  <tr>
								<td align="left" valign="top" width="100"><strong>Name</strong> </td>
								<td align="left" valign="top">'.trim($name).'</td>
							  </tr>';
							  if($address!='' || $address2!=''){$html.='<tr>
								<td align="left" valign="top" width="100"><strong>Address</strong> </td>
								<td align="left" valign="top">'.trim($address.' '.$address2).'</td>
							  </tr>';}
							  if($city!=''){$html.='<tr>
								<td align="left" valign="top" width="100"><strong>City</strong> </td>
								<td align="left" valign="top">'.trim($city).'</td>
							  </tr>';}
							  if($region!=''){$html.='<tr>
								<td align="left" valign="top" width="100"><strong>Region</strong> </td>
								<td align="left" valign="top">'.trim($region).'</td>
							  </tr>';}
							  if($zipcode!=''){$html.='<tr>
								<td align="left" valign="top" width="100"><strong>Zipcode</strong> </td>
								<td align="left" valign="top">'.trim($zipcode).'</td>
							  </tr>';}
							  if($country!=''){$html.='<tr>
								<td align="left" valign="top" width="100"><strong>Country</strong> </td>
								<td align="left" valign="top">'.trim($country).'</td>
							  </tr>';}
							 $html.='</table>
						</td>
						<td align="right" valign="bottom" width="500" height="150">
							<table width="90%" border="0" cellpadding="0" cellspacing="0">
							  <tr>
								<td align="left" valign="top" valign="bottom"><br /><br /><br />
								<strong>Invoice No. </strong>'.$order_id.'<br />
								<strong>Date </strong>'.date('jS F Y',strtotime($payemnts[0]->cdate)).'</td>
							  </tr>
							  </table>
						</td>
					  </tr>
					</table>';
					$sql ="SELECT * FROM ".$prefix."order_item where order_id='$order_id'";
					$orderitems = $wpdb->get_results($sql, OBJECT);
					if(count($orderitems)>0)
					{
						$html.='<div style="clear:both; margin-top:20px;"></div>';
						
						$html.='<table width="800" align="center" class="nexttable" border="0" cellpadding="4" cellspacing="0">
						  <tr>
							<th valign="top" align="left" width="400">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temple Name</th>
							<th valign="top" align="left" width="200">Pooja Date</th>
							<th valign="top" align="left" width="200">Cost '.$currency_symbal.'</th>
						  </tr>';
						  $cnt=1;
						  foreach($orderitems as $orderitem)
						  {
							if($cnt%2==0)
							{
								$html.='<tr>
								<td valign="top" align="left" width="400">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$orderitem->temple_name.'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$orderitem->package_name.'</td>
								<td valign="top" align="left" width="200">'.date('jS F Y',strtotime($orderitem->package_date)).'</td>
								<td valign="top" align="left" width="200">'.$currency_symbal.$orderitem->product_item_price.'</td>
							  </tr>';
							}
							else
							{
							  $html.='<tr class="gray">
								<td valign="top" align="left" width="400">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$orderitem->temple_name.'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$orderitem->package_name.'</td>
								<td valign="top" align="left" width="200">'.date('jS F Y',strtotime($orderitem->package_date)).'</td>
								<td valign="top" align="left" width="200">'.$currency_symbal.$orderitem->product_item_price.'</td>
							  </tr>';
							}
							$cnt++;
						}
						$html.='</table><div style="clear:both; margin-top:5px;"></div>';
						$html.='<table width="670" border="0" cellpadding="4" cellspacing="0">
						  <tr>
							<td valign="top" align="right">Total Amount &nbsp;&nbsp;&nbsp;'.$currency_symbal.number_format($payemnts[0]->order_total, 2, '.', '').'</td>
						  </tr>
						</table>';
					}
					if($html!='')
					{	
						
						require_once('../tcpdf/config/lang/eng.php');
						require_once('../tcpdf/tcpdf.php');
						
						define('PDF_HEADER_TITLE', 'Title');
						define('PDF_HEADER_STRING', 'String');
				
						class MYPDF extends TCPDF {
				
							//Page header
							public function Header() {
								// Logo
								$image_file = '../images/admin-logo.png';
								$this->Image($image_file, 0, 0, 100);
								
							}
						
							// Page footer
							public function Footer() {
								// Position at 15 mm from bottom
								$this->SetAutoPageBreak(TRUE, 0);
								$this->SetY(-29);
								
								//$image_file = '../images/email/invoice_logo.png';
								//$this->Image($image_file, 0, 0, 220);
								// Set font
								$this->SetFont('', 'B', 11);
								// Page number
								//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
								
								// Color and font restoration
								
								$this->SetFillColor(121, 44, 26);
								$this->SetTextColor(0);
								$this->SetFont('');
								$this->cell_height_ratio=0.6;
								$complex_cell_border = array(
								   'TB' => array('width' => 1, 'color' => array(227, 170, 37), 'dash' => 0, 'cap' => 'butt'),
								   'RL' => array('width' => 1, 'color' => array(227, 170, 37), 'dash' => 0, 'cap' => 'round'),
								);
								$fill = 1;
								$this->Cell(0, 1, '', 0, 0, 'C', $fill);
								$this->Ln();
								$this->cell_height_ratio=1.2;
								$this->SetFillColor(227, 170, 37);
								$this->SetTextColor(121, 44, 26);
								$html33='<br /><br />Puyangan Travels<br />13/8 Om Shakti Apts, LDN Chary St,<br />Ganpathy Puram, Charomepet,<br />Chennai 600 044, Tamilnadu,India<br />';
								$this->MultiCell(0, 0, $html33, $complex_cell_border, 'C', $fill, '3', 0, 269, true, 0, true);
								
							}
						}
						
						// create new PDF document
						$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);		
						// create new PDF document
						//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						
						
						// set document information
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->SetAuthor('Rinku kamboj');
						$pdf->SetTitle($invoicedetails[0]->title);
						$pdf->SetSubject('Order Invoice');
						$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
						
						// remove default header/footer
						/*$pdf->setPrintHeader(false);
						$pdf->setPrintFooter(false);*/
						
				
						// set header and footer fonts
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
						$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
						//set margins
						$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
						$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
						
						// set default monospaced font
						$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						
						//set margins
						$pdf->SetMargins(0, 28.5, 0);
						
						//set auto page breaks
						$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
						
						//set image scale factor
						$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
						
						//set some language-dependent strings
						$pdf->setLanguageArray($l);
						
						//--------------------------------------------------------
						
						// set font
						$pdf->SetFont('helvetica', '', 12);
						
						// add a page
						$pdf->AddPage();
						
						// output the HTML content
						$pdf->writeHTML($html, true, false, true, false, '');
						
						
						//--------------//--------------------------------------------------------
						$pdf->lastPage();
						//Close and output PDF document
						$pdf->Output('../../../../wp-content/uploads/orders/order_confirmation_'.$order_id.'.pdf', 'F');
					
					}
					
					$to      = $email;		
					$subject = get_option('blogname').' :: Thanks For Booking Temple.';	
					$from = get_option('admin_email');
					//header information
					
					$attachments = array(WP_CONTENT_DIR.'/uploads/orders/order_confirmation_'.$order_id.'.pdf');
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$fromname=get_option('blogname');
					$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
					
					$message="<b>Hello ".$fname." ".$lname.",</b><br /><br />";
					$message.='Thanks For booking from '.get_option('blogname').'<br />Attached is the payment confirmation of your booking.';
					$message.='<br /><br />Thanks<div style="clear:both;margin-top:10px;"></div>'.get_option('blogname');
					
					wp_mail($to, $subject, $message, $headers, $attachments);
					
					
					$to      = 	get_option('admin_email');	
					$subject = get_option('blogname').' :: Payment Confirmation.';	
					$from = $email;
					//header information
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$fromname=get_option('blogname');
					$headers .= "Content-type: text/html; charset=utf-8" . "\r\nFrom: $fromname <$from>\r\nReply-To: $from";
					
					$message="Dear Admin,<br /><br />".$name." has been booking from ".$fromname."<br />Attached is the payment confirmation of booking.";
					$message.='<br /><br />Thanks<div style="clear:both;margin-top:10px;"></div>'.get_option('blogname');
					
					wp_mail($to, $subject, $message, $headers, $attachments);
					
				}
			}
		}
	break;
	case 'success' :
	
	require_once('../../../../wp-config.php');
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	if(isset($_REQUEST["tx"]))
	{
		
		
		$order_id=$_REQUEST["cm"];
		//print_r($_REQUEST);
		if($order_id>0)
		{
			
			$name=$fname.' '.$lname;
			
				
		}
	}
			
	break;
 }		
      
?>