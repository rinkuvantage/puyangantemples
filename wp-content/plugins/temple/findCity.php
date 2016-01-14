<?php 
require_once('../../../wp-config.php') ;

global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$district_id=$_REQUEST['district_id'];

$sql = "SELECT * FROM `".$prefix."temple_city` where district_id='$district_id'";
$cities = $wpdb->get_results($sql, OBJECT);
$city_id='';
if(isset($_REQUEST['selectedcity']))
$city_id=$_REQUEST['selectedcity'];
?>
<select name="city" class="required">
<option value="">Select City</option>
<?php foreach($cities as $city) {  ?>
<option value="<?php echo $city->id ;?>"<?php if($city_id==$city->id){echo ' selected="selected"';} ?>><?php echo $city->city ;?></option>
<?php } ?>
</select>
