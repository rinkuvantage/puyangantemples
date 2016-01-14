<?php 
require_once('../../../wp-config.php') ;

global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$state_id=$_REQUEST['state_id'];

$sql = "SELECT * FROM `".$prefix."temple_city` where state_id='$state_id'";
$cities = $wpdb->get_results($sql, OBJECT);
$city_id='';
if(isset($_REQUEST['city_id']))
$city_id=$_REQUEST['city_id'];
?>
<select name="city_id">
<option value="">-Select-</option>
<?php if(count($cities)>0){foreach($cities as $city) {  ?>
<option value="<?php echo $city->id ;?>"<?php if($city_id==$city->id){echo ' selected="selected"';} ?>><?php echo $city->city ;?></option>
<?php } }?>
</select>
