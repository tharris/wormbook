<div class="wrap" style="margin-top:20px;">
<table class="widefat" style="width:600px;">
  <thead>
  <tr>
<?php foreach($obj_actions->detail_info_columns as $class => $column_display_name) {
	$class = ' class="'.$class.'" ';
?>
	<th scope="col"<?php echo $class; ?>><?php echo $column_display_name; ?></th>
<?php } ?>
  </tr>
  </thead>
  <tbody class="mail_data">
  <?php //page_rows($posts);
  	if($obj_actions->form_fields){
		foreach($obj_actions->form_fields as $field)
		{
			?>
				<tr>
					<th scope="col"><?php echo $field->form_key ?></th>
					<th style="font-weight:normal;" scope="col">
					<?php 
						switch ($field->form_key) {
							case "page_post_id": 
								echo $field->value . " - <a href='" . get_bloginfo('url') . "/wp-admin/post.php?action=edit&post=" . $field->value ."'>" . get_the_title($field->value) . "</a>";
								break;
							case "user_ID":
								$user_info = get_userdata($field->value);
								echo "<a href='" . get_bloginfo('url') . "/wp-admin/user-edit.php?user_id=" .$field->value . "'>" . $user_info->user_login . "</a>";
								break;
							default:
								echo $field->value ;
								break;
						}
/*						if ($field->form_key == 'page_post_id') {
							echo $field->value . " - <a href='" . get_bloginfo('url') . "/wp-admin/post.php?action=edit&post=" . $field->value ."'>" . get_the_title($field->value) . "</a>";
						} else {
							echo $field->value; 
						}*/
					?>
					</th>
				</tr>
			<?
		}
	}
	else
	{
		?>
			<tr><th>No Record Found</th></tr>
		<?
	}
   ?>
  </tbody>
</table>
<div class="mmf" >
	<div class="link_button"><a href="javascript:history.back()"><?php _e('Back') ?></a></div>
</div>
</div>
