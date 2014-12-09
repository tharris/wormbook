<?php
/**
* Main options page include
*
* @since 2.1
* @lastupdate 2.8
*
*
*/
?>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>WP-CMS Post Control Publishing Controls</h2>

	<h3><a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol'); ?>" title="Main post control options">Post Control</a> | <a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol_ex'); ?>" title="Core WordPress publishing functions">Core Functions</a></h3>

	<form method="post" action="options.php">
		<?php
		//Output nonce, action, and option_page fields for a settings page
		// @param string $option_group A settings group name. IMPORTANT - This should match the group name used in register_setting()
		settings_fields('wpcms_pcontrol_options');
		?>

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
		</p>

		<?php $options = get_option('wpcms_pcontrolopts'); ?>

		<div id="icon-themes" class="icon32"><br /></div>
		<h2>Page Controls</h2>
		<p>Check option <strong>to hide page controls </strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>
		<p>Page creation and editing is only available to administrator and editor level users.</p>


		<table class="form-table">

			<?php
			$mypagecontrols = array(
			'Attributes' => 'pageparentdiv',
			'Author (ONLY if multiple)' => 'authordiv',
			'Custom Fields' => 'postcustom',
			'Discussion' => 'commentstatusdiv',
			'Comments' => 'commentsdiv',
			'Featured Image' => 'postimagediv',
			'Slug' => 'slugdiv',
			'Revisions' => 'revisionsdiv'
			);

			//Generate form from array
			foreach($mypagecontrols as $key => $value) { ?>

			<tr>
				<th scope="row"><?php echo $key; ?></th>
				<td>
				<fieldset>
				<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_page_administrator]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_page_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_page_administrator'])) {
						checked(''.$value.'', $options[''.$value.'_page_administrator']);
					}
					?>
					 />
					Administrator
					</label>



					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_page_editor]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_page_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_page_editor'])) {
						checked(''.$value.'', $options[''.$value.'_page_editor']);
					}
					?>
					 />
					Editor
					</label>

				</fieldset></td>
			</tr>

			<?php
			}
			?>

		</table>


		<div id="icon-themes" class="icon32"><br /></div>
		<h2>Post Controls</h2>
		<p>Check option <strong>to hide post controls </strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>

		<table class="form-table">

			<?php
			$mypostcontrols = array(
			'Author (if multiple)' => 'authordiv',
			'Categories' => 'categorydiv',
			'Comments' => 'commentsdiv',
			'Custom fields' => 'postcustom',
			'Discussion' => 'commentstatusdiv',
			'Excerpt' => 'postexcerpt',
			'Featured Image' => 'postimagediv',
			'Format' => 'formatdiv',
			'Revisions' => 'revisionsdiv',
			'Slug' => 'slugdiv',
			'Tags' => 'tagsdiv-post_tag',
			'Trackbacks' => 'trackbacksdiv'
			);

			//Generate form from array
			foreach($mypostcontrols as $key => $value) { ?>

			<tr>
				<th scope="row"><?php echo $key; ?></th>
				<td>
				<fieldset>
				<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_administrator]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_post_administrator'])) {
						checked(''.$value.'', $options[''.$value.'_post_administrator']);
					}
					?>
					 />
					Administrator
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_editor]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_post_editor'])) {
						checked(''.$value.'', $options[''.$value.'_post_editor']);
					}
					?>
					 />
					Editor
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_author]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_author]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_post_author'])) {
						checked(''.$value.'', $options[''.$value.'_post_author']);
					}
					?>
					 />
					Author
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_contributor]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_contributor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_post_contributor'])) {
						checked(''.$value.'', $options[''.$value.'_post_contributor']);
					}
					?>
					 />
					Contributor
					</label>

				</fieldset></td>
			</tr>

			<?php
			}
			?>

		</table>


		<div id="icon-tools" class="icon32"><br /></div>
		<h2>Advanced Controls</h2>
		<p>These options apply <strong>to all edit screens</strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>

		<table class="form-table">

			<?php
			$mywpcorecontrols = array(
			'Remove media upload' => 'media_buttons',
			'Remove word count' => 'word_count'
			);

			//Generate form from array
			foreach($mywpcorecontrols as $key => $value) { ?>

			<tr>
				<th scope="row"><?php echo $key; ?></th>
				<td>
				<fieldset>
				<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_administrator]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_wpcore_administrator'])) {
						checked(''.$value.'', $options[''.$value.'_wpcore_administrator']);
					}
					?>
					 />
					Administrator
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_editor]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_wpcore_editor'])) {
						checked(''.$value.'', $options[''.$value.'_wpcore_editor']);
					}
					?>
					 />
					Editor
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_author]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_author]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_wpcore_author'])) {
						checked(''.$value.'', $options[''.$value.'_wpcore_author']);
					}
					?>
					 />
					Author
					</label>

					<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_contributor]">
					<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_contributor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>"
					<?php
					if (isset($options[''.$value.'_wpcore_contributor'])) {
						checked(''.$value.'', $options[''.$value.'_wpcore_contributor']);
					}
					?>
					 />
					Contributor
					</label>

				</fieldset></td>
			</tr>

			<?php
			}
			?>

		</table>


		<?php /*
		DONT NEED THIS ANY MORE WITH WPCORE settings_fields()
		<input type="hidden" name="wpcms_pcontrol_nonce" value="<?php echo wp_create_nonce('wpcms_pcontrol_nonce'); ?>" />
		*/
		?>

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
		</p>

	</form>

<?php include("wp-cms-opts-pcontrol-common.php"); ?>

</div>