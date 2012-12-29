<div class="wrap">
<?php
if($_REQUEST['uninstall'] == '')  {
 ?>
	<h2><?php _e('MM Forms', 'mmf'); ?></h2>
	<?php 
		if ("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] != $base_url . '?page=' . $page) {
	?>
		<a href="<?php echo $base_url . '?page=' . $page; ?>" target="_self">Back to overview</a>
	<p><br /></p>
	<?php } ?>
<?php
}
?>
<?php if (isset($updated_message)) : ?>
<div id="message" class="updated fade"><p><strong><?php echo $updated_message; ?></strong></p></div>
<?php endif; ?>
<?php if ($obj_actions->view_all) :
	require_once $includes.'forms_list.php'; 
endif;
if ($cf) :
	require_once $includes.'add_edit_form.php';
endif;
if ($obj_actions->view_emails) :
	require_once $includes.'view_emails.php';
endif; 
if ($obj_actions->view_form_details) :
	require_once $includes.'details.php';
endif; ?>
</div>
