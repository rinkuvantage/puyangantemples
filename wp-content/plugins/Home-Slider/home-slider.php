<?php session_start();
/*
Plugin Name: Slider
Plugin URI: http://www.vantagewebtech.com
Description: This is Home Slider plugin
Author: Rinku Kamboj
Version: 143420.0
Author URI: http://www.vantagewebtech.com
*/


//*************** Admin function ***************

//this function is used for checking login details

	
if(!isset($_REQUEST['ho']) || ($_REQUEST['ho']=='Manage_temples1') )
{
	function Manage_sliders1() {
		include('listslides.php');
	}
}
if(isset($_REQUEST['ho']))
{
	$page=$_REQUEST['ho'];
	switch($page)
	{
		
		case 'editslide':
		function includesetting_files() {
			include('editslide.php');
		}
		break;
		case 'deleteslide':
		function includesetting_files() {
			include('deleteslide.php');
		}
		break;
	}
	function manageslider_actions33() {
		add_menu_page("Slider", "Manage Slides", 1, "sliders", "includesetting_files");
		add_submenu_page( 'sliders', 'Add Slide', 'Add Slide', '1',  'AddSlide', 'add_slide' );
	}
	add_action('admin_menu', 'manageslider_actions33');
}

function manageslider_admin_actions() {
	add_menu_page("Slider", "Manage Slides", 1, "sliders", "Manage_sliders1");
	add_submenu_page( 'sliders', 'Add Slide', 'Add Slide', '1',  'AddSlide', 'add_slide' );
}
function add_slide()
{
	include('addslide.php');
}
if(!isset($_REQUEST['ho']) )
{
	add_action('admin_menu', 'manageslider_admin_actions');
}

function sliders($id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($id!='')
	{
		$cond.=" and id='$id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr = "SELECT * FROM ".$prefix."sliders where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function showslider($attr)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$slides=sliders(''," order by id desc");
	$data='';
	if(count($slides)>0)
	{	
		?>
		<link href="<?php echo plugin_dir_url( __FILE__ );?>css/jquery.bxslider.css.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/jquery.bxslider.js"></script>
		<style type="text/css">
			.fullwidthslider{width:100%; height:100%; position:relative;}
			.detail{position:absolute; left:40%; bottom:10%;}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.bxslider').bxSlider({
				  adaptiveHeight: true,
				  mode: 'fade',
				  auto: true,
				  speed: 2000
				});
			});
		</script>
		<?php
		$data.='<div class="fullwidthslider"><ul class="bxslider">';
		foreach($slides as $slide)
		{
			$link='';
			if(trim($slide->link)!='')
			{
				$link='<div class="goto"><a href="'.$slide->link.'" title="'.$slide->title.'">></a></div>';
			}
			$data.='<li>
						<img src="'.get_option('home').'/wp-content/uploads/slides/'.$slide->image.'" alt="" />
						<div class="detail">
							<div classe="caption">
								<div class="title">'.$slide->title.'</div>
								<div class="clear clr"></div>
								<div class="title">'.$slide->detail.'</div>
							</div>'.$link.'
						</div>
					</li>';
		}
		$data.='</ul></div>';
	}
	return $data;
}
add_shortcode('Slider', 'showslider');
function slider_direc_install() {
   global $wpdb;
   //global $product_db_version;

$sql14 = "CREATE TABLE `".$wpdb->prefix."sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `detail` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `link` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `orderby` int(11) DEFAULT 0,
  `active` int(2) DEFAULT 1,
  PRIMARY KEY (`id`)
)";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   dbDelta($sql14);
}

register_activation_hook(__FILE__,'slider_direc_install');
?>
