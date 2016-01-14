<?php session_start(); 
$url=get_option('home').'/wp-admin/admin.php?page=SystemSettings'; ?>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/system-settings/js/validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#register_spcialist").validate();
});

</script>

<style type="text/css">
.error{
	color:#FF0000;
}
label.error
{
	margin-left:10px;
}
input.error, select.error,textarea.error
{
	color:#000;
	border:1px solid red;
}
.personal_info{float:left; width:160px; font-weight:bold; min-height:50px;}
input, select, textarea{float:left;}
.clr{clear:both; margin-top:10px;}
.fl{float:left;}
.del,.delspeciality{font-size:16px; border:1px solid #000000; color:#FF0000; float:left; border-radius:8px; margin-left:10px; padding:0px 2px;}

ul.config
{
	padding:10px 0px;
	margin:0px;
}
ul.config li
{
	display:inline;
	float:left;
	padding:0px 10px;
}
ul.config li a
{
	text-decoration:none;
	color:#000066;
}
ul.config li a:hover, ul.config li a.active
{
	text-decoration:underline;
	color:#990000;
}
.field{float:left;}
.field img{width:100px;}
.field textarea{width:400px; height:30px; border:1px solid #000; margin-right:10px;}
.specialty .field input[type="text"]{width:300px; height:30px; border:1px solid #000;}
.field input[type="text"]{width:120px; height:30px; border:1px solid #000;}

</style>
<h3>System Settings</h3>
<?php if(isset($_SESSION['mssg']) && trim($_SESSION['mssg'])!=''){ ?>
	<div class="updated"><p><strong><?php _e($_SESSION['mssg']); ?></strong></p></div>
<?php $_SESSION['mssg']='';}

$page='doctorprice';
if(isset($_REQUEST['p']) && trim($_REQUEST['p'])!='')
{
	$page=trim($_REQUEST['p']);
} ?>
<ul class="config">
	<li><a href="<?php echo $url; ?>"<?php if($page=='doctorprice'){ ?> class="active"<?php } ?>>Doctor Prices</a>
    <li><a href="<?php echo $url; ?>&p=currency"<?php if($page=='currency'){ ?> class="active"<?php } ?> title="currency">Currency</a>
    <li><a href="<?php echo $url; ?>&p=paymentgateway"<?php if($page=='paymentgateway'){ ?> class="active"<?php } ?> title="Payment Gateway">Payment Gateway</a>
    <li><a href="<?php echo $url; ?>&p=specialtype"<?php if($page=='specialtype'){ ?> class="active"<?php } ?> title="Speciality Types">Speciality Types</a></li>
    <li><a href="<?php echo $url; ?>&p=degrees"<?php if($page=='degrees'){ ?> class="active"<?php } ?> title="Doctors Degree">Doctors Degree</a></li>
    <li><a href="<?php echo $url; ?>&p=settime"<?php if($page=='settime'){ ?> class="active"<?php } ?> title="Chat Session">Chat Session</a></li>
    <li><a href="<?php echo $url; ?>&p=samplechat"<?php if($page=='samplechat'){ ?> class="active"<?php } ?> title="Sample Chat">Sample Chat</a></li>
    <li><a href="<?php echo $url; ?>&p=pages"<?php if($page=='pages'){ ?> class="active"<?php } ?> title="Pages">Pages</a></li>
</ul>


<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;

$error=array();

if(isset($_POST['updateconfig']))
{
	if($page=='doctorprice')
	{
		$general_doc_one_price=$_POST['general_doc_one_price'];
		$general_doc_five_price=$_POST['general_doc_five_price'];
		if(trim(get_option('general_doc_one_price'))=='')
		{
			add_option( 'general_doc_one_price', $general_doc_one_price, '', 'yes' );
			add_option( 'general_doc_five_price', $general_doc_five_price, '', 'yes' );
		}
		else
		{
			update_option( 'general_doc_one_price', $general_doc_one_price );
			update_option( 'general_doc_five_price', $general_doc_five_price );
		}
		$specialist_doc_one_price=$_POST['specialist_doc_one_price'];
		$specialist_doc_five_price=$_POST['specialist_doc_five_price'];
		if(trim(get_option('specialist_doc_one_price'))=='')
		{
			add_option( 'specialist_doc_one_price', $specialist_doc_one_price, '', 'yes' );
			add_option( 'specialist_doc_five_price', $specialist_doc_five_price, '', 'yes' );
		}
		else
		{
			update_option( 'specialist_doc_one_price', $specialist_doc_one_price );
			update_option( 'specialist_doc_five_price', $specialist_doc_five_price );
		}
	}
	else if($page=='currency')
	{
		$currency_code=$_POST['currency_code'];
		$currency_symbol=$_POST['currency_symbol'];
		if(trim(get_option('currency_code'))=='')
		{
			add_option( 'currency_code', $currency_code, '', 'yes' );
			add_option( 'currency_symbol', $currency_symbol, '', 'yes' );
		}
		else
		{
			update_option( 'currency_code', $currency_code );
			update_option( 'currency_symbol', $currency_symbol );
		}
	}else if($page=='paymentgateway'){
		$paypalid=$_POST['paypalid'];
		$gateway_mode=$_POST['gateway_mode'];
		if(trim(get_option('paypalid'))=='')
		{
			add_option( 'paypalid', $paypalid, '', 'yes' );
			add_option( 'gateway_mode', $gateway_mode, '', 'yes' );
		}
		else
		{
			update_option( 'paypalid', $paypalid );
			update_option( 'gateway_mode', $gateway_mode );
		}
	}else if($page=='signature'){
		$signature=$_POST['signature'];
		if(trim(get_option('signature'))=='')
		{
			add_option( 'signature', $signature, '', 'yes' );
		}
		else
		{
			update_option( 'signature', $signature );
		}
	}else if($page=='specialtype'){
		$specialtypess=$_POST['specialtype'];
		asort($specialtypess);
		$specialtype=serialize($specialtypess);
		if(trim(get_option('specialtype'))=='')
		{
			add_option( 'specialtype', $specialtype, '', 'yes' );
		}
		else
		{
			update_option( 'specialtype', $specialtype );
		}
	}else if($page=='degrees'){
		$degs=$_POST['degrees'];
		asort($degs);
		$degrees=serialize($degs);
		if(trim(get_option('degrees'))=='')
		{
			add_option( 'degrees', $degrees, '', 'yes' );
		}
		else
		{
			update_option( 'degrees', $degrees );
		}
		
	}else if($page=='settime'){
		$gendoctorchatprice=$_POST['gendoctorchatprice'];
		$spesdoctorchatprice=$_POST['spesdoctorchatprice'];
		$chatsessiontime=$_POST['chatsessiontime'];
		if(trim(get_option('gendoctorchatprice'))=='')
		{
			add_option( 'gendoctorchatprice', $gendoctorchatprice, '', 'yes' );
			add_option( 'spesdoctorchatprice', $spesdoctorchatprice, '', 'yes' );
			add_option( 'chatsessiontime', $chatsessiontime, '', 'yes' );
		}
		else
		{
			update_option( 'gendoctorchatprice', $gendoctorchatprice );
			update_option( 'spesdoctorchatprice', $spesdoctorchatprice );
			update_option( 'chatsessiontime', $chatsessiontime );
		}
	}else if($page=='pages'){
		$pages2=serialize($_POST['pages']);
		if(trim(get_option('pages'))=='')
		{
			add_option( 'pages', $pages2, '', 'yes' );
		}
		else
		{
			update_option( 'pages', $pages2 );
		}
	}
	else if($page=='samplechat')
	{
		/*$samplechat=stripslashes($_POST['samplechat']);
		if(trim(get_option('samplechat'))=='')
		{
			add_option( 'samplechat', $samplechat, '', 'yes' );
		}
		else
		{
			update_option( 'samplechat', $samplechat );
		}*/
		$photos=array();
		if(isset($_FILES))
		{
			//$fils=AllUserextrafieldinfo($user_id," and inputtype='file'");
			//$cnt=count($fils)+1;
			$samplechatphotos=unserialize(get_option('samplechatphotos'));
			
			if(count($samplechatphotos)>0)
			{
				$cnt=1;
				for($j=0;$j<count($samplechatphotos);$j++)
				{
					if(isset($_FILES['photo_'.$j]['name']) && trim($_FILES['photo_'.$j]['name'])!='')
					{
						if ($_FILES['photo_'.$j]["error"] > 0)
						{
							// echo "Error: " . $files["error"] . "<br />";
						}
						else
						{
							
							if (!is_dir('../wp-content/uploads/samplechat')) {
								mkdir('../wp-content/uploads/samplechat');
							}
							$alias='photo_'.$cnt;
							$exts=explode('.',$_FILES['photo_'.$j]["name"]);
							$exten='.'.$exts[count($exts)-1];
							$altername=$alias.$exten;
							  if(move_uploaded_file($_FILES['photo_'.$j]["tmp_name"], "../wp-content/uploads/samplechat/" . $_FILES['photo_'.$j]["name"]))
							  {
								rename("../wp-content/uploads/samplechat/".$_FILES['photo_'.$j]["name"], "../wp-content/uploads/samplechat/$altername");
								$cnt++;
								array_push($photos,$altername);
							}
						}
					}
					else
					{
						if(!isset($_FILES['photo_'.$j]['name']))
						{
							@unlink("../wp-content/uploads/samplechat/".$samplechatphotos[$j]);
						}
						array_push($photos,$samplechatphotos[$j]);
					}
				}
				$cnt=count($samplechatphotos)+1;
			}
			else
			{
				$cnt=1;
			}
			//print_r($_FILES);
			foreach($_FILES as $key=>$files)
			{
				//echo $key;
				
				for($i=0;$i<count($files['name']);$i++)
				{
					//print_r($files['name'][$i]);
					if(isset($files['name'][$i]))
					{
						if ($files["error"][$i] > 0)
						{
							// echo "Error: " . $files["error"] . "<br />";
						}
						else
						{
							
							if (!is_dir('../wp-content/uploads/samplechat')) {
								mkdir('../wp-content/uploads/samplechat');
							}
							$alias='photo_'.$cnt;
							$exts=explode('.',$files["name"][$i]);
							$exten='.'.$exts[count($exts)-1];
							$altername=$alias.$exten;
							  if(move_uploaded_file($files["tmp_name"][$i], "../wp-content/uploads/samplechat/" . $files["name"][$i]))
							  {
								rename("../wp-content/uploads/samplechat/".$files["name"][$i], "../wp-content/uploads/samplechat/$altername");
								$cnt++;
								array_push($photos,$altername);
							}
						}
					}
				}
				
			}
			
		}
		
		$samplechatphotos=serialize($photos);
		if(trim(get_option('samplechatphotos'))=='')
		{
			add_option( 'samplechatphotos', $samplechatphotos, '', 'yes' );
		}
		else
		{
			update_option( 'samplechatphotos', $samplechatphotos );
		}
		
		$samplechatmsg=serialize($_POST['msg']);
		if(trim(get_option('samplechatmsg'))=='')
		{
			add_option( 'samplechatmsg', $samplechatmsg, '', 'yes' );
		}
		else
		{
			update_option( 'samplechatmsg', $samplechatmsg );
		}
		
		$samplechatdates=serialize($_POST['dates']);
		if(trim(get_option('samplechatdates'))=='')
		{
			add_option( 'samplechatdates', $samplechatdates, '', 'yes' );
		}
		else
		{
			update_option( 'samplechatdates', $samplechatdates );
		}
		
	}
	
	$_SESSION['mssg']='Update successfully.';
	echo"<script>window.location=''</script>";
}

$sql="select ID, post_title from ".$prefix."posts where post_type='page' and post_status='publish' order by post_title";
$postpages = $wpdb->get_results($sql, OBJECT);	
?>

	  <form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
         <div class="clr" style="margin-top:50px;">&nbsp;</div>
           <?php if($page=='doctorprice'){ ?>
           	<div class="personal_info" style="width:235px;">General Doctor's Question Price: </div> 
            <input name="general_doc_one_price" type="text" value="<?php _e(get_option('general_doc_one_price'));?>" class="required number" />
            <div class="clr"></div>
            <div class="personal_info" style="width:235px;">General Doctor's Three Questions Price: </div> 
            <input name="general_doc_five_price" type="text" value="<?php _e(get_option('general_doc_five_price'));?>" class="required number" />
            <div class="clr"></div>
            <div class="personal_info" style="width:235px;">Specialist's One Question Price: </div> 
            <input name="specialist_doc_one_price" type="text" value="<?php _e(get_option('specialist_doc_one_price'));?>" class="required number" />
            <div class="clr"></div>
            <div class="personal_info" style="width:235px;">Specialist's Three Questions Price: </div> 
            <input name="specialist_doc_five_price" type="text" value="<?php _e(get_option('specialist_doc_five_price'));?>" class="required number" />
            <div class="clr"></div>
           <?php }else if($page=='currency'){ ?>
           <div class="personal_info">Currency Code: </div> 
            <input name="currency_code" type="text" value="<?php _e(get_option('currency_code'));?>" class="required" />
            <div class="clr"></div>
            <div class="personal_info">Symbol: </div> 
            <input name="currency_symbol" type="text" value="<?php _e(get_option('currency_symbol'));?>" class="required" />
            <div class="clr"></div>
            <?php }else if($page=='paymentgateway'){ ?>
           <div class="personal_info">Paypal Detail: </div> 
            <input name="paypalid" type="text" value="<?php _e(get_option('paypalid'));?>" class="required" />
            <div class="clr"></div>
            <div class="personal_info">Mode: </div> 
            <select name="gateway_mode">
            	<option value="test"<?php if(get_option('gateway_mode')=='test'){_e(' selected="selected"');} ?>>Test</option>
                <option value="live"<?php if(get_option('gateway_mode')=='live'){_e(' selected="selected"');} ?>>Live</option>
            </select>
            <div class="clr"></div> 
            <?php }else if($page=='specialtype'){ 
			
            $specialties=unserialize(get_option('specialtype'));
			
			?>
           <div class="personal_info">Speciality Type: </div> 
            <div class="clr"></div>
            <div class="samplechasts">
            <?php if(count($specialties)>0){foreach($specialties as $specialty){ ?>
            <div class="specialty">
                <div class="field"><input type="text" name="specialtype[]" value="<?php _e(stripslashes($specialty)); ?>" /></div>
                <a href="javascript:;" class="delspeciality">X</a>
            </div>
            <div class="clr"></div>
            <?php }}else{ ?>
            <div class="specialty">
                <div class="field"><input type="text" name="specialtype[]" value="" /></div>
            </div>
            <div class="clr"></div>
            <?php } ?>
            </div>
            <div class="clr"></div>
            <a href="javascript:;" class="addmorespeciality">Add More</a>
             <?php }else if($page=='degrees'){
            $degrees=unserialize(get_option('degrees'));
			//asort($degrees);
			?>
           <div class="personal_info">Doctors Degrees: </div> 
            <div class="clr"></div>
            <div class="samplechasts">
            <?php if(count($degrees)>0){foreach($degrees as $deg){ ?>
            <div class="specialty">
                <div class="field"><input type="text" name="degrees[]" value="<?php _e(stripslashes($deg)); ?>" /></div>
                <a href="javascript:;" class="delspeciality">X</a>
            </div>
            <div class="clr"></div>
            <?php }}else{ ?>
            <div class="specialty">
                <div class="field"><input type="text" name="degrees[]" value="" /></div>
            </div>
            <div class="clr"></div>
            <?php } ?>
            </div>
            <div class="clr"></div>
            <a href="javascript:;" class="addmoredegree">Add More</a>
             <?php }else if($page=='settime'){ ?>
           <div class="personal_info" style="width:235px;">General Doctor's Chat Price:: </div> 
            <input name="gendoctorchatprice" type="text" value="<?php _e(get_option('gendoctorchatprice'));?>" class="required number" />
            <div class="clr"></div>
            <div class="personal_info" style="width:235px;">Specialist's Chat Price: </div> 
            <input name="spesdoctorchatprice" type="text" value="<?php _e(get_option('spesdoctorchatprice'));?>" class="required number" />
            <div class="clr"></div>
             <div class="personal_info" style="width:235px;">One chat session (in minutes): </div> 
            <input name="chatsessiontime" type="text" value="<?php _e(get_option('chatsessiontime'));?>" class="required number" />
            <div class="clr"></div>
            <?php } else if($page=='pages'){ ?>
           
            <?php if(count($postpages)>0){ $pastpages=unserialize(get_option('pages'));?>
            	<div class="personal_info">Doctor Login: </div> 
            	<select name="pages[doctor_login]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_login'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
            	<div class="personal_info">Doctor's Profile: </div> 
            	<select name="pages[doctor_profile]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_profile'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               
               <div class="personal_info">Doctor's Dasboard: </div> 
            	<select name="pages[doctor_dasboard]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_dasboard'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               <div class="personal_info">Get Answer Now: </div> 
            	<select name="pages[choose_doctor]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['choose_doctor'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               <div class="personal_info">Doctor Detail Page: </div> 
            	<select name="pages[doctor_detail]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_detail'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Doctor's Patients: </div> 
            	<select name="pages[doctor_patients]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_patients'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Meet Our Doctors: </div> 
            	<select name="pages[doctor_list]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_list'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
                <div class="personal_info">Set Time Zone For Question: </div> 
            	<select name="pages[question_timezone]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['question_timezone'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
                <div class="personal_info">Set Time Zone: </div> 
            	<select name="pages[doctor_timezone]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_timezone'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
                <div class="personal_info">Doctor Add Schedule: </div> 
            	<select name="pages[doctor_addschedule]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_addschedule'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                 <div class="clr"></div>
                <div class="personal_info">Doctor Schedules: </div> 
            	<select name="pages[doctor_schedule]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_schedule'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
                <div class="personal_info">Doctor Chat: </div> 
            	<select name="pages[doctor_chat]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_chat'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Make Virtual Appointment: </div> 
            	<select name="pages[virtual_appointment]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['virtual_appointment'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                 <div class="clr"></div>
               <div class="personal_info">User Login: </div> 
            	<select name="pages[user_login]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_login'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               <div class="personal_info">User Profile: </div> 
            	<select name="pages[user_profile]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_profile'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">User Chat: </div> 
            	<select name="pages[user_chat]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_chat'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">User Timezone: </div> 
            	<select name="pages[user_timezone]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_timezone'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">User Choose Another doctor: </div> 
            	<select name="pages[user_chooseanotherdoctor2]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_chooseanotherdoctor2'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               <div class="personal_info">Make Virtual Appointment with Another doctor: </div> 
            	<select name="pages[user_chooseanotherdoctor]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_chooseanotherdoctor'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               <div class="personal_info">Confirm Question Detail: </div> 
            	<select name="pages[confirm_detail]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['confirm_detail'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Thanks For Question: </div> 
            	<select name="pages[payment_confirm]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['payment_confirm'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Users Question: </div> 
            	<select name="pages[user_questions]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['user_questions'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">Doctor Answer: </div> 
            	<select name="pages[doctor_answer]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['doctor_answer'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
                <div class="clr"></div>
               <div class="personal_info">What Customers are Asking: </div> 
            	<select name="pages[question_list]" class="required">
                	<option value="">Select Page</option>
                    <?php foreach($postpages as $postpage){ ?>
                    <option value="<?php echo $postpage->ID; ?>"<?php if(trim($pastpages['question_list'])==$postpage->ID){_e(' selected="selected"');} ?>><?php echo $postpage->post_title; ?></option>
                    <?php } ?>
                </select>
               <div class="clr"></div>
               
            <?php }}else if($page=='samplechat'){ 
			$samplechatphotos=unserialize(get_option('samplechatphotos'));
			$samplechatmsg=unserialize(get_option('samplechatmsg'));
			$samplechatdates=unserialize(get_option('samplechatdates'));
			?>
           <div class="personal_info">Sample chat: </div> 
            <div class="clr"></div>
            <div class="samplechasts">
            <?php if(count($samplechatmsg)>0){for($i=0;$i<count($samplechatmsg);$i++){ ?>
            <div class="samplechat">
            	<div class="field">
                <input type="file" name="photo_<?php echo $i; ?>" />
                <?php if(file_exists("../wp-content/uploads/samplechat/".$samplechatphotos[$i]) && trim($samplechatphotos[$i])!=''){ ?>
                <br style="clear:both;" />
                	<img src="<?php _e(get_option('home').'/wp-content/uploads/samplechat/'.$samplechatphotos[$i]); ?>" style="max-width:100%" />
                <?php }?>
                
                </div>
                <div class="field"><textarea name="msg[]" rows="2" cols="50"><?php _e(stripslashes($samplechatmsg[$i])); ?></textarea></div>
                <div class="field"><input type="text" name="dates[]" value="<?php _e(stripslashes($samplechatdates[$i])); ?>" /></div>
                <a href="javascript:;" class="del">X</a>
            </div>
            <div class="clr"></div>
            <?php }}else{ ?>
            <div class="samplechat">
            	<div class="field"><input type="file" name="pphotos[]" /></div>
                <div class="field"><textarea name="msg[]" rows="2" cols="50"></textarea></div>
                <div class="field"><input type="text" name="dates[]" value="" /></div>
            </div>
            <div class="clr"></div>
            <?php } ?>
            </div>
            <div class="clr"></div>
            <a href="javascript:;" class="addmorechat">Add More</a>
             <?php } ?>
            
            <div class="clr"></div>
            <br /><input type="submit" name="updateconfig" value="Save" title="Save" />
           <div class="clr"></div>
		</form>
        <script type="text/javascript">
			jQuery('a.addmorechat').live('click', function(){
				jQuery('.samplechasts').append('<div class="samplechat"><div class="field"><input type="file" name="pphotos[]" /></div><div class="field"><textarea name="msg[]" rows="2" cols="50"></textarea></div><div class="field"><input type="text" name="dates[]" value="" /></div></div><div class="clr"></div>');
			});
			jQuery('a.del').live('click', function(){
				jQuery(this).parent('.samplechat').remove();
			});
			
			jQuery('a.addmorespeciality').live('click', function(){
				jQuery('.samplechasts').append('<div class="specialty"><div class="field"><input type="text" name="specialtype[]" value="" /></div></div><div class="clr"></div>');
			});
			jQuery('a.addmoredegree').live('click', function(){
				jQuery('.samplechasts').append('<div class="specialty"><div class="field"><input type="text" name="degrees[]" value="" /></div></div><div class="clr"></div>');
			});
			jQuery('a.delspeciality').live('click', function(){
				jQuery(this).parent('.specialty').remove();
			});
		</script>
<div class="clr"></div>