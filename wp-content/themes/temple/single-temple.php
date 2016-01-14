<!-- HEADER-->
<?php @session_start();
global $post;
//print_r($post);

get_header(); 
$post_id=$post->ID;
$temples = templedetail('', " and post_id='$post_id'");
$temple=$temples[0];
$temple_id=$temple->id;
$image = $temple->image ;
$thumimage=$image;
$accomodation = $temple->accomodation;
$accomodats=unserialize($accomodation);
$urchavar=Templeoption($temple_id, 'urchavar');
$mother=Templeoption($temple_id, 'mother');
$sacredtree=Templeoption($temple_id, 'sacredtree');
$tirtha=Templeoption($temple_id, 'tirtha');
$ecclesiasticus_pooja=Templeoption($temple_id, 'ecclesiasticus_pooja');
$creepy=Templeoption($temple_id, 'creepy');
$legendary_name=Templeoption($temple_id, 'legendary_name');
$trail=Templeoption($temple_id, 'trail');

$states=Statedetail($temple->state_id);
$cities=Citydetail($temple->city_id);
$templegalleries=templegallery($temple_id);
$radius=100;
$cond=" and id!='$temple_id'";
$nearbytemples=nearbytemples($temple->latitude,$temple->longitude,$radius,$cond,0,20);

$showimage='';
if(trim($image)!='' && file_exists('wp-content/uploads/temples/'.$image)){
	list($imgwidth) = getimagesize('wp-content/uploads/temples/'.$image);
	/*if($imgwidth>781){
	$imagepath=get_option('home').'/wp-content/plugins/temple/imagecrope.php?width=781&amp;maxw=781&amp;height=330&amp;maxh=330&amp;file='.get_option('home').'/wp-content/uploads/temples/'.$image;
	}
	else
	{*/
		$imagepath=get_option('home').'/wp-content/uploads/temples/'.$image;
	//}
	$showimage='<div class="detail_img"><img src="'.$imagepath.'" alt="'.$temple->name.'" width="781" /></div>';
}
$booknow=false;
$templeprices=templeprices($temple_id);
if(count($templeprices)>0)
{
	$booknow=true;
}
 ?>
<!-- /HEADER  --> 
<!-- HEADER TITLE-->
<div class="container">
  <?php get_sidebar(); ?>
  <div class="mid_content page_content">
  
  
  <ul class="tabs">
    <li><a href="#view1">Detail</a></li>
    <li><a href="#view2">Calendar</a></li>
    <li><a href="#view3">Route</a></li>
    <li><a href="#view4" class="gmap">Map</a></li>
    <li><a href="#view5">Gallery</a></li>
    <li><a href="#view6">Nearby	</a></li>
    <?php if($booknow){ ?><li><a href="#view7">Book Now</a></li><?php } ?>
   
</ul>
<div class="clr"></div>
<div class="tabcontents">
    <div id="view1">
     <h1><?php _e($temple->name); ?></h1>
     <?php _e($showimage);
	 $tempgod=TempGodDetail('', " and temple_id='$temple_id'");
	  ?>
     <div class="archives_content_box">
   <div class="lord"><label>Lord </label><p>
   <?php if(count($tempgod)>0){$c=1;foreach($tempgod as $tempg){ $god=goddetail($tempg->god_id);if($c==1){_e($god[0]->god);}else{_e(', '.$god[0]->god);} $c++; }} ?>
   </p></div>
   <div class="lord"><label>Urchavar</label><p><?php _e($urchavar); ?></p></div>
   <div class="lord"><label> Mother / mother</label><p><?php _e($mother); ?></p></div>
   <div class="lord"><label> Sacred Tree  </label><p><?php _e($sacredtree); ?></p></div>
   <div class="lord"><label> Tirtha  </label><p><?php _e($tirtha); ?></p></div>
   <div class="lord"><label> Ecclesiasticus / Pooja  </label><p><?php _e($ecclesiasticus_pooja); ?></p></div>

<div class="lord"><label>Creepy </label><p><?php _e($creepy); ?></p></div>

