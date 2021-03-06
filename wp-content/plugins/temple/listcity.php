<?php 
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	
	
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
	$cnd='';
	$state_id='';
	$district_id='';
	if(isset($_REQUEST['state_id']) && trim($_REQUEST['state_id'])!='')
	{
		$state_id=$_REQUEST['state_id'];
		$cnd.=" and state_id = '$state_id'";
	}
	if(isset($_REQUEST['district_id']) && trim($_REQUEST['district_id'])!='')
	{
		$district_id=$_REQUEST['district_id'];
		$cnd.=" and district_id = '$district_id'";
	}
	
	$where=" where id!='' $cnd order by state_id";
	$querystr = "SELECT * FROM ".$prefix."temple_city $where limit $limitstart, $totalrec";
	$cities = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."temple_city $where";
	$totalphotos = $wpdb->get_results($querystr, OBJECT);
?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/temple/css/pagedesign.css" rel="stylesheet"/>
<?php $url=get_option('home').'/wp-admin/admin.php?page=TempleState'; ?>
<div class="wrap">
<div style="margin:15px;">
<?php  echo "<div style='color: #222; font-size: 1.5em; font-weight: 400; margin: 0.83em 0; float:left;'>" . __( 'Manage City', 'webserve_trdom' ) . "</div>"; ?>
<a href="<?php _e($url.'&ho=addcity&state_id='.$state_id); ?>"><div class="add-new" style="margin: 0.83em 0.5em;">Add City</div></a>
<a href="<?php _e($url.'&ho=listdistricts&state_id='.$state_id); ?>"><div class="add-new" style="margin: 0.83em 0.5em;">Manage Districts</div></a>
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
<form name="ques_form" method="post" onSubmit="return check_blank();" action="<?php echo $url; ?>">
<input type="hidden" name="quiz" value="filter" />
<div style="clear:both; height:20px;"></div>
<?php if(count($cities)>0){ ?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("State" ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("City" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php 
		$cnt=$limitstart+1; 
		foreach($cities as $city)
		{ 
		$st = Statedetail($city->state_id);
	?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($st[0]->state); ?></td>
        <td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($city->city); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<a href="<?php _e($url); ?>&ho=cityedit&id=<?php _e($city->id); ?>">View and Edit</a>&nbsp;&nbsp;
			<a href="javascript:if(confirm('Please confirm that you would like to delete this?')) {window.location='<?php _e($url); ?>&ho=citydelete&id=<?php _e($city->id); ?>';}">Delete</a>&nbsp;&nbsp;
        </td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
    <?php 
	} 
	else
	{
		echo "<strong>No City Found!</strong>" ;
	}
	?>
</form>
<?php if(count($totalphotos)>$totalrec){ ?>
<div style="float:left; margin-top:10px;" class="pagination">

<?php if($pageid>1){ ?><a href="<?php _e($url); ?>" title="First" class="fl">
<img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/first.png" alt="First" title="First" /></a><?php } ?>
    <?php $totalcities=ceil(count($totalphotos)/$totalrec);
			
			$previous = $pageid-1;
			if($previous>0)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$previous);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/previous.png" alt="Previous" title="Previous" /></a>
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
                <?php for($k=1;$k<=$totalcities;$k++){ ?>
                    <option value="<?php _e($k); ?>" <?php if($k==$pageid){ _e('selected="selected"');}?>><?php _e($k); ?></option>
                <?php } ?>
                </select>
           	</div>
			<?php
				
			
			$next = $pageid+1;
			if($totalcities>=$next)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$next);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/next.png" alt="Next" title="Next" /></a>
				<?php
			}
     ?>
     <?php if($totalcities>$pageid){ ?><a href="<?php _e($url.'&amp;pagedid='.$totalcities); ?>" title="Last" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/last.png" alt="Last" title="Last" /></a><?php } ?>

</div>
<?php } ?>
</div>

