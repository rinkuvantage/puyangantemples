<?php session_start();
/*
Plugin Name: Site Settings
Plugin URI: http://www.vantagewebtech.com
Description: This is Site Settings plugin
Author: Rinku Kamboj
Version: 443.0
Author URI: http://www.vantagewebtech.com
*/


//*************** Admin function ***************

//this function is used for checking login details

function include_SiteSettingss()
{
	$page='listSite Settingss';
	if(isset($_REQUEST['ven']) && trim($_REQUEST['ven'])!=''){$page=$_REQUEST['ven'];}
	switch($page)
	{
		case 'listSite Settingss':
		include('listsitesettings.php');
		break;
	}
}

function SiteSettings_admin_actions() {
	add_menu_page("Site Settings", "Site Settings", 1, "SiteSettings", "include_SiteSettingss");
}


add_action('admin_menu', 'SiteSettings_admin_actions');

?>
