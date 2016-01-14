<?php 
global $wpdb;
$prefix=$wpdb->base_prefix;
$error=array();

$querystr = "SELECT * FROM ".$prefix."temple_state";
$states = $wpdb->get_results($querystr, OBJECT);

$querystr1 = "SELECT * FROM ".$prefix."temple_city";
$cities = $wpdb->get_results($querystr1, OBJECT);

$querystr2 = "SELECT * FROM ".$prefix."temple_god";
$gods = $wpdb->get_results($querystr2, OBJECT);
$packagetypes=packagetypedetail();
$stars = Stardetail();
$categories = Categorydetail();
$packages=packagedetail("", " order by package_type_id asc");
if(isset($_POST['registration']))
{
	$name=$_POST['name'];
	if(trim($name)=='')
	{
		array($error,'Please enter temple name.');
	}
	$god_id=$_POST['god_id'];
	if(count($god_id)<=0)
	{
		array($error,'Please select atleast one God.');
	}
	$state_id=$_POST['stateid'];
	$star_id=$_POST['star_id'];
	$city_id=$_POST['city'];
	$district_id=$_POST['district_id'];
	$googleaddress=trim($_POST['googleaddress']);
	$inthetemple=$_POST['inthetemple'];
	$openinghours=$_POST['openinghours'];
	$address=$_POST['address'];
	$phone=$_POST['phone'];
	$general_info=$_POST['general_info'];
	$description=$_POST['description'];
	$heighlight=$_POST['heighlight'];
	$location=$_POST['location'];
	$nearrailway=$_POST['nearrailway'];
	$nearairport=$_POST['nearairport'];
	$accomodation_name=$_POST['accomodation_name'];
	$accomodation_phone=$_POST['accomodation_phone'];
	$category_id=$_POST['category_id'];
	$accomos=array('accomodation_name'=>$accomodation_name,'accomodation_phone'=>$accomodation_phone);
	
	$accomodation=serialize($accomos);
	if(count($error)<=0)
	{
		$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($googleaddress)."&sensor=false";						
		$url = str_replace('&amp;','&',$url);						
		$ch = curl_init();						
		curl_setopt($ch, CURLOPT_URL, $url);						
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);						
		$xml = curl_exec($ch);						
		curl_close ($ch); 						
		$output = json_decode($xml);
		$latitude ='';														
		$longitude ='';
		if(count($output->results)>0)
		{															
			$latitude = $output->results[0]->geometry->location->lat;														
			$longitude = $output->results[0]->geometry->location->lng;
		}
		
		$sql="INSERT INTO `".$prefix."temple_temples` (`state_id`, `city_id`, `district_id`, `name`, `inthetemple`, `openinghours`, `address`, `googleaddress`, `phone`, `general_info`, `description`, `heighlight`, `latitude`, `longitude`, `location`, `nearrailway`, `nearairport`, `add_date`, `accomodation`, `star_id`, `category_id`) VALUES ('$state_id', '$city_id', '$district_id', '$name', '$inthetemple', '$openinghours', '$address', '$googleaddress', '$phone', '$general_info', '$description', '$heighlight', '$latitude', '$longitude', '$location', '$nearrailway', '$nearairport', now(), '$accomodation', '$star_id', '$category_id')";
		$result2 = $wpdb->query($sql);
		
		
		$temple_id = $wpdb->insert_id;
		$alias='temple-'.$temple_id;
		$my_post = array(
			  'post_title'    => $name,
			  'post_content'  => '',
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type' => 'temple'
			);
			
		// Insert the post into the database
		$post_id=wp_insert_post( $my_post );
		$sql="UPDATE `".$prefix."temple_temples` set post_id='$post_id' where id='$temple_id'";
		$result = $wpdb->query( $sql );
		
		for($i = 0; $i < count($god_id); $i++)
		{
			$sql="INSERT INTO `".$prefix."temple_templesgod` (`temple_id`, `god_id`, `updated_on`) VALUES ('$temple_id', '$god_id[$i]', now())"; 
			$result = $wpdb->query( $sql );
		}
		$package_type_id=$_POST['package_type_id'];
		$packs=$_POST['packs'];
		for($i = 0; $i < count($packs); $i++)
		{
			$package_id=$packs[$i];
			$price=$_POST['price_'.$package_id];
			$sql="INSERT INTO `".$prefix."temple_package_price` (`temple_id`, `package_id`, `package_type_id`, `price`, `add_date`) VALUES ('$temple_id', '$package_id', '$package_type_id', '$price', now())"; 
			$result = $wpdb->query( $sql );
		}
		
		$file='image';
		if(isset($_FILES[$file]['name']))
		{
			if (!is_dir('../wp-content/uploads/temples')) {
				mkdir('../wp-content/uploads/temples');
			}
			if (!is_dir('../wp-content/uploads/temples/thumb')) {
				mkdir('../wp-content/uploads/temples/thumb');
			}
			
			if($_FILES[$file]['name']!='')
			{
				if ( (strtolower($_FILES[$file]["type"]) == "image/gif")
				|| (strtolower($_FILES[$file]["type"]) == "image/jpeg")
				|| (strtolower($_FILES[$file]["type"]) == "image/jpg")
				|| (strtolower($_FILES[$file]["type"]) == "image/png")
				|| (strtolower($_FILES[$file]["type"]) == "image/pjpeg"))
				  {
					if ($_FILES[$file]["error"] > 0)
					{
						 echo "Error: " . $_FILES[$file]["error"] . "<br />";
					}
					else
					{
						$exts=explode('.',$_FILES[$file]["name"]);
						$exten='.'.$exts[count($exts)-1];
						$altername=$alias.$exten;
						move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/temples/" . $_FILES[$file]["name"]);
						rename("../wp-content/uploads/temples/".$_FILES[$file]["name"], "../wp-content/uploads/temples/$altername");
						require_once('class.img2thumb.php');
						$Img2Thumb = new Img2Thumb( "../wp-content/uploads/temples/".$altername, '300', '300', "../wp-content/uploads/temples/thumb/".$altername, 0, 255, 255, 255 );
						$sql="UPDATE `".$prefix."temple_temples` set image='$altername' where id='$temple_id'";
						$result = $wpdb->query( $sql );
					}
				}
			}
		}
		$urchavar=$_POST['urchavar'];
		updatetempleoption($temple_id, 'urchavar', $urchavar);
		
		$mother=$_POST['mother'];
		updatetempleoption($temple_id, 'mother', $mother);
		
		$sacredtree=$_POST['sacredtree'];
		updatetempleoption($temple_id, 'sacredtree', $sacredtree);
		
		$tirtha=$_POST['tirtha'];
		updatetempleoption($temple_id, 'tirtha', $tirtha);
		
		$ecclesiasticus_pooja=$_POST['ecclesiasticus_pooja'];
		updatetempleoption($temple_id, 'ecclesiasticus_pooja', $ecclesiasticus_pooja);
		
		$creepy=$_POST['creepy'];
		updatetempleoption($temple_id, 'creepy', $creepy);
		
		$legendary_name=$_POST['legendary_name'];
		updatetempleoption($temple_id, 'legendary_name', $legendary_name);
		
		$trail=$_POST['trail'];
		updatetempleoption($temple_id, 'trail', $trail);
		
		if($result2==1)
		{
			$url=get_option('home').'/wp-admin/admin.php?page=Temples&add=succ';
			echo"<script>window.location='".$url."'</script>";
		}
	}
}

