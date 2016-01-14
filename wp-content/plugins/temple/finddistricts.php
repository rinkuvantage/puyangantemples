<?php 
require_once('../../../wp-config.php') ;

global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$state_id=$_REQUEST['state_id'];

$districts=Districtdetail(''," and state_id='$state_id'");


$district_id='';
if(isset($_REQUEST['selecteddistrict']))
$district_id=$_REQUEST['selecteddistrict'];
?>
<select class="required" name="district_id" id="district_id">
<option value="">Select District</option>
<?php foreach($districts as $district) {  ?>
<option value="<?php echo $district->id ;?>"<?php if($district_id==$district->id){echo ' selected="selected"';} ?>><?php echo $district->district ;?></option>
<?php } ?>
</select>
