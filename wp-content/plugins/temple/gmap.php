<?php 
		$json = array();
		$address = $_REQUEST['googleaddress'];		
		if(trim($address)!='')		
		{		
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";						
			$url = str_replace('&amp;','&',$url);						
			$ch = curl_init();						
			curl_setopt($ch, CURLOPT_URL, $url);						
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);						
			$xml = curl_exec($ch);						
			curl_close ($ch); 						
			$output = json_decode($xml);
			//print_r($output);
			if(count($output->results)>0)
			{															
				$lat = $output->results[0]->geometry->location->lat;														
				$long = $output->results[0]->geometry->location->lng;					
			
				$locations[] = array('contact_detail' => $address,									
									'lat' => $lat,
									'long' => $long
									);				
				$mapaddress = array();
				$i = 0;				
				$lat = '';
				$longi = '';	
				
				foreach($locations as $location)
				{							
					$mapaddress[] = $location['contact_detail']. "@@" . $location['lat']. "@@" . $location['long'];
					$lat = $location['lat'];
					$longi = $location['long'];
				}
				
				$location_map = $mapaddress;
						
				$json['success']['map'] = $location_map;
				
				$json['success']['lat'] = $lat;
				$json['success']['longi'] = $longi;
			}
			else
			{
				$json['error']['nosalesexecutive'] = "Invalid selection.";
			}
		}		
		else
		{
			$json['error']['nosalesexecutive'] = "Invalid selection.";	
		}
		
 		print(json_encode($json));
 