?>

<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/validate.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/temple/js/tabcontent.js"></script>
<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#register_spcialist").validate();
	jQuery('textarea[name="googleaddress"]').live('keyup', function(){
		var address=jQuery('textarea[name="googleaddress"]').val();
		
		if(jQuery.trim(address)!='')
		{
			jQuery('#googlemape').show(400);
			jQuery.ajax({
			url: '<?php echo get_option('home');?>/wp-content/plugins/temple/gmap.php?gnmap=sales',
			type: 'post',
			data: jQuery('textarea[name="googleaddress"]'),
			dataType: 'json',
			beforeSend: function() {},	
			complete: function() {},			
			success: function(json) {
				
				if (json['error']) {			
					var map = new google.maps.Map(document.getElementById('googlemape'), {
					  zoom: 7,
					  center: new google.maps.LatLng(22.9463305, -79.2004711),
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					//mapTypeId: 'terrain'
					});
				}else{
					
					var lati_center = json['success']['lat'];
					var longi_center = json['success']['longi'];
					
					var map = new google.maps.Map(document.getElementById('googlemape'), {
					  zoom: 7,
					  center: new google.maps.LatLng(lati_center, longi_center),
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					//mapTypeId: 'terrain'
						});
					
					
				}
					if (json['success']) 
					{					
						// GOOGLE MAP START HERE //////////////////						
						var locations = new Array();	
						locations = json['success']['map'];						
						var marker = new Array();
						var i;							
						var addinfo = new Array();
						var latitude = new Array();
						var longitude = new Array();
						for (i = 0; i < locations.length; i++) 
						{ 						
							var map_info = locations[i].split('@@');
							if(map_info.length == 3)
							{							
								addinfo[i] = decodeURIComponent(map_info[0]).replace(/\+/g, ' ');								
								latitude[i] = map_info[1];
								longitude[i] = map_info[2];
								marker[i] = new google.maps.Marker({
									position: new google.maps.LatLng(latitude[i], longitude[i]),
									radius: 500,
									types: ['store'],
									map: map
							  	});
								addInfoWindow(marker[i], addinfo[i], map);
							
						  	} // MAP LENGTH
						}											
						// SALES GOOGLE MAP END  //
					}	
				}	
			});
			//return false;
		}
	});
	
	jQuery('.package').css({'display':'none'});
	jQuery('.package input').attr('disabled', true);
	
	jQuery('#package_type_id').live('change', function(){
		var packtype_id=jQuery(this).val();
		jQuery('.package').css({'display':'none'});
		jQuery('.package input').attr('disabled', true);
		
		jQuery('.pack_'+packtype_id).css({'display':'block'});
		jQuery('.pack_'+packtype_id+' input').attr('disabled', false);
	});
	
	jQuery('#stateid').live('change',function(){
		var state_id=jQuery(this).val();
		var url='<?php echo get_option('home');?>/wp-content/plugins/temple/finddistricts.php';
		jQuery.post(url, {state_id:state_id},
		function(data)
		{
			jQuery('#districtdiv').html(data);
		});
	});
	jQuery('#district_id').live('change',function(){
		var district_id=jQuery(this).val();
		var url='<?php echo get_option('home');?>/wp-content/plugins/temple/findCity.php';
		jQuery.post(url, {district_id:district_id},
		function(data)
		{
			jQuery('#citydiv').html(data);
		});
	});
});
function addInfoWindow(marker, message, map) 
{
	var info = message;
	
	var infoWindow = new google.maps.InfoWindow({
		content: message
	});

	google.maps.event.addListener(marker, 'click', function () {
		infoWindow.open(map, marker);
	});
}
</script>

