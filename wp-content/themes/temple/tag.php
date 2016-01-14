<!-- HEADER-->
<?php @session_start();
global $post, $wp_query;
$thiscat = $wp_query->get_queried_object();
$page_id=get_option('page_for_posts');
$page = get_post($page_id); 
get_header();  ?>
<!-- /HEADER  --> 
<!-- HEADER TITLE-->
<?php if (have_posts()) : 	?>

<div class="Header-title-main hd-tt-mr">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h1><?php _e(single_tag_title()); ?></h1>
      </div>
      <?php 
	  $order_now_page = stripslashes(get_option('order_now_page'));
	  $quick_quote_page = stripslashes(get_option('quick_quote_page'));
	   ?>
      <div class="col-lg-6 btn_inr_hd al_rg"> <a href="<?php if(trim($order_now_page)!=''){_e(get_permalink($order_now_page));}else{ ?>javascript:;<?php } ?>" class="btn btn-lg btn-success btn-clr"><img src="<?php echo bloginfo('template_url');?>/images/lock_small.png" alt=""><span>ORDER NOW</span> </a> <a href="<?php if(trim($quick_quote_page)!=''){_e(get_permalink($quick_quote_page));}else{ ?>javascript:;<?php } ?>" class="btn btn-lg btn-success btn-clr1 mr_nn"><img src="<?php echo bloginfo('template_url');?>/images/note-small.png" alt=""><span>QUICK QUOTE </span></a> </div>
    </div>
    <?php if ( tag_description() ) : // Show an optional tag description ?>
        <p><?php echo tag_description(); ?><</p>
    <?php endif; ?>
    
  </div>
</div>

<!-- /HEADER TITLE--> 

<!-- CONTAINER WRAPPER-->
<section id="container-wrap">
<div class="box-shd">
  <div class="container"> 
    
    <!-- BREADCRUMB -->
    <ul class="breadcrumb">
      <li><a href="<?php echo get_option('home'); ?>">Home</a></li>
      <li class="active"><?php _e(single_tag_title()); ?></li>
    </ul>
    <!-- /BREADCRUMB --> 
    
    <!-- CONTENT -->
    
    <?php if($_SESSION['message']!=''){?><div class="clr"></div><div class="status" style="margin-top:10px;"><?php echo $_SESSION['message'];$_SESSION['message']=''; }?>
    <div class="col-lg-9 content">
      <h2><?php _e($thiscat->name); ?></h2>
      <?php	while (have_posts()) : the_post(); ?>
           <h2><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
          <div class="meta-tag"><span class="name"><?php _e(get_the_author()); ?></span> | <?php the_date('d M Y'); ?></div>
          <div class="postcmt"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment or question', 'twentytwelve' ) . '</span>', __( '1 Comment / Leave a comment or question', 'twentytwelve' ), __( '% Comments / Leave a comment or question', 'twentytwelve' ) ); ?></div>
			<?php endwhile;?>
             
    </div>
    <!-- /CONTENT --> 
    
    <!-- 	RIGHT SIDEBAR -->
	<?php get_sidebar('blog'); ?>
    <!-- /RIGHT SIDEBAR --> 
    
  </div>
</div>
</div>
</section>
<?php else : ?>
		
			<h2 align="center">Not Found</h2>
		
			<p align="center">Sorry, but you are looking for something that isn't here.</p>
		
		<?php endif; ?>
<!-- CONTAINER WRAPPER --> 

<!-- FOOTER -->
<?php get_footer(); ?>
<!-- /FOOTER -->