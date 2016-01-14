<?php 
@session_start();

/*

Plugin Name: Temple

Plugin URI: http://www.vantagewebtech.com

Description: Temple Directory features such as Temples listings, Packages, Online Bookings, managed pages such as Astrology  etc.,

Author: Priyanka Chhabra

Version: 10.6.14

Author URI: http://www.vantagewebtech.com

*/
//*************** Admin function ***************
//this function is used for checking login details

global $currency, $currency_symbal, $countries;
$currency='USD';
$currency_symbal='$';
$countries=array('India');
if(!isset($_REQUEST['ho']) || ($_REQUEST['ho']=='Manage_temples1') )
{
	function Manage_temples1() {
		include('listtemple.php');
	}
}
if(isset($_REQUEST['ho']))
{
	$page=$_REQUEST['ho'];
	switch($page)
	{
		case 'templeedit':
		function includesetting_files() {
			include('edittemple.php');
		}
		break;
		case 'templedelete':
		function includesetting_files() {
			include('deletetemple.php');
		}
		break;
		case 'stateedit':
		function includesetting_files() {
			include('editstate.php');
		}
		break;
		case 'statedelete':
		function includesetting_files() {
			include('deletestate.php');
		}
		break;
		case 'cityedit':
		function includesetting_files() {
			include('editcity.php');
		}
		break;
		case 'citydelete':
		function includesetting_files() {
			include('deletecity.php');
		}
		break;
		
		case 'godedit':
		function includesetting_files() {
			include('editgod.php');
		}
		break;
		case 'goddelete':
		function includesetting_files() {
			include('deletegod.php');
		}
		break;
		case 'addpackage':
		function includesetting_files() {
			include('addpackage.php');
		}
		break;
		case 'editpackage':
		function includesetting_files() {
			include('editpackage.php');
		}
		break;
		case 'deletepackage':
		function includesetting_files() {
			include('deletepackage.php');
		}
		break;
		case 'listpackages':
		function includesetting_files() {
			include('listpackages.php');
		}
		break;
		
		case 'editpackagetype':
		function includesetting_files() {
			include('editpackagetype.php');
		}
		break;
		case 'deletepackagetype':
		function includesetting_files() {
			include('deletepackagetype.php');
		}
		break;
		case 'addgallery':
		function includesetting_files() {
			include('addgallery.php');
		}
		break;
		case 'editgallery':
		function includesetting_files() {
			include('editgallery.php');
		}
		break;
		case 'deletegallery':
		function includesetting_files() {
			include('deletegallery.php');
		}
		break;
		case 'listgallery':
		function includesetting_files() {
			include('listgallery.php');
		}
		break;
		
		case 'addcalendar':
		function includesetting_files() {
			include('addcalendar.php');
		}
		break;
		case 'editcalendar':
		function includesetting_files() {
			include('editcalendar.php');
		}
		break;
		case 'deletecalendar':
		function includesetting_files() {
			include('deletecalendar.php');
		}
		break;
		case 'listcalendar':
		function includesetting_files() {
			include('listcalendar.php');
		}
		break;
		case 'listcity':
		function includesetting_files() {
			include('listcity.php');
		}
		break;
		case 'addcity':
		function includesetting_files() {
			include('addcity.php');
		}
		break;
		
		case 'listdistricts':
		function includesetting_files() {
			include('listdistricts.php');
		}
		break;
		case 'adddistrict':
		function includesetting_files() {
			include('adddistrict.php');
		}
		break;
		case 'editdistrict':
		function includesetting_files() {
			include('editdistrict.php');
		}
		break;
		case 'deletedistrict':
		function includesetting_files() {
			include('deletedistrict.php');
		}
		break;
		case 'editstar':
		function includesetting_files() {
			include('editstar.php');
		}
		break;
		case 'deletestar':
		function includesetting_files() {
			include('deletestar.php');
		}
		break;
		case 'editcategory':
		function includesetting_files() {
			include('editcategory.php');
		}
		break;
		case 'deletecategory':
		function includesetting_files() {
			include('deletecategory.php');
		}
		break;
	}
	function manageTemple_temple_actions33() {
		add_menu_page("Temples", "Manage Temples", 1, "Temples", "includesetting_files");
		add_submenu_page( 'Temples', 'Add Temple', 'Add Temple', '1',  'AddTemple', 'add_temple' );
		add_submenu_page("Temples", "Manage State", "Manage State", 1, "TempleState", "includesetting_files");
	    add_submenu_page( 'Temples', 'Add State', 'Add State', '1',  'AddState', 'offstate1' );
		add_submenu_page("Temples", "Manage Categories", "Manage Categories", 1, "ManageCategories", "includesetting_files");
		add_submenu_page("Temples", "Add Category", "Add Category", 1, "AddCategory", "addcategory");
		add_submenu_page("Temples", "Manage Stars", "Manage Stars", 1, "ManageStars", "includesetting_files");
		add_submenu_page("Temples", "Add Star", "Add Star", 1, "AddStar", "addStar");
		add_submenu_page("Temples", "Manage God/Lord", "Manage God/Lord", 1, "ManageGod", "includesetting_files");
		add_submenu_page("Temples", "Add God/Lord", "Add God/Lord", 1, "AddGod", "addgod1");
		add_submenu_page("Temples", "Manage Packages", "Manage Packages", 1, "ManagePackages", "includesetting_files");
		add_submenu_page("Temples", "Add Package Type", "Add Package Type", 1, "AddPackage", "addpackage");
	}
	add_action('admin_menu', 'manageTemple_temple_actions33');
}


