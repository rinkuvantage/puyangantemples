<!-- HEADER-->
<?php @session_start();
global $post;
//print_r($post);

get_header();  ?>
<!-- /HEADER  --> 
<!-- HEADER TITLE-->
<?php if (have_posts()) : 	?>
<div id="sub-header" class="layout-full has-background">
  <div class="meta-header" style="">
    <div class="limit-wrapper">
      <div class="meta-header-inside">
        <header class="page-header has-buttons">
		<?php if ( function_exists('yoast_breadcrumb') ) {
					  yoast_breadcrumb('<p id="breadcrumbs" style="width:100%;">','</p>');
				} ?>
          <div class="page-header-content">
          	
            <h1 style=""> <span class="title"><h1><?php the_title(); ?></h1></span> </h1>
             </div>
        </header>
      </div>
    </div>
  </div>
</div>
<?php	while (have_posts()) : the_post(); ?>
<div id="main" role="main" class="wpv-main layout-full" style="padding-top:0px !important;">
  <div class="limit-wrapper">
    <div class="row page-wrapper" style="padding-top:40px;">
      <article class="post type-post status-publish format-standard has-post-thumbnail hentry category-health-information tag-quotes single-post-wrapper full">
        <div class="page-content loop-wrapper clearfix full">
          <div class="has-image-wrapper single">
            <div class="standard-post-format clearfix as-image ">
            	<div class="post-content-outer single-post">
              	<?php if ( has_post_thumbnail() ) {
					echo'<div class="post-media"><div class="media-inner">';
					the_post_thumbnail('full');
					echo '</div></div>';
				} ?>
                
                <div class="post-content the-content">
                  <div class="push" style='height:20px'></div>
                 <?php the_content(); ?>
                  <!--<div class="push" style='height:20px'></div>
                  
                  <div class="clearfix share-btns">
                    <div class="sep-3"></div>
                    <ul class="socialcount" data-url="<?php _e(get_permalink()); ?>" data-share-text="Eat Healthy Food to Stay Fit" data-media="">
                      <li class="facebook"> <a href="https://www.facebook.com/sharer/sharer.php?u=<?php _e(get_permalink()); ?>" title="Share on Facebook"> <span class='icon shortcode  ' style=''>&#58155;</span> <span class="count">Like</span> </a> </li>
                       
                      <li class="twitter"> <a href="https://twitter.com/intent/tweet?text=<?php _e(get_permalink()); ?>" title="Share on Twitter"> <span class='icon shortcode  ' style=''>&#58159;</span> <span class="count">Tweet</span> </a> </li>
                       
                      <li class="googleplus"> <a href="https://plus.google.com/share?url=<?php _e(get_permalink()); ?>" title="Share on Google Plus"> <span class='icon shortcode  ' style=''>&#58150;</span> <span class="count">+1</span> </a> </li>
                       
                      <li class="pinterest"> <a href="<?php _e(get_permalink()); ?>" title="Share on Pinterest"> <span class='icon shortcode' style=''>&#58216;</span> <span class="count">Pin it</span> </a> </li>
                       
                    </ul>
                  </div>-->
                </div>
              </div>
            </div>
          </div>
          <div class="clearboth">
            <div id="comments">
            	<?php comments_template( '', true ); ?>
              
               
              
              <!-- .respond-box -->
            </div>
            <!-- #comments -->
          </div>
        </div>
      </article>
    </div>
  </div>
  <!-- .limit-wrapper -->
</div>

<?php endwhile;?>
<?php else : ?>
		
			<h2 align="center">Not Found</h2>
		
			<p align="center">Sorry, but you are looking for something that isn't here.</p>
		
		<?php endif; ?>
<!-- CONTAINER WRAPPER --> 

<!-- FOOTER -->
<?php get_footer(); ?>
<!-- /FOOTER -->