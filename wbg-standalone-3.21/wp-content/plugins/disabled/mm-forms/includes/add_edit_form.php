<div class="wrap relative" style="margin-top:15px;">
	<!--<div class="form_tab_header" style="border:1px solid black;">-->
	<div id="form_tabs">
		<ul id="form_tab_container">
			<li id="form_fields_tab" class="<?php echo ($tab == 'fo') ? 'current' : '' ?>" style="margin-left: 1px"><a href="#" onclick="show_tab('form_fields_tab','form_tab_container','fo_tab','eo_tab,mo_tab,so_tab')" title="<?php _e('FORM OPTIONS') ?>"><?php _e('FORM OPTIONS') ?></a></li>
			<li id="mail_options_tab"><a href="#" onclick="show_tab('mail_options_tab','form_tab_container','mo_tab','fo_tab,eo_tab')" title="<?php _e('Mail Options') ?>"><?php _e('Mail Options') ?></a></li>
			<li id="export_options_tab" class="<?php echo ($tab == 'eo') ? 'current' : '' ?>"><a href="#" onclick="show_tab('export_options_tab','form_tab_container','eo_tab','fo_tab,mo_tab,so_tab')" title="<?php _e('Export Options') ?>"><?php _e('Export Options') ?></a></li>
            <li id="settings_options_tab" class="<?php echo ($tab == 'se') ? 'current' : '' ?>"><a href="#" onclick="show_tab('settings_options_tab','form_tab_container','so_tab','eo_tab,fo_tab,mo_tab')" title="<?php _e('More Settings') ?>"><?php _e('More Setting') ?></a></li>
		</ul>
	</div>		
	<!--</div>-->
		<div style="width:98.7%;padding-left:10px;float:left;margin-top:0px;border:1px solid black;">
		<form method="post" action="<?php echo $base_url . '?page=' . $page . '&contactform=' . $current; ?>" id="mmf-admin-form-element">
			<div id="fo_tab" style="margin-top:20px;" class="<?php echo ($tab=='fo') ? 'current_tab' : 'inactive_tab'?>">
				<?php wp_nonce_field('mmf-save_' . $current); ?>
				<input type="hidden" id="mmf-id" name="mmf-id" value="<?php echo $current; ?>" />
				<label class="form_name" for="mmf-title">Form Name : 
				<input type="text" id="mmf-title" name="mmf-title" size="40" value="<?php echo htmlspecialchars($cf['title']); ?>" />
				</label>
		
				<div class="cfdiv">
					<?php if (! $unsaved) : ?>
					<p class="tagcode">
					<?php _e('Copy and paste this code into your post content.', 'mmf'); ?><br />
					<input type="text" id="form-anchor-text" onfocus="this.select();" readonly="readonly" />
					</p>
					<?php endif; ?>
		
					<div class="fieldset" id="form-content-fieldset"><div class="legend"><?php _e('Form', 'mmf'); ?></div>
						<textarea id="mmf-form" name="mmf-form" cols="100" rows="16"><?php echo htmlspecialchars($cf['form']); ?></textarea>
					</div>
					<div style="padding:0px 0 10px 0;text-decoration:underline"><b>Form Handling</b></div>					
					<div>
					<?php $checked = ($cf['mail']['save_data'] == "1") ? 'checked="checked"' : "" ?>
					<label for="mmf-save_data">Save to Database and Mail</label>
					<input type="radio" id="mmf-save_data" name="mmf-save_data" value="1" <?php echo $checked?> />
					
                    <?php $checked = ($cf['mail']['save_data'] == "0") ? 'checked="checked"' : "" ?>

					<label for="mmf-send_mail" style="margin-left:20px;">Mail only</label>
					<input type="radio" id="mmf-send_mail" name="mmf-save_data" <?php echo $checked?> value="0" />
                   
                   <?php $checked = ($cf['mail']['save_data'] == "2") ? 'checked="checked"' : "" ?>
                    <label for="mmf-onlysave_data" style="margin-left:20px;">Database only</label>
					<input type="radio" id="mmf-onlysave_data" name="mmf-save_data" <?php echo $checked?> value="2" />
					</div>
					<br />
					<div style="padding:0px 0 10px 0;text-decoration:underline"><b>Mail format</b></div>					
					<div>
					<?php
						$checked = ($cf['mail']['mail_format'] == 'html') ? "checked" : "" 
					?>
					<label for="mmf-html-emails">Send mails in html</label>&nbsp;
					<input type="checkbox" id="mmf-mail_format" name="mmf-mail_format" <?php echo $checked?> value="html" />						
					</div>		
			 </div>
		 </div>
		<div id="mo_tab" style="display:none;border:1px solid #FFFFFF;">
		<div class="fieldset"><div class="legend"><?php _e('Mail', 'mmf'); ?></div>
			<div class="mail-field">
				<label for="mmf-mail-recipient"><?php _e('To:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-recipient" name="mmf-mail-recipient" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail']['recipient']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-sender"><?php _e('From:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-sender" name="mmf-mail-sender" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail']['sender']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-subject"><?php _e('Subject:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-subject" name="mmf-mail-subject" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail']['subject']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-body"><?php _e('Message body:', 'mmf'); ?></label><br />
				<textarea id="mmf-mail-body" name="mmf-mail-body" cols="100" rows="16"><?php echo htmlspecialchars($cf['mail']['body']); ?></textarea>
			</div>
		</div>

		<div class="fieldset"><div class="legend"><?php _e('Mail (2)', 'mmf'); ?></div>
			<input type="checkbox" id="mmf-mail-2-active" name="mmf-mail-2-active" value="1"<?php echo ($cf['mail_2']['active']) ? ' checked="checked"' : ''; ?> />
			<label for="mmf-mail-2-active"><?php _e('Use mail (2)', 'mmf'); ?></label>
			<div class="mail-field">
				<label for="mmf-mail-2-recipient"><?php _e('To:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-2-recipient" name="mmf-mail-2-recipient" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail_2']['recipient']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-2-bcc"><?php _e('Bcc:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-2-bcc" name="mmf-mail-2-bcc" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail_2']['bcc']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-2-sender"><?php _e('From:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-2-sender" name="mmf-mail-2-sender" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail_2']['sender']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-2-subject"><?php _e('Subject:', 'mmf'); ?></label><br />
				<input type="text" id="mmf-mail-2-subject" name="mmf-mail-2-subject" class="wide" size="70" value="<?php echo htmlspecialchars($cf['mail_2']['subject']); ?>" />
			</div>
			<div class="mail-field">
				<label for="mmf-mail-2-body"><?php _e('Message body:', 'mmf'); ?></label><br />
				<textarea id="mmf-mail-2-body" name="mmf-mail-2-body" cols="100" rows="16"><?php echo htmlspecialchars($cf['mail_2']['body']); ?></textarea>
			</div>
		</div>
		<input type="hidden" id="mmf-options-recipient" name="mmf-options-recipient" value="<?php echo htmlspecialchars($cf['options']['recipient']); ?>" />
	</div>
	
	<div id="eo_tab" class="<?php echo ($tab =='eo') ? 'current_tab' : 'inactive_tab'?>">
		<?php require_once $includes.'export_options.php'; ?>
	</div>

    <div id="so_tab" class="<?php echo ($tab =='so') ? 'current_tab' : 'inactive_tab'?>">
		<?php require_once $includes.'setting_options.php'; ?>
	</div>
	
	<p class="submit" style="border:none;">
		<input type="submit" class="cfsave" style="float:right;" name="mmf-save" value="<?php _e('Save', 'mmf'); ?>" />
	</p>
	</form>
	</div>
</div>