/* Manage Menu */

function manageTemple_admin_actions() {
	
	add_menu_page("Temples", "Manage Temples", 1, "Temples", "Manage_temples1");
	add_submenu_page( 'Temples', 'Add Temple', 'Add Temple', '1',  'AddTemple', 'add_temple' );
	add_submenu_page("Temples", "Manage State", "Manage State", 1, "TempleState", "Managetemple_state1");
	add_submenu_page( 'Temples', 'Add State', 'Add State', '1',  'AddState', 'offstate1' );
	add_submenu_page("Temples", "Manage Categories", "Manage Categories", 1, "ManageCategories", "listcategory");
	add_submenu_page("Temples", "Add Category", "Add Category", 1, "AddCategory", "addcategory");
	add_submenu_page("Temples", "Manage Stars", "Manage Stars", 1, "ManageStars", "liststar");
	add_submenu_page("Temples", "Add Star", "Add Star", 1, "AddStar", "addstar");
	add_submenu_page("Temples", "Manage God/Lord", "Manage God/Lord", 1, "ManageGod", "listgod1");
	add_submenu_page("Temples", "Add God/Lord", "Add God/Lord", 1, "AddGod", "addgod1");
	add_submenu_page("Temples", "Manage Packages", "Manage Packages", 1, "ManagePackages", "listpackages");
	add_submenu_page("Temples", "Add Package Type", "Add Package Type", 1, "AddPackage", "addpackage");
}
if(!isset($_REQUEST['ho']) )
{
	add_action('admin_menu', 'manageTemple_admin_actions');
}

function Managetemple_state1() {
	include('liststate.php');
}
function offstate1()
{
	include('addstate.php');
}
function add_temple()
{
	include('addtemple.php');
}
function listcategory() {
	include('listcategories.php');
}
function addcategory()
{
	include('addcategory.php');
}

function liststar() {
	include('liststars.php');
}
function addstar()
{
	include('addstar.php');
}
/* Start Manage God */
function listgod1()
{
	include('listgod.php');
}
function addgod1()
{
	include('addgod.php');
}
/* End Manage God */
function listpackages()
{
	include('listpackagetypes.php');
}
function addpackage()
{
	include('addpackagetype.php');
}

/* Start Manage Temples */
function listtemplesgod1()
{
	include('listtemplesgod.php');
}
function addtemplesgod()
{
	include('addtemplesgod.php');
}
/* End Manage Temples */

function Statedetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_state where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function Stardetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_stars where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function categorydetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_categories where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function Citydetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_city where id!='' $cond";
	$data1 = $wpdb->get_results($querystr, OBJECT);
	return $data1;
}
function Districtdetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_districts where id!='' $cond";
	$data1 = $wpdb->get_results($querystr, OBJECT);
	return $data1;
}
function packagedetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_packages where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function packagetypedetail($id='', $cnd='')
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
	$querystr = "SELECT * FROM ".$prefix."temple_package_types where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function templeprices($temple_id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($temple_id!='')
	{
		$cond.=" and temple_id='$temple_id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr = "SELECT * FROM ".$prefix."temple_package_price where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function goddetail($id='', $cnd='')
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
	$querystr2 = "SELECT * FROM ".$prefix."temple_god where id!='' $cond";
	$data2 = $wpdb->get_results($querystr2, OBJECT);
	return $data2;
}



function TempGodDetail($id='', $cnd='')
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
	$querystr3 = "SELECT * FROM ".$prefix."temple_templesgod where id!='' $cond";
	$data3 = $wpdb->get_results($querystr3, OBJECT);
	return $data3;
}
function Templeoption($temple_id='', $field='', $update=false)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($temple_id!='')
	{
		$cond.=" and temple_id='$temple_id'";
	}
	if($field!='')
	{
		$cond.=" and option_key='$field'";
		$querystr3 = "SELECT option_value FROM ".$prefix."temple_options where id!='' $cond";
		$data3 = $wpdb->get_results($querystr3, OBJECT);
		if(empty($data3) && $update)
		{
			return '-0';
		}
		else
		{
			return $data3[0]->option_value;
		}
	}
	else
	{
		$querystr3 = "SELECT * FROM ".$prefix."temple_options where id!='' $cond";
		$data3 = $wpdb->get_results($querystr3, OBJECT);
		return $data3;
	}
	
}

function updatetempleoption($temple_id, $field, $value)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$templeoption=Templeoption($temple_id, $field, true);
	if($templeoption=='-0')
	{
		$sql="INSERT INTO `".$prefix."temple_options` (`temple_id`, `option_key`, `option_value`) VALUES ('$temple_id', '$field', '$value')"; 
		$result = $wpdb->query( $sql );
	}
	else
	{
		$sql="UPDATE `".$prefix."temple_options` set option_value='$value' where temple_id='$temple_id' and option_key='$field'"; 
		$result = $wpdb->query( $sql );
	}
}

