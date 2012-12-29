<div id="layout_export_options" style="margin-top:20px;">
	<div>
		<label for="mmf-form_fields">Export fields for csv file </label>
		<input type="text" id="mmf-form_fields" name="mmf-form_fields" value="<?php echo htmlspecialchars($cf['form_fields']); ?>" />
		<label style="margin-left:10px;">(e.g name, subject, email)</label>
	</div>
    <div>
     <label > &nbsp;</label>
     <?php $checked = ($cf['all_form_fields'] ? 'checked="checked"' : "") ?>
     <input style="width:12px;" type="checkbox" id="mmf-all_form_fields" name="mmf-all_form_fields" <?php echo $checked?> size="12" value="1" onclick=" if(document.getElementById('mmf-all_form_fields').checked == 1) document.getElementById('mmf-form_fields').value=''"  />
        <label style="margin-left:10px;" for="mmf-all_form_fields">Export All fields</label>
    </div>
	<div>
		<label for="mmf-csv_separator">Separator for CSV export </label>
		<input type="text" id="mmf-csv_separator" name="mmf-csv_separator" value="<?php echo htmlspecialchars($cf['csv_separator']); ?>" />
		<label style="margin-left:10px;width:auto;">(separator to be used for csv file e.g comma)</label>
	</div>
	<div>
		<label for="mmf-export_form_ids">Export Submit ID's </label>
		<?php $checked = ($cf['export_form_ids'] == "1" ? 'checked="checked"' : "") ?>
		<input style="width:12px;" type="checkbox" id="mmf-export_form_ids" name="mmf-export_form_ids" <?php echo $checked?> size="12" value="1"  />	
	<label style="margin-left:10px;width:auto;">Do you want Form's ID to be exported with csv file?</label>
	</div>				
</div>