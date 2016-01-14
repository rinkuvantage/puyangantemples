<!-- HEADER-->
<?php @session_start();
global $post;

get_header();
$page_id=get_option('page_for_posts');
$page2 = get_post($page_id);
  ?>
<!-- /HEADER  --> 
<!-- HEADER TITLE-->
<?php if (have_posts()) : 	?>

<div id="sub-header" class="layout-full has-background">
  <div class="meta-header" style="">
    <div class="limit-wrapper">
      <div class="meta-header-inside">
        <header class="page-header ">
          <div class="page-header-content">
          	<?php if ( function_exists('yoast_breadcrumb') ) {
					  yoast_breadcrumb('<p id="breadcrumbs" style="width:100%;">','</p>');
				} ?>
            <h1 style=""> <span class="title"><?php _e($thiscat->name); ?></span> </h1>
          </div>
        </header>
      </div>
    </div>
  </div>
</div>

<!-- /HEADER TITLE--> 

<!-- CONTAINER WRAPPER-->
<div id="main" role="main" class="wpv-main layout-full" style="padding-top:0px !important;">
  <div class="limit-wrapper">
  
  <?php	while (have_posts()) : the_post();  ?>
    <div class="row page-wrapper">
      <article>
        <div class="page-content loop-wrapper clearfix full category-content">
          <div class="post-article has-image-wrapper ">
            <div class="standard-post-format clearfix as-image ">
              <div class="post-row">
                <div class="post-row-left">
                  <div class="post-date"> <span class="top-part"> <?php echo date('d',strtotime($post->post_date)); ?> </span> <span class="bottom-part"> <?php echo date("m 'y",strtotime($post->post_date)); ?></span> </div>
                </div>
                <div class="post-row-center">
                <?php if ( has_post_thumbnail() ) {
					echo'<div class="post-media"><div class="media-inner">';
					echo get_the_post_thumbnail($post->ID, array(600,500));
					echo '</div></div>';
				} ?>
                  <div class="post-content-outer">
                    <header class="single">
                      <div class="content">
                        <h3><a href="<?php echo get_permalink($post->ID); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                      </div>
                    </header>
                    <div class="post-content the-content">
                      <?php the_excerpt(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </article>
    </div>
   <?php endwhile;?>
  </div>
  <!-- .limit-wrapper -->
</div>

<?php endif; ?>

<!-- FOOTER -->
<?php get_footer(); ?>
<!-- /FOOTER -->