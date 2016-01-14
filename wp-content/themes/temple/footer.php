<div class="footer_main_block">
  <div class="footer_mid">
  <div class="f_top">
  <?php if ( is_active_sidebar( 'footer_1' ) ) : ?>
    <div class="f_block">
      <?php dynamic_sidebar( 'footer_1' ); ?>
      <div class="clr"></div>
    </div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'footer_2' ) || is_active_sidebar( 'footer_3' ) ) : ?>
    <div class="f_block">
      <?php dynamic_sidebar( 'footer_2' ); ?>
      <div class="cnt_addr">
        <?php dynamic_sidebar( 'footer_3' ); ?>
      </div>
	  <div class="clr" style="margin-top:10px;"></div>
		 <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=temples.puyangan.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/temples.puyangan.com"/></a>
    </div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'footer_4' ) ) : ?>
    <div class="f_block">
		<?php dynamic_sidebar( 'footer_4' ); ?>
		
		</div>
	<?php endif; ?>
	  
      </div>
    <div class="clr"></div>
    <div class="footer_bottom">
      <p class="cpy">copyright &copy; <?php echo date('Y'); ?> Right Reserved, <a class="puy" href="http://www.puyangan.com">Puyangan Travels</a></p>
	  <?php wp_nav_menu( array( 'theme_location' => 'footermenu', 'container'=>false, 'items_wrap' => '<ul class="f_links">%3$s</ul>' ) ); ?>
	  <script type="text/javascript">
	  	jQuery(document).ready(function(){
			jQuery('ul.f_links li:last a').addClass('careers');
			jQuery('ul.f_links li:nth-child(9) a').addClass('careers');
		});
	  </script>
    </div>
  </div>
  <div class="clr"></div>
</div>
</div>
</div>
	<?php wp_footer(); ?>
	<!-- ClickDesk Live Chat Service for websites -->
<script type='text/javascript'>
var _glc =_glc || []; _glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyDwsSBXVzZXJzGJ-XnZAIDA');
var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 
'http://my.clickdesk.com/clickdesk-ui/browser/');
var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');
var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; 
glcspt.async = true; glcspt.src = glcpath + 'livechat-new.js';
var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);
</script>
<!-- End of ClickDesk -->
  </body>
</html>