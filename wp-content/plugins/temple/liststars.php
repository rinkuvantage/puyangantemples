<?php if(!isset($_REQUEST['ho']) )
{ 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$blog_id = $wpdb->blogid;
	
	$totalrec=20;
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
	
	
	$where=" order by star";
	$querystr = "SELECT * FROM ".$prefix."temple_stars $where limit $limitstart, $totalrec";
	$states = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."temple_stars $where";
	$totalstates = $wpdb->get_results($querystr, OBJECT);
?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet"/>
<?php $url=get_option('home').'/wp-admin/admin.php?page=ManageStars'; ?>
<div class="wrap">
<div style="margin:15px;">
<?php  echo "<div style='color: #222; font-size: 1.5em; font-weight: 400; margin: 0.83em 0; float:left;'>" . __( 'Manage Stars', 'webserve_trdom' ) . "</div>"; ?>
<a href="<?php _e(get_option('home')); ?>/wp-admin/admin.php?page=AddStar"><div class="add-new" style="margin: 0.83em 0.5em;">Add Star</div></a>
</div>

<div class="clr"></div>
<?php if(isset($_REQUEST['del'])){if($_REQUEST['del']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Deleted successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['add'])){if($_REQUEST['add']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Added successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['update'])){if($_REQUEST['update']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Update successfully.' ); ?></strong></p></div>
<?php }} ?>
<div class="clr"></div>
<form name="conatct_form" method="post" onSubmit="return check_blank();" action="<?php echo $url; ?>">
<input type="hidden" name="ho" value="filter" />
<div style="clear:both; height:20px;"></div>
<?php if(count($states)>0){ ?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Star" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php $cnt=$limitstart+1; foreach($states as $st){ ?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($st->star); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<a href="<?php _e($url); ?>&ho=editstar&id=<?php _e($st->id); ?>">View and Edit</a>&nbsp;&nbsp;
			<a href="javascript:if(confirm('Please confirm that you would like to delete this?')) {window.location='<?php _e($url); ?>&ho=deletestar&id=<?php _e($st->id); ?>';}">Delete</a>
		</td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
 <?php 
	} 
	else
	{
		echo "<strong>No Star Found!</strong>" ;
	}
	?>    
</form>
<?php if(count($totalstates)>$totalrec){ ?>
<div style="float:left; margin-top:10px;" class="pagination">

<?php if($pageid>1){ ?><a href="<?php _e($url); ?>" title="First" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/tempele-dir/images/first.png" alt="First" title="First" /></a><?php } ?>
    <?php $totalpages=ceil(count($totalstates)/$totalrec);
			
			$previous = $pageid-1;
			if($previous>0)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$previous);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/tempele-dir/images/previous.png" alt="Previous" title="Previous" /></a>
				<?php
			}
			?>
            <div class="fl ml5 mr10">Page Number:</div>
            <div class="fl mr5">
            	<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready( function(){
						jQuery('#paginate').live('change', function(){
							var pagedid=jQuery(this).val();
							window.location='<?php _e($url); ?>&pagedid='+pagedid;
						});
					})
					//]]>
				</script>
                <select style="float:left;" id="paginate" name="pagedid">
                <?php for($k=1;$k<=$totalpages;$k++){ ?>
                    <option value="<?php _e($k); ?>" <?php if($k==$pageid){ _e('selected="selected"');}?>><?php _e($k); ?></option>
                <?php } ?>
                </select>
           	</div>
			<?php
				
			
			$next = $pageid+1;
			if($totalpages>=$next)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$next);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/temple/images/next.png" alt="Next" title="Next" /></a>
				<?php
			}
     ?>
     <?php if($totalpages>$pageid){ ?><a href="<?php _e($url.'&amp;pagedid='.$totalpages); ?>" title="Last" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/temple/images/last.png" alt="Last" title="Last" /></a><?php } ?>

</div>
<?php } ?>
</div>

<?php } ?>