<div class="lord"><label> Legendary Name </label><p><?php _e($legendary_name); ?></p></div>

<div class="lord"><label>Trail</label><p><?php _e($trail); ?></p></div>
<div class="lord"><label>City</label><p><?php _e($cities[0]->city); ?></p></div>
<div class="lord"><label>State</label><p><?php _e($states[0]->state); ?></p></div>
   </div>
   
   <div class="cnt_templs">
   <h3>In the temple</h3>
   <p><?php  _e($temple->inthetemple); ?></p>
   
    <h3>Opening hours</h3>
   <p><?php  _e($temple->openinghours); ?></p>
   
      <h3>Address</h3>
   <p><?php  _e($temple->address); ?></p>
   
      <h3>Phone</h3>
   <p><?php  _e($temple->phone); ?></p>
   
      <h3>General Information</h3>
   <p><?php  _e($temple->general_info); ?></p>
   
      <h3>Talaperumai</h3>
   <p><?php  _e($temple->description); ?></p>
   
    <h3>Highlight</h3>
   <p><?php  _e($temple->heighlight); ?></p>
   
   </div>
   <div class="clr"></div>
    </div>
    
    <div id="view2">
		<div class="calander_wrapper"></div>
    </div>
    <div id="view3">
		
		<div class="cnt_templs">
        <h3>Location</h3>
   		<p><?php  _e($temple->location); ?></p>
		<h3>Near By Railway Station</h3>
   		<p><?php  _e($temple->nearrailway); ?></p>
		<h3>Near By Airport</h3>
   		<p><?php  _e($temple->nearairport); ?></p>
		<?php if(count($accomodats)>0){ ?><h3>Accomodation</h3>
		
		<?php if(!empty($accomodats['accomodation_name'])){
			for($i=0;$i<count($accomodats['accomodation_name']);$i++)
			{
				if(!empty($accomodats['accomodation_name'][$i])){
				echo'<p>';
				_e($accomodats['accomodation_name'][$i]);
				if(!empty($accomodats['accomodation_phone'][$i])){_e(' - '.$accomodats['accomodation_phone'][$i]);}
				echo'</p>';
				}
			}}} ?>
		</div>
		<div class="clr"></div>
    </div>
    <div id="view4">
        <div id="googlemape" style="height:500px; width:700px; margin-top:5px; display:none; color:#000000;"></div>
		<div class="clr"></div>
    </div>
    
    <div id="view5">
       <?php if(count($templegalleries)>0){ foreach($templegalleries as $photo){ ?>
	   <div class="galleryimg">
	   	<a class="example-image-link" href="<?php echo get_option('home').'/wp-content/uploads/temples/gallery/'.$photo->image; ?>" data-lightbox="example-set" data-title="<?php  echo $photo->title; ?>"><img class="example-image" width="132" src="<?php echo get_option('home').'/wp-content/uploads/temples/gallery/thumb/'.$photo->image; ?>" alt="<?php  echo $photo->title; ?>" /></a>
		<br /><?php  echo $photo->title; ?></div>
	   <?php }} ?>
	   <div class="clr"></div>
    </div>
    
     <div id="view6">
        <?php $data='';
		if(count($nearbytemples)>0){foreach($nearbytemples as $nearbytemple){ 
			$image = $nearbytemple->image ;
		   $data.='<div class="mid_temple_box">';
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($nearbytemple->post_id).'"><img src="'.$imagepath.'" alt="'.$nearbytemple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($nearbytemple->post_id).'">'.$nearbytemple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($nearbytemple->add_date)).'</h3>
					<p>'.$nearbytemple->general_info.'</p>
					<a href="'.get_permalink($nearbytemple->post_id).'">More...</a> </div>
				</div>';
		} echo $data;} ?>
		<div class="clr"></div>
    </div>
    <?php if($booknow){ ?>
    <div id="view7" class="addingtocart">
        <?php 
		if(trim($thumimage)!='' && file_exists('wp-content/uploads/temples/thumb/'.$thumimage)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$thumimage; ?>
				 <div class="tpl_img"><img src="<?php echo $imagepath; ?>" alt="<?php $temple->name ?>" />
				  </div>
				 <?php } ?>
				 <p><?php echo $temple->inthetemple; ?></p>
				 <div class="clr"></div>
				 
				 <?php 
		foreach($templeprices as $templeprice)
		{
			$packagetype=packagetypedetail($templeprice->package_type_id);
			$package=packagedetail($templeprice->package_id);
			?><div class="addtocartform">
			<form name="shopping" class="shoppingcart" method="post" action="">
				<input type="hidden" name="temple_id" value="<?php echo $temple_id; ?>" />
				
				<p class="price"><?php _e($package[0]->title); ?> <span><?php _e($currency_symbal.$templeprice->price); ?></span></p>
				<input type="button" name="addtocart" class="addtocart" value="Add To Cart" />
				<input type="hidden" name="package_id" value="<?php echo $templeprice->package_id; ?>" />
			</form>
			</div>
			<div class="clr"></div>
			<?php
		}
		 ?>
		 <div class="addtocartoverlay"></div>
		 
		 <div class="clr"></div>
    </div>
	<?php } ?>
