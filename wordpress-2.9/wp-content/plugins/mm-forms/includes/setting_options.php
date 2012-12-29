<div id="layout_setting_options" style="margin-top:20px;">
	<div>
		<label for="mmf-rss_feed"> <?php _e('Enable RSS Feed?','mm-forms'); ?></label>
		<?php $checked = ($cf['rss_feed'] == "1" ? 'checked="checked"' : "") ?>
		<input style="width:12px;" type="checkbox" id="mmf-rss_feed" name="mmf-rss_feed" <?php echo $checked?> size="12" value="1"  />
        <div>
        <?php
            _e('NOTE: Here is your rss link for the rss subscription<br>','mm-forms');
           echo get_option('siteurl').'/?action=rss&form_id='.$_REQUEST['contactform'];
        ?>
        </div>
	</div>				
</div>