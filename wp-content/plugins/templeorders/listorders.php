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
	
	$where=" order by order_id desc";
	$querystr = "SELECT * FROM ".$prefix."orders $where limit $limitstart, $totalrec";
	$orders = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."orders $where";
	$totalphotos = $wpdb->get_results($querystr, OBJECT);
?>
<link href="<?php echo get_option('home');?>/wp-content/plugins/templeorders/css/pagedesign.css" rel="stylesheet" />
<?php $url=get_option('home').'/wp-admin/admin.php?page=Orders'; ?>
<div class="wrap">
<div style="margin:15px;">
<?php  echo "<div style='color: #222; font-size: 1.5em; font-weight: 400; margin: 0.83em 0; float:left;'>" . __( 'Manage Orders', 'webserve_trdom' ) . "</div>"; ?>

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
<?php if(count($orders)>0){ ?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Order Id" ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("User Name" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Email" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Date and Time" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Status" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php 
		$cnt=$limitstart+1; 
		foreach($orders as $order)
		{ 
			$user_id=$order->user_id;
			$userdata=get_userdata( $user_id );
			$email=$userdata->user_email ;	
			$username=$userdata->first_name.' '.$userdata->last_name;
	?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($order->order_id); ?></td>
        <td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($username); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($email); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo date('jS F Y h:i A',strtotime($order->cdate)); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php echo orderstatus($order->order_status); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<a href="<?php _e($url); ?>&ho=editorder&id=<?php _e($order->order_id); ?>">View and Edit</a>&nbsp;&nbsp;
			<a href="javascript:if(confirm('Please confirm that you would like to delete this?')) {window.location='<?php _e($url); ?>&ho=deleteorder&id=<?php _e($order->order_id); ?>';}">Delete</a>&nbsp;&nbsp;
        </td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
    <?php 
	} 
	else
	{
		echo "<strong>No Order Found!</strong>" ;
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