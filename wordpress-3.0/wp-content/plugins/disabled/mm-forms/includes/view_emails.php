<div class="wrap" style="margin-top:20px;">
<div class="mmf" >
	<div class="link_button"><a onclick="return confirm('Are you sure you want to delete all records')" style="width:130px;" href="<?php echo $base_url . '?page=' . $page . '&action=deleteAllEmails&id='.$id ?>"><?php _e('Delete All Records') ?></a></div>
</div>
<form method="post" name="frm_emails" id="frm_emails" action="<?php echo $base_url.'?page=mm-forms/mm-forms.php&action=view&id='.$id ?>">
<table class="widefat">
  <thead>
  <tr>
<?php foreach($obj_actions->view_emails_columns as $class => $column_display_name) {
	$class = ' class="'.$class.'" ';
?>
	<th scope="col"<?php echo $class; ?>><?php echo $column_display_name; ?></th>
<?php } ?>
  </tr>
  </thead>
  <tbody class="mail_data">
  <?php //page_rows($posts);
  	if($obj_actions->emails){
		foreach($obj_actions->emails as $mail)
		{
			$class = ($mail->read_flag == 0) ? 'row_unread_email' : '';
			?>
				<tr class="<?php echo $class ?>">
					<th scope="col"><a href="<?php echo $base_url . '?page=' . $page . '&action=viewDetail&id=' . $mail->id ?>"><?php echo $mail->submit_date; ?></a></th>
					<th style="font-weight:normal;" scope="col"><?php echo $mail->client_ip; ?></th>
					<th style="font-weight:normal;" scope="col"><?php echo $mail->request_url; ?></th>
					<th style="font-weight:normal;" scope="col"><a href="<?php echo $base_url . '?page=' . $page . '&action=viewDetail&id=' . $mail->id ?>"><img src="<?php echo $image_path?>view.png" /></a></th>
					<th style="font-weight:normal;text-align:center;" scope="col">
						<a href="<?php echo $base_url . '?page=' . $page . '&action=deletemail&form_id='.$mail->fk_form_id.'&id=' . $mail->id ?>">
							<img onclick="return confirm('Are you sure you want to delete this record')" src="<?php echo $image_path.'delete.png'?>" />
						</a>
					</th>					
				</tr>
			<?php
		}
		?>
		
		<?php
	}
	else
	{
		?>
			<tr><th>No Record Found</th></tr>
		<?php
	}
   ?>
  </tbody>
</table>
<div>
<table>
<tbody>
<tr><th>
	<? $selected = ($records_per_page == '') ? 'selected="selected"' : "" ?>
	<select id="records_per_page" name="records_per_page" onchange="document.frm_emails.submit()">
		<option>Records Per Page</option>
		<option  value="10">10</option>
		<option  value="20">20</option>
		<option  value="50">50</option>
		<option  value="100">100</option>
	</select>
		<input type="hidden" id="hidden_records_per_page" name="hidden_records_per_page" value="" />	
		</th>
		<th><?php echo $obj_actions->get_pagination();?></th></tr>
</tbody>
</table>
<script type="text/javascript">
function set(id,val)
{
	val = (!val) ? 20 : val;
	ctrl = document.getElementById(id);
	len = ctrl.length;
	
	for(i=0;i<len;i++)
	{
		if(ctrl.options[i].value == val)
		{
			ctrl.options[i].selected = true;
			break;
		}
	}
}
set('records_per_page','<?php echo $records_per_page?>');
</script>
</div>
</form>
<div class="mmf" >
	<div class="link_button"><a href="javascript:history.back()"><?php _e('Back') ?></a></div>
</div>
</div>