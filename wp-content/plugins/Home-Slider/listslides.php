<?php 
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
	
	$querystr = "SELECT * FROM ".$prefix."sliders order by orderby limit $limitstart, $totalrec";
	$slides = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."sliders order by orderby";
	$totalphotos = $wpdb->get_results($querystr, OBJECT);
	
?>
<?php $url=get_option('home').'/wp-admin/admin.php?page=sliders'; ?>
<link href="<?php echo plugin_dir_url( __FILE__ );?>css/pagedesign.css" rel="stylesheet" />
<div class="wrap">
<?php    echo "<h2>" . __( 'Manage Slides', 'webserve_trdom' ) . "</h2>"; ?>
<?php if(isset($_REQUEST['del'])){if($_REQUEST['del']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Deleted successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['add'])){if($_REQUEST['add']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Added successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['update'])){if($_REQUEST['update']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Update successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['update'])){if($_REQUEST['update']=='repost'){ ?>
	<div class="updated"><p><strong><?php _e('Repost successfully.' ); ?></strong></p></div>
<?php }} ?>



<form name="conatct_form" method="post" onSubmit="return check_blank();" action="<?php echo $url; ?>">

<div style="clear:both; height:20px;"></div>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left">&nbsp;<?php _e("Sr. No." ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Title" ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Slide" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Detail"); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php $cnt=$limitstart+1; foreach($slides as $slide){ ?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($slide->title); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
        <?php if($slide->bigimage!='0'){ ?><img src="<?php echo get_option('home'); ?>/wp-content/uploads/slides/<?php echo $slide->image; ?>" width="100" alt="<?php _e($slide->title); ?>" /><?php } ?>
        </td>
        <td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($slide->detail); ?></td>
       
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<a href="<?php _e($url); ?>&ho=editslide&id=<?php _e($slide->id); ?>">Edit</a>&nbsp;&nbsp;
			<a href="<?php _e($url); ?>&ho=deleteslide&id=<?php _e($slide->id); ?>">Delete</a>
		</td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
	<input type="hidden" value="0" name="boxchecked" />
</form>
<?php if(count($totalphotos)>$totalrec){ ?>
<div style="float:left; margin-top:10px;" class="pagination">
<?php if($pageid>1){ ?><a href="<?php _e($url); ?>" title="First" class="fl"><img src="<?php echo bloginfo('template_url'); ?>/images/first.png" alt="First" title="First" /></a><?php } ?>
    <?php $totalpages=ceil(count($totalphotos)/$totalrec);
			
			$previous = $pageid-1;
			if($previous>0)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$previous);?>"><img src="<?php echo bloginfo('template_url'); ?>/images/previous.png" alt="previous" title="previous" /></a>
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
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$next);?>"><img src="<?php echo bloginfo('template_url'); ?>/images/next.png" alt="next" title="next" /></a>
				<?php
			}
     ?>
     <?php if($totalpages>$pageid){ ?><a href="<?php _e($url.'&amp;pagedid='.$totalpages); ?>" title="Last" class="fl"><img src="<?php echo bloginfo('template_url'); ?>/images/last.png" alt="Last" title="Last" /></a><?php } ?>
</div>
<?php } ?>
</div>
<script type="text/javascript">
function filter_slide()
{
	var docs=document.filterslide;
	var pages=docs.slide_filter.value;
	docs.action="<?php echo $url; ?>&slidefilter="+pages;
	docs.submit();
	
}
function check_blank()
{
	var doc=document.conatct_form;
	if(doc.selectaction.value=="")
	{
		alert("Please select Action.");
		doc.selectaction.focus();
		return false;
	}
	if(doc.boxchecked.value<=0)
	{
		alert("Please select atleast one checkbox.");
		doc.toggle.focus();
		return false;
	}
	
}

function checkAll( n, fldName ) {
  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.conatct_form;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.conatct_form.boxchecked.value = n2;
	} else {
		document.conatct_form.boxchecked.value = 0;
	}
}
function isChecked(isitchecked){
	if (isitchecked == true){
		document.conatct_form.boxchecked.value++;
	}
	else {
		document.conatct_form.boxchecked.value--;
	}
}
</script>