function templedetail($id='', $cnd='')
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
	$querystr4 = "SELECT * FROM ".$prefix."temple_temples where id!='' $cond";
	$data4 = $wpdb->get_results($querystr4, OBJECT);
	return $data4;
}
function totalcategorytemples($category_id)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$querystr4 = "SELECT count(*) as total FROM ".$prefix."temple_temples where category_id='$category_id'";
	$data4 = $wpdb->get_results($querystr4, OBJECT);
	return $data4[0]->total;
}
function templegallery($temple_id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($temple_id!='')
	{
		$cond.=" and temple_id='$temple_id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr4 = "SELECT * FROM ".$prefix."temple_gallery_images where id!='' $cond";
	$data4 = $wpdb->get_results($querystr4, OBJECT);
	return $data4;
}
function templecalendar($temple_id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($temple_id!='')
	{
		$cond.=" and temple_id='$temple_id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr4 = "SELECT * FROM ".$prefix."temple_calendar where id!='' $cond";
	$data4 = $wpdb->get_results($querystr4, OBJECT);
	return $data4;
}
function nearbytemples($lat='',$long='',$distance='',$cnd='',$limitstart='',$limitend='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if(trim($cnd)!='')
	{
		$cond.=$cnd;
	}
	$limit=" LIMIT $limitstart , $limitend";
	if(trim($limitstart)=='')
	{
		$limit="";
	}
	$querystr = "SELECT *, ( 3959 * ACOS( COS( RADIANS($lat) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS($long) ) + SIN( RADIANS($lat) ) * SIN( RADIANS( latitude ) ) ) ) AS distance FROM ".$prefix."temple_temples HAVING distance < $distance $cond ORDER BY distance $limit";
	$data= $wpdb->get_results($querystr, OBJECT);
	return $data;
}
function countries($cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$querystr4 = "SELECT * FROM ".$prefix."country where id!='' $cnd";
	$data4 = $wpdb->get_results($querystr4, OBJECT);
	return $data4;
}
// Short Code
function home_page_temples($attr='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	
	$show=6;
	if(isset($attr['show']) && trim($attr['show'])>0)
	{
		$show=$attr['show'];
	}
	$temples = templedetail('', 'order by id desc limit 0, '.$show);
	
	$data='';
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box">';
				  
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
	}
	return $data;
}
add_shortcode('Home Page Temple', 'home_page_temples');

function ten_temples($district_id)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$totalrec=10;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	$cnd=" and district_id='$district_id' order by id desc";
	$temples = templedetail('', $cnd." limit $limitstart, $totalrec");
	
	$querystr = "SELECT count(*) as total FROM ".$prefix."temple_temples where id!='' $cnd";
	$total = $wpdb->get_results($querystr, OBJECT);
	
	$data='';
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box district_temples">';
				  
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
		if($total[0]->total>count($temples))
		{
			$url=get_permalink().'?dist='.$district_id.'&amp;pagedid=';
			$data.=pagination($totalrec,$pageid,$url,$total[0]->total);
		}
	}
	return $data;
}
function star_temples($star_id)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	
	$totalrec=10;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	$cnd=" and star_id='$star_id' order by id desc";
	$temples = templedetail('', $cnd." limit $limitstart, $totalrec");
	
	$querystr = "SELECT count(*) as total FROM ".$prefix."temple_temples where id!='' $cnd";
	$total = $wpdb->get_results($querystr, OBJECT);
	
	$data='';
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box god_temples">';
				  
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
		if($total[0]->total>count($temples))
		{
			$url=get_permalink().'?star='.$star_id.'&amp;pagedid=';
			$data.=pagination($totalrec,$pageid,$url,$total[0]->total);
		}
	}
	return $data;
}
function category_temples($category_id)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$totalrec=10;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	
	if(trim($category_id)!='')
		$cnd=" and category_id='$category_id' order by id desc";
	else
		$cnd=" and category_id>0 order by id desc";
	$data='';
	$temples = templedetail('', $cnd." limit $limitstart, $totalrec");
	$querystr = "SELECT count(*) as total FROM ".$prefix."temple_temples where id!='' $cnd";
	$total = $wpdb->get_results($querystr, OBJECT);
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box god_temples">';
				  
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
		if($total[0]->total>count($temples))
		{
			$url=get_permalink().'?cid='.$category_id.'&amp;pagedid=';
			$data.=pagination($totalrec,$pageid,$url,$total[0]->total);
		}
	}
	return $data;
}
function search_temples($cnd='',$searchlink='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$totalrec=10;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	
	
	$where="where id!='' $cnd";
	$querystr4 = "SELECT * FROM ".$prefix."temple_temples  $where limit $limitstart, $totalrec";
	$temples = $wpdb->get_results($querystr4, OBJECT);
	
	$querystr = "SELECT count(*) as total FROM ".$prefix."temple_temples $where";
	$total = $wpdb->get_results($querystr, OBJECT);
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box god_temples">';
				  
				 if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
		if($total[0]->total>count($temples))
		{
			$url=get_permalink().'?s='.$srchtext.$searchlink.'&amp;pagedid=';
			$data.=pagination($totalrec,$pageid,$url,$total[0]->total);
		}
	}
	return $data;
}
function package_temples($package_type_id)
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$totalrec=10;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	if(trim($package_type_id)!='')
	{
		$cnd="where g.temple_id=t.id and g.package_type_id='$package_type_id' group by t.id order by t.id desc";
	}
	else
	{
		$cnd="where g.temple_id=t.id group by t.id order by t.id desc";
	}
	$querystr = "SELECT t.* FROM ".$prefix."temple_temples as t,".$prefix."temple_package_price as g $cnd limit $limitstart, $totalrec";
	$temples = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."temple_temples as t,".$prefix."temple_package_price as g $cnd";
	$total = $wpdb->get_results($querystr, OBJECT);
	
	$data='';
	if(count($temples)>0)
	{
		foreach($temples as $temple)
		{
		   $image = $temple->image ;
		   $data.='<div class="mid_temple_box god_temples">';
				  
				  if(trim($image)!='' && file_exists('wp-content/uploads/temples/thumb/'.$image)){
				  $imagepath=get_option('home').'/wp-content/uploads/temples/thumb/'.$image;
				  $data.='<div class="tpl_img">
				   <a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'"><img src="'.$imagepath.'" width="194" alt="'.$temple->name.'" /></a>
				  </div>';
				  }
				 $data.='<div class="tpl_cnt_box">
					<h2><a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">'.$temple->name.'</a></h2>
					<h3>'.date('F d.Y', strtotime($temple->add_date)).'</h3>
					<p>'.$temple->general_info.'</p>
					<a href="'.get_permalink($temple->post_id).'" title="'.$temple->name.'">More...</a> </div>
				</div>';
		}
		if(count($total)>count($temples))
		{
			$url=get_permalink().'?pid='.$package_type_id.'&amp;pagedid=';
			$data.=pagination($totalrec,$pageid,$url,count($total));
		}
	}
	return $data;
}
//[Temple]*/

