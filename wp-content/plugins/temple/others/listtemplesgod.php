<?php 
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
	$where="order by id";
	$querystr = "SELECT * FROM ".$prefix."temple_templesgod $where limit $limitstart, $totalrec";
	$templesgod = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."temple_templesgod $where";
	$totalphotos = $wpdb->get_results($querystr, OBJECT);
?>
<style type="text/css">
table td,table th{padding:5px;}
.pagination{ float:left; line-height:30px; font-size:14px; font-weight:bold;}
.pagination span{background:#f6f6f6; color:#000; padding:0px 10px; text-decoration:underline;}
.pagination a{background:#FFFFFF color:#0000FF; padding:0px 10px; text-decoration:none;}
.pagination a:hover{text-decoration:underline;}
ul.config{	padding:10px;	margin:0px;}
ul.config li{	display:inline;	float:left;	padding:0px 10px;}
ul.config li a{	text-decoration:none;	color:#000066;}
ul.config li a:hover, ul.config li a.active{	text-decoration:underline;	color:#990000;}
.clr{clear:both;}
.fl{float:left;}
.fr{float:right;}
.add-new
{
	padding:3px;
	background:#999;
	color:#fff;
	display:inline-block;
	font-weight:bold;
}
</style>
<?php $url=get_option('home').'/wp-admin/admin.php?page=ManageTemplesGod'; ?>
<div class="wrap">
<div style="margin:15px;">
<?php  echo "<div style='color: #222; font-size: 1.5em; font-weight: 400; margin: 0.83em 0; float:left;'>" . __( 'Manage Temples God', 'webserve_trdom' ) . "</div>"; ?>
<a href="<?php _e(get_option('home')); ?>/wp-admin/admin.php?page=AddTemplesGod"><div class="add-new" style="margin: 0.83em 0.5em;">Add Temples God</div></a>
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
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Temple" ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("God" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php 
		$cnt=$limitstart+1; 
		foreach($templesgod as $tempsgod)
		{ 
			$templeid = $tempsgod->temple_id ;
			$temple = templedetail($templeid);
			$temple_name = $temple[0]->temple; 
			
			$godid = $tempsgod->god_id ;
			$god = goddetail($godid);
			$god_name = $god[0]->god; 
	?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($temple_name); ?></td>
        <td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($god_name); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<!--<a href="<?php /*_e($url);*/ ?>&ho=cityedit&id=<?php /*_e($city->id);*/ ?>">View and Edit</a>&nbsp;&nbsp;-->
			<a href="javascript:if(confirm('Please confirm that you would like to delete this case?')) {window.location='<?php _e($url); ?>&ho=TemplesGoddelete&id=<?php _e($tempsgod->id); ?>';}">Delete</a>&nbsp;&nbsp;
        </td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
</form>
<?php if(count($totalphotos)>$totalrec){ ?>
<div style="float:left; margin-top:10px;" class="pagination">

<?php if($pageid>1){ ?><a href="<?php _e($url); ?>" title="First" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/first.png" alt="First" title="First" /></a><?php } ?>
    <?php $totalpages=ceil(count($totalphotos)/$totalrec);
			
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
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$next);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/next.png" alt="Next" title="Next" /></a>
				<?php
			}
     ?>
     <?php if($totalpages>$pageid){ ?><a href="<?php _e($url.'&amp;pagedid='.$totalpages); ?>" title="Last" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/quiz-contest/images/last.png" alt="Last" title="Last" /></a><?php } ?>

</div>
<?php } ?>
</div>