<h2>Add Temple</h2>

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
	 <form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
		<ul class="tabs">
			<li class="selected"><a href="#view1">Detail</a></li>
			<li class=""><a href="#view2">Route</a></li>
			<li class=""><a href="#view3" class="gmap">Map</a></li>
			<li class=""><a href="#view4">Book Now</a></li>
		</ul>
        <div class="tabcontents donotshowerror">
        	<div id="view1">
     			<div class="e-mail">
                    <div class="adress">Temple *:  </div>
                    <div class="field"><input type="text" class="required" name="name" value="<?php _e($name); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Image *:  </div>
                    <div class="field"><input type="file" class="required" name="image"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Lord *:  </div>
                    <div class="field">
					<?php
						foreach($gods as $temgod)
						{
					?>	
                    	<input type="checkbox" value="<?php _e($temgod->id); ?>" name="god_id[]"/><?php _e($temgod->god); ?>
						<br/>
					<?php		
						}
					?>
					</div>
                </div>
				<div class="e-mail">
                    <div class="adress">Urchavar:  </div>
                    <div class="field"><input type="text" name="urchavar" value="<?php _e($urchavar); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Mother / mother:  </div>
                    <div class="field"><input type="text" name="mother" value="<?php _e($mother); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Sacred Tree:  </div>
                    <div class="field"><input type="text" name="sacredtree" value="<?php _e($sacredtree); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Tirtha:  </div>
                    <div class="field"><input type="text" name="tirtha" value="<?php _e($tirtha); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Ecclesiasticus / Pooja:  </div>
                    <div class="field"><input type="text" name="ecclesiasticus_pooja" value="<?php _e($ecclesiasticus_pooja); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Creepy:  </div>
                    <div class="field"><input type="text" name="creepy" value="<?php _e($creepy); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Legendary Name:  </div>
                    <div class="field"><input type="text" name="legendary_name" value="<?php _e($legendary_name); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Trail:  </div>
                    <div class="field"><input type="text" name="trail" value="<?php _e($trail); ?>"/></div>
                </div>
     			<div class="e-mail">
                    <div class="adress">State:  </div>
                    <div class="field">
                   		<select class="required" name="stateid" id="stateid">
                        <option value="">Select State</option>
                        	<?php
								foreach($states as $st)
								{
							?>	
                            	<option value="<?php _e($st->id); ?>"><?php _e($st->state); ?></option>
							<?php		
								}
							?>
                        </select>
                    </div>
                </div>
				<div class="e-mail">
                    <div class="adress">District:  </div>
                    <div class="field">
                   		<div id="districtdiv">
                        <select class="required" name="district_id" id="district_id">
                            <option value="">Select District</option>
                        </select>
                        </div>
                     </div>
                </div>
                <div class="e-mail">
                    <div class="adress">City:  </div>
                    <div class="field">
                   		<div id="citydiv">
                        <select class="required" name="city">
                            <option value="">Select City</option>
                        </select>
                        </div>
                     </div>
                </div>
				<div class="e-mail">
                    <div class="adress">Category:  </div>
                    <div class="field">
                   		<select name="category_id">
                        <option value="">Select Category</option>
                        	<?php
								if(count($categories)>0){foreach($categories as $category){
							?>	
                            	<option value="<?php _e($category->id); ?>"<?php if($category->id==$category_id){echo' selected="selected"';} ?>><?php _e($category->category); ?></option>
							<?php		
								}}
							?>
                        </select>
                    </div>
                </div>
				<div class="e-mail">
                    <div class="adress">Star:  </div>
                    <div class="field">
                   		<select name="star_id">
                        <option value="">Select Star</option>
                        	<?php
								if(count($stars)>0){foreach($stars as $st){
							?>	
                            	<option value="<?php _e($st->id); ?>"<?php if($st->id==$star_id){echo' selected="selected"';} ?>><?php _e($st->star); ?></option>
							<?php		
								}}
							?>
                        </select>
                    </div>
                </div>
				<div class="e-mail">
                    <div class="adress">In the temple:  </div>
                    <div class="field"><textarea rows="2" cols="70" name="inthetemple"><?php  _e($inthetemple); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Opening hours:  </div>
                    <div class="field"><textarea rows="2" cols="70" name="openinghours"><?php  _e($openinghours); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Address:  </div>
                    <div class="field"><textarea rows="2" cols="70" name="address"><?php  _e($address); ?></textarea></div>
                </div>
   				<div class="e-mail">
                    <div class="adress">Phone numbers:  </div>
                    <div class="field"><input type="text" name="phone" value="<?php _e($phone); ?>"/></div>
                </div>
    			<div class="e-mail">
                    <div class="adress">General Information:  </div>
                    <div class="field"><textarea rows="5" cols="70" name="general_info"><?php  _e($general_info); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Talaperumai:  </div>
                    <div class="field"><textarea rows="5" cols="70" name="description"><?php  _e($description); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Highlight:  </div>
                    <div class="field"><textarea rows="4" cols="70" name="heighlight"><?php  _e($heighlight); ?></textarea></div>
                </div>
        	</div>
			
			<div id="view2">
				<div class="e-mail">
                    <div class="adress">Location:  </div>
                    <div class="field"><textarea rows="2" cols="70" name="location"><?php  _e($location); ?></textarea></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Near By Railway Station:  </div>
                    <div class="field"><input type="text" name="nearrailway" value="<?php  _e($nearrailway); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Near By Airport:  </div>
                    <div class="field"><input type="text" name="nearairport" value="<?php  _e($nearairport); ?>"/></div>
                </div>
				<div class="clr"></div>
   				<h3>Accomodation: </h3>
				<?php for($i=0;$i<15;$i++){ $j=$i+1;?>
				<h5>Accomodation <?php echo $j; ?></h5>
    			<div class="e-mail">
                    <div class="adress">Name:  </div>
                    <div class="field"><input type="text" name="accomodation_name[]" value="<?php  _e($accomodation_name[$i]); ?>"/></div>
                </div>
				<div class="e-mail">
                    <div class="adress">Phone:  </div>
                    <div class="field"><input type="text" name="accomodation_phone[]" value="<?php  _e($accomodation_phone[$i]); ?>"/></div>
                </div>
				<div class="clr"></div>
				<?php } ?>
        	</div>
            
			<div id="view3">
				<div class="e-mail">
                    <div class="adress">Google map address:  </div>
                    <div class="field">
					<textarea rows="2" cols="70" name="googleaddress"><?php  _e($googleaddress); ?></textarea>
					<div class="clr"></div><p>Please check this address in google map for better results for near by temples search</p>
					</div>
                </div>
				
				<div class="clr"></div>
                 <div class="e-mail">
                    <div class="adress">Google map:  </div>
                    <div class="field">
					<div id="googlemape" style="height:500px; width:700px; margin-top:5px; display:none; color:#000000;"></div>
					</div>
                </div>
				<div class="clr"></div>
        	</div>
			
			<div id="view4">
				<div class="e-mail">
                    <div class="adress">Package Type *:  </div>
                    <div class="field">
					<select name="package_type_id" id="package_type_id">
						<option value="">Select Type</option>
						<?php if(count($packagetypes)>0){ foreach($packagetypes as $packagetype){?>
						<option value="<?php _e($packagetype->id); ?>"<?php if($package_type_id==$packagetype->id){_e(' selected="selected"');} ?>><?php _e($packagetype->package_type); ?></option>
						<?php }} ?>
					</select>
					</div>
                </div>
				<?php if(count($packages)>0){ foreach($packages as $package){ ?>
				<div class="e-mail package pack_<?php _e($package->package_type_id); ?>">
                    <div class="adress"><?php _e($package->title); ?>:  </div>
                    <div class="field">
						<input type="text" name="price_<?php _e($package->id); ?>" value="" class="number" placeholder="price" />
						<input type="hidden" name="packs[]" value="<?php _e($package->id); ?>" />
					</div>
                </div>
				<?php }} ?>
				
				<div class="clr"></div>
        	</div>
                
                
		<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="e-mail">
			<div class="adress">&nbsp;&nbsp;</div>
			<div class="field" style="margin-top:10px;">
				<div class="green-submit-btn">
					<input type="submit" name="registration" value="SUBMIT" class="registration_btn"/> <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
				</div>
			</div>
		</div>
	
	</form>
	</div>
<div class="clr"></div>

<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=Temples'; ?>';
}
</script>