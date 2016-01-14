<?php
require_once('../../../../wp-config.php');
global $wpdb, $current_user;
get_currentuserinfo();
$prefix=$wpdb->base_prefix;

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt=get_option( 'payusalt' );

$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
$newhash = hash("sha512", $retHashSeq);

if($newhash!=$posted_hash)
{
	echo"<script>window.location='".get_option('home')."/payment-not-success'</script>";
	exit();
}
if(isset($_POST['mihpayid']) && isset($_POST['txnid']) && isset($_POST['status']) && trim($_POST['mihpayid'])!='' && trim($_POST['txnid'])!='' && trim($_POST['status'])=='success' && is_user_logged_in())
{
	$txn_id=$_POST['mihpayid'];
	$order_id=$_POST['txnid'];
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
						
						
						$this->SetFont('', 'B', 11);
						
						
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
			
			echo"<script>window.location='".get_option('home')."/thanks-you'</script>";
			exit();
		}
	} 
}  
?>	