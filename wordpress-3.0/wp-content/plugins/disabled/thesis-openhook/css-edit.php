<?php
/**
 * custom.css editing page for the Thesis OpenHook Plugin
 *
 * http://rickbeckman.org/thesis-openhook/
 * Copyright 2009 Rick Beckman  (email: rick.beckman@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

/**
 * Prevent unauthorized access to this file.
 */
if (!current_user_can('edit_themes'))
	wp_die(__('You are not authorized to access Thesis OpenHook.', 'thesis_openhook'));


# custom.css location
$filename = THESIS_CUSTOM . '/custom.css';


/**
 * Write new custom.css, if required.
 *
 * @since 2.2
 */
if (!empty($_POST)) {
	if (isset($_POST['custom_css'])) {
		# Get custom.css new content
		$contents = stripslashes($_POST['custom_css']);

		if (is_writable($filename)) {
			# Open custom.css
			$custom_css = fopen($filename, 'w+');

			# If possible, write new custom.css
			if ($custom_css !== false)
				fwrite($custom_css, $contents);

			# Close custom.css
			fclose($custom_css);
		}
	}

	echo '<div id="message" class="updated fade"><p><strong>' . __('Thesis customizations have been saved. You should now check your site to ensure everything is working as expected, and thank you for using Thesis with OpenHook!') . '</strong></p></div>' . "\n";
}

/**
 * Get custom.css content for display
 *
 * @since 2.2
 */
if (!is_file($filename))
	$error = 1;
if (!$error && filesize($filename) > 0) {
	$custom_css = fopen($filename, 'r');
	$content = fread($custom_css, filesize($filename));
	$content = htmlspecialchars($content);
}

/**
 * Handle save button text.
 */
$save_button = attribute_escape(get_option('openhook_save_button'));
if ($save_button == '')
	$save_button = __('Little Ass Save Button', 'thesis_openhook');
?>

<div class="wrap">
<?php screen_icon(); ?>
	<h2><?php _e('Thesis OpenHook custom.css Editor', 'thesis_openhook'); ?></h2>

	<form method="post" action="">
		<div class="hidden">
			<?php settings_fields('thesis_openhook'); ?>
		</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><h3 id="custom_style"><?php _e('Custom Stylesheet', 'thesis_openhook'); ?></h3></th>
				<td>
					<fieldset>
						<legend class="hidden"><code>custom.css</code></legend>
						<p><label for="custom.css"><?php _e('<strong>By editing this, you are physically modifying your Thesis <code>custom.css</code> file.</strong> Use caution, and make sure you have a backup in case you need it! Also, it goes without saying that <strong>only <abbr title="Cascading Style Sheets">CSS</abbr></strong> can be used in this box!', 'thesis_openhook'); ?></label></p>
						<textarea id="custom_css" name="custom_css" rows="25" cols="50" class="large-text code"><?php echo stripslashes($content); ?></textarea>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
		</table>
	</form>
</div>