</div>

    
  </div>
  <div class="clr"></div>
</div>
<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.addtocart').live('click', function(){
		jQuery('.addtocartoverlay').css({'display':'block'});
		var package_id=jQuery(this).next('input[name="package_id"]').val();
		jQuery.post("<?php echo bloginfo('template_url');?>/addtocart.php", {temple_id : '<?php _e($temple_id); ?>', package_id : package_id},
		function(data) {
				jQuery('.hdr_top_right li.cart').html(data);
				jQuery('html, body').animate({scrollTop : 0},1000);
				jQuery('.addtocartoverlay').css({'display':'none'});
		});
	});
	jQuery('ul.tabs li').live('click', function(){
		if(jQuery('a',this).hasClass('gmap'))
		{
			var address='<?php _e(trim($temple->googleaddress)); ?>'
			if(jQuery.trim(address)!='')
			{
				jQuery('#googlemape').show(400);
				jQuery.ajax({
				url: '<?php echo get_option('home');?>/wp-content/plugins/temple/gmap.php?gnmap=sales&googleaddress='+address,
				type: 'post',
				data: '',
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
		}
		
	});
	var url='<?php echo bloginfo('template_url');?>/cal.php?temple_id=<?php echo $temple_id; ?>';
	jQuery.ajax({
		url: url,
		success: function(data) 
		{
			jQuery('.calander_wrapper').html(data);
			jQuery( ".calendardetail" ).draggable({ handle: "a.movecalendar" });
		}
	});
	jQuery('.npdate').live('click', function(){
	
		var u=jQuery(this).attr('href');
		var url='<?php echo bloginfo('template_url');?>/cal.php?temple_id=<?php echo $temple_id; ?>&date='+u;
		jQuery.ajax({
			url: url,
			success: function(data) 
			{
				jQuery('.calander_wrapper').html(data);
				jQuery( ".calendardetail" ).draggable({ handle: "a.movecalendar" });
			}
		});
		return false;
	
	});
	jQuery('a.showcaldetail').live('click', function(){
		jQuery(this).next('.calendardetail').show(500);
	});
	jQuery('a.closecalendar').live('click', function(){
		jQuery(this).parents('.calendardetail').hide(500);
	});
	 
});
function gm(address)
{
	if(jQuery.trim(address)!='')
	{
		jQuery('#googlemape').show(400);
		jQuery.ajax({
		url: '<?php echo get_option('home');?>/wp-content/plugins/temple/gmap.php?gnmap=sales&googleaddress='+address,
		type: 'post',
		data: '',
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
							//addInfoWindow(marker[i], addinfo[i], map);
						
						} // MAP LENGTH
					}											
					// SALES GOOGLE MAP END  //
				}	
			}	
		});
		//return false;
	}
}
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
<?php get_footer(); ?>
<!-- /FOOTER -->