<?php
/**
* Core functions options page include
*
* @since 2.1
* @lastupdate 2.9
*
*
*/
?>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>WP-CMS Post Control Core Functions</h2>

	<h3><a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol'); ?>" title="Main post control options">Post Control</a> | <a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol_ex'); ?>" title="Core WordPress publishing functions">Core Functions</a></h3>

	<div id="icon-tools" class="icon32"><br /></div>
	<h2>Core WordPress publishing functions</h2>
	<p>Use these controls to configure the core publishing behaviour of WordPress.</p>
	<p><strong>Disable autosave</strong> - Stops this interpution when you are writing content.</p>
	<p><strong>Disable revisions</strong> - Stops more post revisions being saved - existing revisions will be kept.</p>

	<form method="post" action="options.php">
		<?php

		$options = get_option('wpcms_pcontrolopts_ex');
		//Output nonce, action, and option_page fields for a settings page
		// @param string $option_group A settings group name. IMPORTANT - This should match the group name used in register_setting()
		settings_fields('wpcms_pcontrol_options_ex');
		?>

		<table class="form-table">

			<?php
			$mypagecontrols = array(
			'Disable Autosave' => 'autosave',
			'Disable Revisions' => 'revisions'
			);

			//Generate form from array
			foreach($mypagecontrols as $key => $value) { ?>

			<tr>
				<th scope="row"><?php echo $key; ?></th>
				<td>
				<fieldset>
				<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>

					<label for="wpcms_pcontrolopts_ex_autosave">

					<input name="wpcms_pcontrolopts_ex[<?php echo $value; ?>]" type="checkbox" value="off"
					<?php
					if (isset($options[''.$value.''])) {
						checked('off', $options[''.$value.'']);
					}
					?>
					/>

					</label>

				</fieldset>
				</td>
			</tr>

			<?php
			}
			?>

		</table>

		<div id="icon-tools" class="icon32"><br /></div>
		<h2>Limit revisions</h2>

		<?php if (!isset($options['revisions'])) { ?>

			<p>Stop clogging up your database and revisions system by setting a maximum number of revisions to be saved.</p>
			<p>NOTE: This doesn't remove existing revisions!</p>

			<table class="form-table">

				<tr>
					<th scope="row">How many revisions to save</th>
					<td>

				<select name="wpcms_pcontrolopts_ex[revision_num]" id="asave">
					<option value="<?php echo $options['revision_num']; ?>">
					<?php

					if (!isset($options['revision_num'])) {
						echo 'No limit';
					} else {

						//Setup nice display of saved value
						if ($options['revision_num'] == '0' || !$options['revision_num']) {
							echo "No limit";
						} else {
							echo $options['revision_num'];
							if ($options['revision_num'] == '1') { echo ' revision'; } else { echo ' revisions'; }
						}

					}
					 ?>
					</option>


					<?php
					$i = 0;
					do {
					    echo '<option class="level-'.$i.'" value="'.$i.'">'.$i.'</option>';
					    $i++;
					} while ($i < 51);
					?>
					<option class="level-0" value="0">No limit</option>
				</select>

					</td>
				</tr>

			</table>

		<?php } else { ?>

			<p><strong>You currently have revisions disabled.</strong></p>
			<p>To limit the number of revisions saved when you are editing your content:</p>
			<p>Untick the &lsquo;Disable Revisions&rsquo; option above and save the Post Control options.</p>
			<p>The control will then appear to limit the number of revisions saved.</p>

		<?php } ?>

		<div id="icon-tools" class="icon32"><br /></div>
		<h2>Limit trash auto-empty</h2>


			<p>Control how many days trashed content stays in the trash before it is auto-deleted by WordPress (default is 30 days).</p>
			<p>NOTE: If you set this to 0, THIS WILL REMOVE THE TRASH FUNCTIONALITY and posts will be deleted straight away when trashed!</p>

			<table class="form-table">

				<tr>
					<th scope="row">Keep trashed content for how many days</th>
					<td>

				<select name="wpcms_pcontrolopts_ex[trash_num]" id="tsave">

					<?php
					$i = 0;

					$saved = ( isset($options['trash_num']) ) ? $options['trash_num'] : 30;

					do {
					    echo '<option ';
						selected( $saved, $i );
					    echo ' class="level-'.$i.'" value="'.$i.'">'.$i.'</option>';
					    $i++;
					} while ($i < 101);
					?>
				</select>

					</td>
				</tr>

			</table>

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
		</p>

	</form>

<?php include("wp-cms-opts-pcontrol-common.php"); ?>

</div>