<?php @session_start();
global $wpdb, $current_user;
get_currentuserinfo();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<meta name="author" content="">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php if ( is_search() ) { echo " Search | ".get_option('blogname'); }else{ the_title(); ?> | <?php _e(get_option('blogname'));} ?></title>
<link rel="icon" href="<?php echo bloginfo('template_url');?>/images/favicon.ico">

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/jquery.js"></script>
<?php 

wp_head(); 
?>
<link href="<?php echo bloginfo('template_url');?>/css/style.css" rel="stylesheet" />
<!-- Bootstrap -->

<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/validate.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url');?>/css/ui-lightness/jquery-ui-1.8.18.custom.css" />
<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/tabcontent.js"></script>
<?php if(is_singular( 'temple' )){ ?>
<link href="<?php echo bloginfo('template_url');?>/css/lightbox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/lightbox.min.js"></script>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	setTimeout(function(){
	jQuery.post("<?php echo bloginfo('template_url');?>/addtocart.php", {},
	function(data) {
			jQuery('.hdr_top_right li.cart').html(data);
	});
	},1000);
	
	
	
});
</script>
</head>
<body>
<div class="header_section">
  <div class="header_top_main">
    <div class="header_top">
      <div class="hdr_top_left">
        <div class="login_box">
		<?php if(is_user_logged_in()){ 
		$uname=trim($current_user->first_name.' '.$current_user->last_name);
		if($uname=='')
		{
			$uname=$current_user->display_name;
		}
		?>
		<p>Hi! <?php _e($uname); ?></p>
          <ul>
            <li><a href="<?php echo wp_logout_url(get_option('home')); ?>">Logout</a></li>
			<li<?php if(is_page('my-account')){echo' class="active"';} ?>><a href="<?php echo get_option('home'); ?>/my-account">My Account</a></li>
			<li<?php if(is_page('my-orders')){echo' class="active"';} ?>><a href="<?php echo get_option('home'); ?>/my-orders">My Orders</a></li>
          </ul>
		<?php }else{ ?>
          <p>Welcome visitor you can </p>
          <ul>
            <li><a href="<?php echo get_option('home'); ?>/login">Login</a></li>
            <li><a href="<?php echo get_option('home'); ?>/register">Create an account</a></li>
          </ul>
		 <?php } ?>
        </div>
        <div class="social_box">
          <ul>
            <li><a href="https://twitter.com/puyangan_t"><img src="<?php echo bloginfo('template_url');?>/images/tw.png" /></a></li>
            <li><a href="https://www.facebook.com/puyangan"><img src="<?php echo bloginfo('template_url');?>/images/fb.png" /></a></li>
            <li><a href="mailto:info@puyangan.com"><img src="<?php echo bloginfo('template_url');?>/images/msg.png" /></a></li>
            <?php /*?><li class="srch"><a href="#"><img src="<?php echo bloginfo('template_url');?>/images/search.png" /></a></li><?php */?>
          </ul>
        </div>
      </div>
      <div class="hdr_top_right">
        <ul>
          <li><img src="<?php echo bloginfo('template_url');?>/images/email.png" />info@puyangan.com</li>
          <li><img src="<?php echo bloginfo('template_url');?>/images/ph.png" />+91-9944031909</li>
          <li class="cart">Shopping Cart:  0 item(s) - $0.00</li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="header_bottom_main">
    <div class="header_bottom">
      <div class="logo"><a href="<?php echo get_option('home'); ?>" title="<?php echo get_option('blogname'); ?>"><img src="<?php echo bloginfo('template_url');?>/images/logo.png" /></a></div>
      <div class="main_menu">
	  <?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'container'=>false, 'items_wrap' => '<ul>%3$s</ul>' ) ); ?>
      </div>
      <div class="clr"></div>
    </div>
  </div>
</div>
<?php if(get_option('page_on_front')==$post->ID && !is_search()){ ?>
<div class="banner_section"> <?php echo do_shortcode('[layerslider id="1"]'); ?> </div>
<?php } ?>