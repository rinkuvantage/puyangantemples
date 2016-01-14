<?php 
global $wpdb,$currency_symbal;
$prefix=$wpdb->base_prefix;
$paypalid=get_option( 'paypalid' );
$payumerchantkey=get_option( 'payumerchantkey' );
$paypalmode=get_option( 'paypalmode' );
$payusalt=get_option( 'payusalt' );
$payumode=get_option( 'payumode' );
$curconversion=get_option( 'curconversion' );

$paypalapiid=get_option( 'paypalapiid' );
$paypalapipwd=get_option( 'paypalapipwd' );
$paypalapisig=get_option( 'paypalapisig' );
if(isset($_POST['savedata']))
{
	$paypalid=$_POST['paypalid'];
	if ( get_option( 'paypalid' ) !== false ) {
		update_option( 'paypalid', $paypalid );
	} else {
		add_option( 'paypalid', $paypalid, '', 'yes' );
	}
	
	$paypalapiid=$_POST['paypalapiid'];
	if ( get_option( 'paypalapiid' ) !== false ) {
		update_option( 'paypalapiid', $paypalapiid );
	} else {
		add_option( 'paypalapiid', $paypalapiid, '', 'yes' );
	}
	
	$paypalapipwd=$_POST['paypalapipwd'];
	if ( get_option( 'paypalapipwd' ) !== false ) {
		update_option( 'paypalapipwd', $paypalapipwd );
	} else {
		add_option( 'paypalapipwd', $paypalapipwd, '', 'yes' );
	}
	
	$paypalapisig=$_POST['paypalapisig'];
	if ( get_option( 'paypalapisig' ) !== false ) {
		update_option( 'paypalapisig', $paypalapisig );
	} else {
		add_option( 'paypalapisig', $paypalapisig, '', 'yes' );
	}
	
	$payumerchantkey=$_POST['payumerchantkey'];
	if ( get_option( 'payumerchantkey' ) !== false ) {
		update_option( 'payumerchantkey', $payumerchantkey );
	} else {
		add_option( 'payumerchantkey', $payumerchantkey, '', 'yes' );
	}
	
	$paypalmode=$_POST['paypalmode'];
	if ( get_option( 'paypalmode' ) !== false ) {
		update_option( 'paypalmode', $paypalmode );
	} else {
		add_option( 'paypalmode', $paypalmode, '', 'yes' );
	}
	
	$payusalt=$_POST['payusalt'];
	if ( get_option( 'payusalt' ) !== false ) {
		update_option( 'payusalt', $payusalt );
	} else {
		add_option( 'payusalt', $payusalt, '', 'yes' );
	}
	
	$payumode=$_POST['payumode'];
	if ( get_option( 'payumode' ) !== false ) {
		update_option( 'payumode', $payumode );
	} else {
		add_option( 'payumode', $payumode, '', 'yes' );
	}
	
	$curconversion=$_POST['curconversion'];
	if ( get_option( 'curconversion' ) !== false ) {
		update_option( 'curconversion', $curconversion );
	} else {
		add_option( 'curconversion', $curconversion, '', 'yes' );
	}
	
	$url=get_option('home').'/wp-admin/admin.php?page=SiteSettings&update=succ';
	echo"<script>window.location='".$url."'</script>";
	
}
?>
<div class="wrap">
<?php    echo "<h2>" . __( 'Site Settings', 'webserve_trdom' ) . "</h2>"; ?>
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
<link href="<?php echo plugin_dir_url( __FILE__ );?>/css/pagedesign.css" rel="stylesheet"/>


<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#register_spcialist").validate();
});

</script>

	  <form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
		<?php if(count($error)>0)
	  { ?>
	<div class="tabletitle"><span class="error">Error</span></div>
        <table width="700" class="from_main" border="0" cellpadding="5" cellspacing="5">
          <?php 
           
            for($i=0;$i<count($error);$i++)
            {
                ?>
              <tr>
                <td align="left" valign="top" class="name"><span class="error"><?php echo $error[$i]; ?></span></td>
            </tr>
    <?php	} ?>
        </table>
    <div class="clr mt20"></div>
    <?php } ?>
	<div class="clr"></div>
    <table class="from_main" border="0" cellpadding="5" cellspacing="5">
		<tr>
        	<td align="left" valign="top" class="name" width="200">Paypal Id :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="paypalid" value="<?php _e($paypalid); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name" width="200">Paypal API Id :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="paypalapiid" value="<?php _e($paypalapiid); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name" width="200">Paypal API Password :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="paypalapipwd" value="<?php _e($paypalapipwd); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name" width="200">Paypal API Signature :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="paypalapisig" value="<?php _e($paypalapisig); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name" width="200">Paypal Mode :*</td>
            <td align="left" valign="top" class="field" colspan="3">
				<select name="paypalmode">
					<option value="test"<?php if($paypalmode=='test'){_e(' selected="selected"');} ?>>Test</option>
					<option value="live"<?php if($paypalmode=='live'){_e(' selected="selected"');} ?>>Live</option>
				</select>
			</td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Payumoney Merchant Key :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="payumerchantkey" value="<?php _e($payumerchantkey); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Payumoney Salt :*</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required" name="payusalt" value="<?php _e($payusalt); ?>" /></td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name" width="200">Payumoney Mode :*</td>
            <td align="left" valign="top" class="field" colspan="3">
				<select name="payumode">
					<option value="test"<?php if($payumode=='test'){_e(' selected="selected"');} ?>>Test</option>
					<option value="live"<?php if($payumode=='live'){_e(' selected="selected"');} ?>>Live</option>
				</select>
			</td>
        </tr>
		<tr>
        	<td align="left" valign="top" class="name">Currency Conversion for <?php echo $currency_symbal; ?> in RS</td>
            <td align="left" valign="top" class="field" colspan="3"><input type="text" class="required number" name="curconversion" value="<?php _e($curconversion); ?>" /></td>
        </tr>
    	<tr>
        	<td align="left" valign="top" class="name">&nbsp;</td>
            <td align="left" valign="top" class="field" colspan="3">
            	<input type="submit" name="savedata" value="Save" title="Save" style="width:100px; background:#CCCCCC;" />
            </td>
        </tr>
    </table>
		</form>