function temple_init() {
    $args = array(
      'public' => true,
	  'label'  => 'Temple',
	  'rewrite' => array( 'slug' => 'temple' )
    );
    register_post_type( 'temple', $args );
	flush_rewrite_rules();
}
add_action( 'init', 'temple_init' );

function temple_remove_menu_items() {
        remove_menu_page( 'edit.php?post_type=temple' );
}
add_action( 'admin_menu', 'temple_remove_menu_items' );

function tem_direc_install() {
   global $wpdb;
   //global $product_db_version;


$sql = "CREATE TABLE `".$wpdb->prefix."temple_state` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
   
$sql1 = "CREATE TABLE `".$wpdb->prefix."temple_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `city` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

$sql2 = "CREATE TABLE `".$wpdb->prefix."temple_god` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `god` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

$sql3 = "CREATE TABLE `".$wpdb->prefix."temple_templesgod` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `god_id` int(10) NOT NULL,
  `temple_id` int(10) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

$sql4 = "CREATE TABLE `".$wpdb->prefix."temple_temples` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT 0,
  `state_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `inthetemple` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `openinghours` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `googleaddress` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `general_info` longtext CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `heighlight` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `latitude` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `longitude` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `nearrailway` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `nearairport` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `accomodation` longtext CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `star_id` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
)";


$sql5 = "CREATE TABLE `".$wpdb->prefix."temple_package_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `package_type` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

$sql6 = "CREATE TABLE `".$wpdb->prefix."temple_packages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `package_type_id` int(10) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `short_desc` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql7 = "CREATE TABLE `".$wpdb->prefix."temple_package_price` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `temple_id` int(10) NOT NULL,
  `package_id` int(10) NOT NULL,
  `package_type_id` int(10) NOT NULL,
  `price` float DEFAULT 0,
  `add_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql8 = "CREATE TABLE `".$wpdb->prefix."temple_calendar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `temple_id` int(10) NOT NULL,
  `temple_id` int(10) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `special` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `worship` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

$sql9 = "CREATE TABLE `".$wpdb->prefix."temple_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `temple_id` int(10) NOT NULL,
  `option_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 0,
  `option_value` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql10 = "CREATE TABLE `".$wpdb->prefix."temple_gallery_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `temple_id` int(10) NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql11 = "CREATE TABLE `".$wpdb->prefix."temple_districts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state_id` int(10) NOT NULL,
  `district` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql12 = "CREATE TABLE `".$wpdb->prefix."temple_stars` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `star` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";
$sql13 = "CREATE TABLE `".$wpdb->prefix."temple_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `orderby` int(10) DEFAULT 0,
  `showcount` tinyint(1) DEFAULT 0,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
   dbDelta($sql1);
   dbDelta($sql2);
   dbDelta($sql3);
   dbDelta($sql4);
   dbDelta($sql5);
   dbDelta($sql6);
   dbDelta($sql7);
   dbDelta($sql8);
   dbDelta($sql9);
   dbDelta($sql10);
   dbDelta($sql11);
   dbDelta($sql12);
   dbDelta($sql13);
   
}


register_activation_hook(__FILE__,'tem_direc_install');
?>