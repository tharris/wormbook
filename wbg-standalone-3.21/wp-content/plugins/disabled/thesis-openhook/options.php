<?php
/**
 * Options page for the Thesis OpenHook Plugin
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

/**
 * Output sanitized hook content
 *
 * @since 2.0
 */
function openhook_option($option) {
	echo stripslashes(htmlspecialchars(get_option($option)));
}


/**
 * Handle posted content
 */
if (!empty($_POST)) {
	update_option('openhook_save_button', $_POST['openhook_save_button']);

	update_option('openhook_wp_head', $_POST['openhook_wp_head']);
	update_option('openhook_wp_head_php', $_POST['openhook_wp_head_php']);

	update_option('openhook_before_html', $_POST['openhook_before_html']);
	update_option('openhook_before_html_php', $_POST['openhook_before_html_php']);

	update_option('openhook_after_html', $_POST['openhook_after_html']);
	update_option('openhook_after_html_php', $_POST['openhook_after_html_php']);
	update_option('openhook_after_html_footer_scripts', $_POST['openhook_after_html_footer_scripts']);
	update_option('openhook_after_html_ie_clear', $_POST['openhook_after_html_ie_clear']);

	update_option('openhook_before_header', $_POST['openhook_before_header']);
	update_option('openhook_before_header_php', $_POST['openhook_before_header_php']);
	update_option('openhook_before_header_nav_menu', $_POST['openhook_before_header_nav_menu']);

	update_option('openhook_after_header', $_POST['openhook_after_header']);
	update_option('openhook_after_header_php', $_POST['openhook_after_header_php']);

	update_option('openhook_header', $_POST['openhook_header']);
	update_option('openhook_header_php', $_POST['openhook_header_php']);
	update_option('openhook_header_default_header', $_POST['openhook_header_default_header']);

	update_option('openhook_before_title', $_POST['openhook_before_title']);
	update_option('openhook_before_title_php', $_POST['openhook_before_title_php']);

	update_option('openhook_after_title', $_POST['openhook_after_title']);
	update_option('openhook_after_title_php', $_POST['openhook_after_title_php']);

	update_option('openhook_before_content_box', $_POST['openhook_before_content_box']);
	update_option('openhook_before_content_box_php', $_POST['openhook_before_content_box_php']);

	update_option('openhook_after_content_box', $_POST['openhook_after_content_box']);
	update_option('openhook_after_content_box_php', $_POST['openhook_after_content_box_php']);

	update_option('openhook_before_content', $_POST['openhook_before_content']);
	update_option('openhook_before_content_php', $_POST['openhook_before_content_php']);

	update_option('openhook_after_content', $_POST['openhook_after_content']);
	update_option('openhook_after_content_php', $_POST['openhook_after_content_php']);
	update_option('openhook_after_content_post_navigation', $_POST['openhook_after_content_post_navigation']);
	update_option('openhook_after_content_prev_next_posts', $_POST['openhook_after_content_prev_next_posts']);

	update_option('openhook_before_content_area', $_POST['openhook_before_content_area']);
	update_option('openhook_before_content_area_php', $_POST['openhook_before_content_area_php']);

	update_option('openhook_after_content_area', $_POST['openhook_after_content_area']);
	update_option('openhook_after_content_area_php', $_POST['openhook_after_content_area_php']);

	update_option('openhook_feature_box', $_POST['openhook_feature_box']);
	update_option('openhook_feature_box_php', $_POST['openhook_feature_box_php']);

	update_option('openhook_before_post_box', $_POST['openhook_before_post_box']);
	update_option('openhook_before_post_box_php', $_POST['openhook_before_post_box_php']);
	update_option('openhook_before_post_box_add_post_image', $_POST['openhook_before_post_box_add_post_image']);

	update_option('openhook_after_post_box', $_POST['openhook_after_post_box']);
	update_option('openhook_after_post_box_php', $_POST['openhook_after_post_box_php']);

	update_option('openhook_before_teasers_box', $_POST['openhook_before_teasers_box']);
	update_option('openhook_before_teasers_box_php', $_POST['openhook_before_teasers_box_php']);

	update_option('openhook_after_teasers_box', $_POST['openhook_after_teasers_box']);
	update_option('openhook_after_teasers_box_php', $_POST['openhook_after_teasers_box_php']);

	update_option('openhook_before_post', $_POST['openhook_before_post']);
	update_option('openhook_before_post_php', $_POST['openhook_before_post_php']);

	update_option('openhook_after_post', $_POST['openhook_after_post']);
	update_option('openhook_after_post_php', $_POST['openhook_after_post_php']);
	update_option('openhook_after_post_trackback_rdf', $_POST['openhook_after_post_trackback_rdf']);
	update_option('openhook_after_post_post_tags', $_POST['openhook_after_post_post_tags']);
	update_option('openhook_after_post_comments_link', $_POST['openhook_after_post_comments_link']);

	update_option('openhook_before_teaser_box', $_POST['openhook_before_teaser_box']);
	update_option('openhook_before_teaser_box_php', $_POST['openhook_before_teaser_box_php']);
	update_option('openhook_before_teaser_box_add_thumb', $_POST['openhook_before_teaser_box_add_thumb']);

	update_option('openhook_after_teaser_box', $_POST['openhook_after_teaser_box']);
	update_option('openhook_after_teaser_box_php', $_POST['openhook_after_teaser_box_php']);

	update_option('openhook_before_teaser', $_POST['openhook_before_teaser']);
	update_option('openhook_before_teaser_php', $_POST['openhook_before_teaser_php']);

	update_option('openhook_after_teaser', $_POST['openhook_after_teaser']);
	update_option('openhook_after_teaser_php', $_POST['openhook_after_teaser_php']);

	update_option('openhook_before_headline', $_POST['openhook_before_headline']);
	update_option('openhook_before_headline_php', $_POST['openhook_before_headline_php']);

	update_option('openhook_after_headline', $_POST['openhook_after_headline']);
	update_option('openhook_after_headline_php', $_POST['openhook_after_headline_php']);

	update_option('openhook_before_teaser_headline', $_POST['openhook_before_teaser_headline']);
	update_option('openhook_before_teaser_headline_php', $_POST['openhook_before_teaser_headline_php']);

	update_option('openhook_after_teaser_headline', $_POST['openhook_after_teaser_headline']);
	update_option('openhook_after_teaser_headline_php', $_POST['openhook_after_teaser_headline_php']);

	update_option('openhook_byline_item', $_POST['openhook_byline_item']);
	update_option('openhook_byline_item_php', $_POST['openhook_byline_item_php']);

	update_option('openhook_before_comment_meta', $_POST['openhook_before_comment_meta']);
	update_option('openhook_before_comment_meta_php', $_POST['openhook_before_comment_meta_php']);

	update_option('openhook_after_comment_meta', $_POST['openhook_after_comment_meta']);
	update_option('openhook_after_comment_meta_php', $_POST['openhook_after_comment_meta_php']);

	update_option('openhook_after_comment', $_POST['openhook_after_comment']);
	update_option('openhook_after_comment_php', $_POST['openhook_after_comment_php']);
	update_option('openhook_comment_form_show_subscription_checkbox', $_POST['openhook_comment_form_show_subscription_checkbox']);

	update_option('openhook_comment_field', $_POST['openhook_comment_field']);
	update_option('openhook_comment_field_php', $_POST['openhook_comment_field_php']);

	update_option('openhook_comment_form', $_POST['openhook_comment_form']);
	update_option('openhook_comment_form_php', $_POST['openhook_comment_form_php']);

	update_option('openhook_archives_template', $_POST['openhook_archives_template']);
	update_option('openhook_archives_template_php', $_POST['openhook_archives_template_php']);
	update_option('openhook_archives_template_archives_template', $_POST['openhook_archives_template_archives_template']);

	update_option('openhook_custom_template', $_POST['openhook_custom_template']);
	update_option('openhook_custom_template_php', $_POST['openhook_custom_template_php']);
	update_option('openhook_custom_template_custom_template_sample', $_POST['openhook_custom_template_custom_template_sample']);

	update_option('openhook_faux_admin', $_POST['openhook_faux_admin']);
	update_option('openhook_faux_admin_php', $_POST['openhook_faux_admin']);

	update_option('openhook_archive_info', $_POST['openhook_archive_info']);
	update_option('openhook_archive_info_php', $_POST['openhook_archive_info_php']);
	update_option('openhook_archive_info_default_archive_info', $_POST['openhook_archive_info_default_archive_info']);

	update_option('openhook_404_title', $_POST['openhook_404_title']);
	update_option('openhook_404_title_php', $_POST['openhook_404_title_php']);
	update_option('openhook_404_title_404_title', $_POST['openhook_404_title_404_title']);

	update_option('openhook_404_content', $_POST['openhook_404_content']);
	update_option('openhook_404_content_php', $_POST['openhook_404_content_php']);
	update_option('openhook_404_content_404_content', $_POST['openhook_404_content_404_content']);

	update_option('openhook_before_sidebars', $_POST['openhook_before_sidebars']);
	update_option('openhook_before_sidebars_php', $_POST['openhook_before_sidebars_php']);

	update_option('openhook_after_sidebars', $_POST['openhook_after_sidebars']);
	update_option('openhook_after_sidebars_php', $_POST['openhook_after_sidebars_php']);

	update_option('openhook_multimedia_box', $_POST['openhook_multimedia_box']);
	update_option('openhook_multimedia_box_php', $_POST['openhook_multimedia_box_php']);

	update_option('openhook_after_multimedia_box', $_POST['openhook_after_multimedia_box']);
	update_option('openhook_after_multimedia_box_php', $_POST['openhook_after_multimedia_box_php']);

	update_option('openhook_before_sidebar_1', $_POST['openhook_before_sidebar_1']);
	update_option('openhook_before_sidebar_1_php', $_POST['openhook_before_sidebar_1_php']);

	update_option('openhook_after_sidebar_1', $_POST['openhook_after_sidebar_1']);
	update_option('openhook_after_sidebar_1_php', $_POST['openhook_after_sidebar_1_php']);

	update_option('openhook_before_sidebar_2', $_POST['openhook_before_sidebar_2']);
	update_option('openhook_before_sidebar_2_php', $_POST['openhook_before_sidebar_2_php']);

	update_option('openhook_after_sidebar_2', $_POST['openhook_after_sidebar_2']);
	update_option('openhook_after_sidebar_2_php', $_POST['openhook_after_sidebar_2_php']);

	update_option('openhook_before_footer', $_POST['openhook_before_footer']);
	update_option('openhook_before_footer_php', $_POST['openhook_before_footer_php']);

	update_option('openhook_after_footer', $_POST['openhook_after_footer']);
	update_option('openhook_after_footer_php', $_POST['openhook_after_footer_php']);

	update_option('openhook_footer', $_POST['openhook_footer']);
	update_option('openhook_footer_php', $_POST['openhook_footer_php']);
	update_option('openhook_footer_thesis_attribution', $_POST['openhook_footer_thesis_attribution']);
	update_option('openhook_footer_debug_info', $_POST['openhook_footer_debug_info']);
	update_option('openhook_footer_honeypot', $_POST['openhook_footer_honeypot']);

	update_option('openhook_wp_footer', $_POST['openhook_wp_footer']);
	update_option('openhook_wp_footer_php', $_POST['openhook_wp_footer_php']);

	echo '<div id="message" class="updated fade"><p><strong>' . __('Thesis customizations have been saved. You should now check your site to ensure everything is working as expected, and thank you for using Thesis with OpenHook!') . '</strong></p></div>' . "\n";
}

$save_button = attribute_escape(get_option('openhook_save_button'));
if ($save_button == '')
	$save_button = __('Little Ass Save Button', 'thesis_openhook');

?>

<style type="text/css">
<!--/*--><![CDATA[/*><!--*/
#jumpbox {
	position: fixed;
	bottom: 5em;
	right: 1em;
	background: #bbb;
	border: 1px solid #444;
	padding: 1em;
	opacity: 0.7;
	-webkit-border-radius: 0.7em;
	-khtml-border-radius: 0.7em;	
	-moz-border-radius: 0.7em;
	border-radius: 0.7em;

}
#f {
	opacity: 1 !important;
}
#f optgroup option {
	text-indent: 1em;
}
/*]]>*/-->
</style>
<div class="wrap">
<?php screen_icon(); ?>
	<h2><?php _e('Thesis OpenHook', 'thesis_openhook'); ?></h2>
	<p><?php printf(__('Be prepared to get hooked up! This plugin allows you to insert any content you want into any of the custom hooks within the <a href="%1$s">Thesis theme</a>. The hook names are pretty self explanatory, but if you need more help determining where they show up in your mark-up, <a href="%2$s" title="Thesis Hooks Reference">check the manual</a>.'), 'http://get-thesis.com/', 'http://diythemes.com/thesis/rtfm/hooks/'); ?></p>
	<p><?php printf(__('Report bugs to rick.beckman@gmail.com. Support is provided by the community at DIYthemes.', 'thesis_openhook')); ?></p>
	<p><?php printf(__('OpenHook is released for free to the Thesis community, but if you’d like to encourage its development, would you consider bribing me with <a href="%s">something off of my wishlist</a>? Thanks!', 'thesis_openhook'), 'http://www.amazon.com/wishlist/366L8REQVLCN3'); ?></p>
	<p><strong><?php _e('Insert any <abbr title="Hypertext Markup Language">HTML</abbr>, <abbr title="Cascading Style Sheets">CSS</abbr>, JavaScript or <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> you like.', 'thesis_openhook'); ?></strong>
		<br /><small><?php _e('Your <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> code must be enclosed within <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> tags, and you have to enable the “Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook” option for each hook separately.', 'thesis_openhook'); ?></small></p>
	<p><?php _e('Please note that using <em>any</em> of the save buttons on this page will save <em>all</em> of the displayed fields. Take care not to save unwanted changes. You’ve been warned.', 'thesis_openhook'); ?></p>

	<form method="post" action="">
		<div class="hidden">
			<?php settings_fields('thesis_openhook'); ?>
		</div>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><h3 id="wp_head"><?php _e('WP Head', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>wp_head</code></legend>
						<p><label for="openhook_wp_head"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>wp_head</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_wp_head" name="openhook_wp_head" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_wp_head'); ?></textarea>
						<p>
							<label for="openhook_wp_head_php">
								<input<?php checked('1', get_option('openhook_wp_head_php')); ?> value="1" id="openhook_wp_head_php" name="openhook_wp_head_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_html"><?php _e('Before <abbr title="Hypertext Markup Language">HTML</abbr>', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_html</code></legend>
						<p><label for="openhook_before_html"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_html</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_html" name="openhook_before_html" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_html'); ?></textarea>
						<p>
							<label for="openhook_before_html_php">
								<input<?php checked('1', get_option('openhook_before_html_php')); ?> value="1" id="openhook_before_html_php" name="openhook_before_html_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_html"><?php _e('After <abbr title="Hypertext Markup Language">HTML</abbr>', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_html</code></legend>
						<p><label for="openhook_after_html"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_html</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_html" name="openhook_after_html" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_html'); ?></textarea>
						<p>
							<label for="openhook_after_html_php">
								<input<?php checked('1', get_option('openhook_after_html_php')); ?> value="1" id="openhook_after_html_php" name="openhook_after_html_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP<?abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_after_html_footer_scripts">
								<input<?php checked('1', get_option('openhook_after_html_footer_scripts')); ?> value="1" id="openhook_after_html_footer_scripts" name="openhook_after_html_footer_scripts" type="checkbox" />
								<?php _e('Remove Thesis footer scripts', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Thesis footer scripts are specified in the Thesis Options panel; if you wish to disable them without clearing the data in the Thesis Options, you may do so by removing the action itself.', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_after_html_ie_clear">
								<input<?php checked('1', get_option('openhook_after_html_ie_clear')); ?> value="1" id="openhook_after_html_ie_clear" name="openhook_after_html_ie_clear" type="checkbox" />
								<?php _e('Remove Thesis <abbr title="Internet Explorer">IE</abbr> clearing', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Don’t care about Internet Explorer? Then don’t output this bit of compatibility code! (Not recommended.)', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_header"><?php _e('Before Header', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_header</code></legend>
						<p><label for="openhook_before_header"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_header</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_header" name="openhook_before_header" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_header'); ?></textarea>
						<p>
							<label for="openhook_before_header_php">
								<input<?php checked('1', get_option('openhook_before_header_php')); ?> value="1" id="openhook_before_header_php" name="openhook_before_header_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_before_header_nav_menu">
 								<input<?php checked('1', get_option('openhook_before_header_nav_menu')); ?> value="1" id="openhook_before_header_nav_menu" name="openhook_before_header_nav_menu" type="checkbox" />
								<?php _e('Remove Thesis nav menu', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('To move your navigation menu to below your header, remove it here, then include <code>&lt;?php thesis_nav_menu(); ?&gt;</code> in the “After Header” hook. You can, of course, add it to any hook you want!', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_header"><?php _e('After Header', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_header</code></legend>
						<p><label for="openhook_after_header"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_header</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_header" name="openhook_after_header" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_header'); ?></textarea>
						<p>
							<label for="openhook_after_header_php">
								<input<?php checked('1', get_option('openhook_after_header_php')); ?> value="1" id="openhook_after_header_php" name="openhook_after_header_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="header"><?php _e('Header', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_header</code></legend>
						<p><label for="openhook_header"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_header</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_header" name="openhook_header" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_header'); ?></textarea>
						<p>
							<label for="openhook_header_php">
								<input<?php checked('1', get_option('openhook_header_php')); ?> value="1" id="openhook_header_php" name="openhook_header_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_header_default_header">
								<input<?php checked('1', get_option('openhook_header_default_header')); ?> value="1" id="openhook_header_default_header" name="openhook_header_default_header" type="checkbox" />
								<?php _e('Remove Thesis default header', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('The default header contains your site name and tagline, but also the “Before Title” and “After Title” hooks.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_title"><?php _e('Before Title', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_title</code></legend>
						<p><label for="openhook_before_title"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_title</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_title" name="openhook_before_title" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_title'); ?></textarea>
						<p>
							<label for="openhook_before_title_php">
								<input<?php checked('1', get_option('openhook_before_title_php')); ?> value="1" id="openhook_before_title_php" name="openhook_before_title_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_title"><?php _e('After Title', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_title</code></legend>
						<p><label for="openhook_after_title"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_title</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_title" name="openhook_after_title" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_title'); ?></textarea>
						<p>
							<label for="openhook_after_title_php">
								<input<?php checked('1', get_option('openhook_after_title_php')); ?> value="1" id="openhook_after_title_php" name="openhook_after_title_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_content_box"><?php _e('Before Content Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_content_box</code></legend>
						<p><label for="openhook_before_content_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_content_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_content_box" name="openhook_before_content_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_content_box'); ?></textarea>
						<p>
							<label for="openhook_before_content_box_php">
								<input<?php checked('1', get_option('openhook_before_content_box_php')); ?> value="1" id="openhook_before_content_box_php" name="openhook_before_content_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_content_box"><?php _e('After Content Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_content_box</code></legend>
						<p><label for="openhook_after_content_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_content_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_content_box" name="openhook_after_content_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_content_box'); ?></textarea>
						<p>
							<label for="openhook_after_content_box_php">
								<input<?php checked('1', get_option('openhook_after_content_box_php')); ?> value="1" id="openhook_after_content_box_php" name="openhook_after_content_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_content"><?php _e('Before Content', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_content</code></legend>
						<p><label for="openhook_before_content"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_content</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_content" name="openhook_before_content" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_content'); ?></textarea>
						<p>
							<label for="openhook_before_content_php">
								<input<?php checked('1', get_option('openhook_before_content_php')); ?> value="1" id="openhook_before_content_php" name="openhook_before_content_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_content"><?php _e('After Content', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_content</code></legend>
						<p><label for="openhook_after_content"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_content</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_content" name="openhook_after_content" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_content'); ?></textarea>
						<p>
							<label for="openhook_after_content_php">
								<input<?php checked('1', get_option('openhook_after_content_php')); ?> value="1" id="openhook_after_content_php" name="openhook_after_content_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_after_content_post_navigation">
								<input<?php checked('1', get_option('openhook_after_content_post_navigation')); ?> value="1" id="openhook_after_content_post_navigation" name="openhook_after_content_post_navigation" type="checkbox" />
								<?php _e('Remove Thesis post navigation', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Disables the older/newer links on the index page and archives. If you would like to move this to another hook, you can use <code>&lt;?php thesis_post_navigation(); ?&gt;</code>.', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_after_content_prev_next_posts">
								<input<?php checked('1', get_option('openhook_after_content_prev_next_posts')); ?> value="1" id="openhook_after_content_prev_next_posts" name="openhook_after_content_prev_next_posts" type="checkbox" />
								<?php _e('Remove Thesis prev/next posts', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('While you can disable the previous/next post links on single pages via Thesis Options, leaving it active and removing it here allows you to add it to another hook using <code>&lt;?php thesis_prev_next_posts(); ?&gt;</code>.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_content"><?php _e('Before Content Area', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_content_area</code></legend>
						<p><label for="openhook_before_content_area"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_content_area</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_content_area" name="openhook_before_content_area" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_content_area'); ?></textarea>
						<p>
							<label for="openhook_before_content_area_php">
								<input<?php checked('1', get_option('openhook_before_content_area_php')); ?> value="1" id="openhook_before_content_area_php" name="openhook_before_content_area_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_content_area"><?php _e('After Content Area', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_content_area</code></legend>
						<p><label for="openhook_after_content_area"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_content_area</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_content_area" name="openhook_after_content_area" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_content_area'); ?></textarea>
						<p>
							<label for="openhook_after_content_area_php">
								<input<?php checked('1', get_option('openhook_after_content_area_php')); ?> value="1" id="openhook_after_content_area_php" name="openhook_after_content_area_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="feature_box"><?php _e('Feature Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_feature_box</code></legend>
						<p><label for="openhook_feature_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_feature_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_feature_box" name="openhook_feature_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_feature_box'); ?></textarea>
						<p>
							<label for="openhook_feature_box_php">
								<input<?php checked('1', get_option('openhook_feature_box_php')); ?> value="1" id="openhook_feature_box_php" name="openhook_feature_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_post_box"><?php _e('Before Post Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_post_box</code></legend>
						<p><label for="openhook_before_post_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_post_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_post_box" name="openhook_before_post_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_post_box'); ?></textarea>
						<p>
							<label for="openhook_before_post_box_php">
								<input<?php checked('1', get_option('openhook_before_post_box_php')); ?> value="1" id="openhook_before_post_box_php" name="openhook_before_post_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_before_post_box_add_post_image">
								<input<?php checked('1', get_option('openhook_before_post_box_add_post_image')); ?> value="1" id="openhook_before_post_box_add_post_image" name="openhook_before_post_box_add_post_image" type="checkbox" />
								<?php _e('Remove post images', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Need to completely remove post images without tinkering with Thesis’ settings?', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_post_box"><?php _e('After Post Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_post_box</code></legend>
						<p><label for="openhook_after_post_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_post_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_post_box" name="openhook_after_post_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_post_box'); ?></textarea>
						<p>
							<label for="openhook_after_post_box_php">
								<input<?php checked('1', get_option('openhook_after_post_box_php')); ?> value="1" id="openhook_after_post_box_php" name="openhook_after_post_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_teasers_box"><?php _e('Before Teasers Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_teasers_box</code></legend>
						<p><label for="openhook_before_teasers_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_teasers_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_teasers_box" name="openhook_before_teasers_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_teasers_box'); ?></textarea>
						<p>
							<label for="openhook_before_teasers_box_php">
								<input<?php checked('1', get_option('openhook_before_teasers_box_php')); ?> value="1" id="openhook_before_teasers_box_php" name="openhook_before_teasers_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_teasers_box"><?php _e('After Teasers Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_teasers_box</code></legend>
						<p><label for="openhook_after_teasers_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_teasers_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_teasers_box" name="openhook_after_teasers_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_teasers_box'); ?></textarea>
						<p>
							<label for="openhook_after_teasers_box_php">
								<input<?php checked('1', get_option('openhook_after_teasers_box_php')); ?> value="1" id="openhook_after_teasers_box_php" name="openhook_after_teasers_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_post"><?php _e('Before Post', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_post</code></legend>
						<p><label for="openhook_before_content"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_post</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_post" name="openhook_before_post" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_post'); ?></textarea>
						<p>
							<label for="openhook_before_post_php">
								<input<?php checked('1', get_option('openhook_before_post_php')); ?> value="1" id="openhook_before_post_php" name="openhook_before_post_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_post"><?php _e('After Post', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_post</code></legend>
						<p><label for="openhook_after_post"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_post</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_post" name="openhook_after_post" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_post'); ?></textarea>
						<p>
							<label for="openhook_after_post_php">
								<input<?php checked('1', get_option('openhook_after_post_php')); ?> value="1" id="openhook_after_post_php" name="openhook_after_post_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_after_post_trackback_rdf">
								<input<?php checked('1', get_option('openhook_after_post_trackback_rdf')); ?> value="1" id="openhook_after_post_trackback_rdf" name="openhook_after_post_trackback_rdf" type="checkbox" />
								<?php _e('Remove WordPress TrackBack <abbr title="Resource Description Framework">RDF</abbr>', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Allows you to remove the TrackBack auto-discovery code from your posts. <a href="http://codex.wordpress.org/Template_Tags/trackback_rdf">More information</a> is available on the WordPress Codex.', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_after_post_post_tags">
								<input<?php checked('1', get_option('openhook_after_post_post_tags')); ?> value="1" id="openhook_after_post_post_tags" name="openhook_after_post_post_tags" type="checkbox" />
								<?php _e('Remove post tags', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('While you can control the visibility of post tags via Thesis Options, if you would like to change their location, you can remove them here and add them to another hook by using <code>&lt;?php thesis_post_tags(); ?&gt;</code>.', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_after_post_comments_link">
								<input<?php checked('1', get_option('openhook_after_post_comments_link')); ?> value="1" id="openhook_after_post_comments_link" name="openhook_after_post_comments_link" type="checkbox" />
								<?php _e('Remove Thesis comments link', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('This will remove the “{ Comments # }” link from the index and archive pages.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_teaser_box"><?php _e('Before Teaser Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_teaser_box</code></legend>
						<p><label for="openhook_before_teaser_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_teaser_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_teaser_box" name="openhook_before_teaser_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_teaser_box'); ?></textarea>
						<p>
							<label for="openhook_before_teaser_box_php">
								<input<?php checked('1', get_option('openhook_before_teaser_box_php')); ?> value="1" id="openhook_before_teaser_box_php" name="openhook_before_teaser_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_before_teaser_box_add_thumb">
								<input<?php checked('1', get_option('openhook_before_teaser_box_add_thumb')); ?> value="1" id="openhook_before_teaser_box_add_thumb" name="openhook_before_teaser_box_add_thumb" type="checkbox" />
								<?php _e('Remove Thesis teaser thumbnails', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Need to remove the thumbnail images on teasers without tinkering with Thesis’ options?', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_teaser_box"><?php _e('After Teaser Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_teaser_box</code></legend>
						<p><label for="openhook_after_teaser_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_teaser_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_teaser_box" name="openhook_after_teaser_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_teaser_box'); ?></textarea>
						<p>
							<label for="openhook_after_teaser_box_php">
								<input<?php checked('1', get_option('openhook_after_teaser_box_php')); ?> value="1" id="openhook_after_teaser_box_php" name="openhook_after_teaser_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_teaser"><?php _e('Before Teaser', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_teaser</code></legend>
						<p><label for="openhook_before_teaser"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_teaser</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_teaser" name="openhook_before_teaser" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_teaser'); ?></textarea>
						<p>
							<label for="openhook_before_teaser_php">
								<input<?php checked('1', get_option('openhook_before_teaser_php')); ?> value="1" id="openhook_before_teaser_php" name="openhook_before_teaser_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_teaser"><?php _e('After Teaser', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_teaser</code></legend>
						<p><label for="openhook_after_teaser"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_teaser</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_teaser" name="openhook_after_teaser" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_teaser'); ?></textarea>
						<p>
							<label for="openhook_after_teaser_php">
								<input<?php checked('1', get_option('openhook_after_teaser_php')); ?> value="1" id="openhook_after_teaser_php" name="openhook_after_teaser_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_headline"><?php _e('Before Headline', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_headline</code></legend>
						<p><label for="openhook_before_headline"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_headline</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_headline" name="openhook_before_headline" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_headline'); ?></textarea>
						<p>
							<label for="openhook_before_headline_php">
								<input<?php checked('1', get_option('openhook_before_headline_php')); ?> value="1" id="openhook_before_headline_php" name="openhook_before_headline_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_headline"><?php _e('After Headline', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_headline</code></legend>
						<p><label for="openhook_after_headline"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_headline</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_headline" name="openhook_after_headline" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_headline'); ?></textarea>
						<p>
							<label for="openhook_after_headline_php">
								<input<?php checked('1', get_option('openhook_after_headline_php')); ?> value="1" id="openhook_after_headline_php" name="openhook_after_headline_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_teaser_headline"><?php _e('Before Teaser Headline', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_teaser_headline</code></legend>
						<p><label for="openhook_before_teaser_headline"<?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_teaser_headline</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_teaser_headline" name="openhook_before_teaser_headline" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_teaser_headline'); ?></textarea>
						<p>
							<label for="openhook_before_teaser_headline_php">
								<input<?php checked('1', get_option('openhook_before_teaser_headline_php')); ?> value="1" id="openhook_before_teaser_headline_php" name="openhook_before_teaser_headline_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_teaser_headline"><?php _e('After Teaser Headline', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_teaser_headline</code></legend>
						<p><label for="openhook_after_teaser_headline"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_teaser_headline</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_teaser_headline" name="openhook_after_teaser_headline" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_teaser_headline'); ?></textarea>
						<p>
							<label for="openhook_before_teaser_headline_php">
								<input<?php checked('1', get_option('openhook_after_teaser_headline_php')); ?> value="1" id="openhook_after_teaser_headline_php" name="openhook_after_teaser_headline_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="byline_item"><?php _e('Byline Item', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_byline_item</code></legend>
						<p><label for="openhook_byline_item"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_byline_item</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_byline_item" name="openhook_byline_item" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_byline_item'); ?></textarea>
						<p>
							<label for="openhook_after_headline_php">
								<input<?php checked('1', get_option('openhook_byline_item_php')); ?> value="1" id="openhook_byline_item_php" name="openhook_byline_item_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_comment_meta"><?php _e('Before Comment Meta', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_comment_meta</code></legend>
						<p><label for="openhook_before_comment_meta"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_comment_meta</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_comment_meta" name="openhook_before_comment_meta" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_comment_meta'); ?></textarea>
						<p>
							<label for="openhook_before_comment_meta_php">
								<input<?php checked('1', get_option('openhook_before_comment_meta_php')); ?> value="1" id="openhook_before_comment_meta_php" name="openhook_before_comment_meta_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_comment_meta"><?php _e('After Comment Meta', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_comment_meta</code></legend>
						<p><label for="openhook_after_comment_meta"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_comment_meta</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_comment_meta" name="openhook_after_comment_meta" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_comment_meta'); ?></textarea>
						<p>
							<label for="openhook_after_comment_meta_php">
								<input<?php checked('1', get_option('openhook_after_comment_meta_php')); ?> value="1" id="openhook_after_comment_meta_php" name="openhook_after_comment_meta_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_comment"><?php _e('After Comment', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_comment</code></legend>
						<p><label for="openhook_after_comment"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_comment</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_comment" name="openhook_after_comment" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_comment'); ?></textarea>
						<p>
							<label for="openhook_after_comment_php">
								<input<?php checked('1', get_option('openhook_after_comment_php')); ?> value="1" id="openhook_after_comment_php" name="openhook_after_comment_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="comment_form"><?php _e('Comment Field', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_comment_field</code></legend>
						<p><label for="openhook_comment_field"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_comment_field</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_comment_field" name="openhook_comment_field" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_comment_field'); ?></textarea>
						<p>
							<label for="openhook_comment_field_php">
								<input<?php checked('1', get_option('openhook_comment_field_php')); ?> value="1" id="openhook_comment_field_php" name="openhook_comment_field_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>			<tr valign="top">
				<th scope="row"><h3 id="comment_form"><?php _e('Comment Form', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_comment_form</code></legend>
						<p><label for="openhook_comment_form"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_comment_form</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_comment_form" name="openhook_comment_form" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_comment_form'); ?></textarea>
						<p>
							<label for="openhook_comment_form_php">
								<input<?php checked('1', get_option('openhook_comment_form_php')); ?> value="1" id="openhook_comment_form_php" name="openhook_comment_form_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_comment_form_show_subscription_checkbox">
								<input<?php checked('1', get_option('openhook_comment_form_show_subscription_checkbox')); ?> value="1" id="openhook_comment_form_show_subscription_checkbox" name="openhook_comment_form_show_subscription_checkbox" type="checkbox" />
								<?php _e('Remove comments subscription checkbox', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('If you have the Subscribe to Comments plugin installed but dislike the default location for the subscribe option, you can remove it here and place it elsewhere using <code>&lt;?php if (function_exists(\'show_subscription_checkbox\')) show_subscription_checkbox(); ?&gt;</code>.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="archives_template"><?php _e('Archives Template', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_archives_template</code></legend>
						<p><label for="openhook_archives_template"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_archives_template</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_archives_template" name="openhook_archives_template" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_archives_template'); ?></textarea>
						<p>
							<label for="openhook_archives_template_php">
								<input<?php checked('1', get_option('openhook_archives_template_php')); ?> value="1" id="openhook_archives_template_php" name="openhook_archives_template_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_archives_template_archives_template">
								<input<?php checked('1', get_option('openhook_archives_template_archives_template')); ?> value="1" id="openhook_archives_template_archives_template" name="openhook_archives_template_archives_template" type="checkbox" />
								<?php _e('Remove Thesis archives template', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Thesis’ default archives template displays a list of monthly archives and categories; if you add your own archives code, you may want to remove the default.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="custom_template"><?php _e('Custom Template', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_custom_template</code></legend>
						<p><label for="openhook_custom_template"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_custom_template</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_custom_template" name="openhook_custom_template" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_custom_template'); ?></textarea>
						<p>
							<label for="openhook_custom_template_php">
								<input<?php checked('1', get_option('openhook_custom_template_php')); ?> value="1" id="openhook_custom_template_php" name="openhook_custom_template_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_custom_template_custom_template_sample">
								<input<?php checked('1', get_option('openhook_custom_template_custom_template_sample')); ?> value="1" id="openhook_custom_template_custom_template_sample" name="openhook_custom_template_custom_template_sample" type="checkbox" />
								<?php _e('Remove Thesis custom template sample', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('If you are creating your own custom templates for pages, you should disable Thesis’ sample custom output.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="faux_admin"><?php _e('Faux Admin', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_faux_admin</code></legend>
						<p><label for="openhook_faux_admin"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_faux_admin</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_faux_admin" name="openhook_faux_admin" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_faux_admin'); ?></textarea>
						<p>
							<label for="openhook_faux_admin_php">
								<input<?php checked('1', get_option('openhook_faux_admin_php')); ?> value="1" id="openhook_faux_admin_php" name="openhook_faux_admin_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="archive_info"><?php _e('Archive Info', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_archive_info</code></legend>
						<p><label for="openhook_archive_info"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_archive_info</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_archive_info" name="openhook_archive_info" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_archive_info'); ?></textarea>
						<p>
							<label for="openhook_archive_info_php">
								<input<?php checked('1', get_option('openhook_archive_info_php')); ?> value="1" id="openhook_archive_info_php" name="openhook_archive_info_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_archive_info_default_archive_info">
								<input<?php checked('1', get_option('openhook_archive_info_default_archive_info')); ?> value="1" id="openhook_archive_info_default_archive_info" name="openhook_archive_info_default_archive_info" type="checkbox" />
								<?php _e('Remove Thesis default archive info', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('The default archive info appears at the top of archives and gives the name and type of the archive being viewed.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="404_title"><?php _e('404 Title', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_404_title</code></legend>
						<p><label for="openhook_404_title"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_404_title</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<p><input name="openhook_404_title" id="openhook_404_title" type="text" value="<?php openhook_option('openhook_404_title'); ?>" class="regular-text" /></p>
						<p>
							<label for="openhook_404_title_php">
								<input<?php checked('1', get_option('openhook_404_title_php')); ?> value="1" id="openhook_404_title_php" name="openhook_404_title_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_404_title_404_title">
								<input<?php checked('1', get_option('openhook_404_title_404_title')); ?> value="1" id="openhook_404_title_404_title" name="openhook_404_title_404_title" type="checkbox" />
								<?php _e('Remove Thesis default 404 title', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('If you’re including your own 404 page title, you will want to remove Thesis’ default title.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="404_content"><?php _e('404 Content', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_404_content</code></legend>
						<p><label for="openhook_404_content"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_404_content</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_404_content" name="openhook_404_content" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_404_content'); ?></textarea>
						<p>
							<label for="openhook_404_content_php">
								<input<?php checked('1', get_option('openhook_404_content_php')); ?> value="1" id="openhook_404_content_php" name="openhook_404_content_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_404_content_404_content">
								<input<?php checked('1', get_option('openhook_404_content_404_content')); ?> value="1" id="openhook_404_content_404_content" name="openhook_404_content_404_content" type="checkbox" />
								<?php _e('Remove Thesis default 404 content', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('If you’re including your own 404 content via the box above, you will want to remove Thesis’ default 404 content.', 'thesis_openhook'); ?></small>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_sidebars"><?php _e('Before Sidebars', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_sidebars</code></legend>
						<p><label for="openhook_before_sidebars"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_sidebars</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_sidebars" name="openhook_before_sidebars" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_sidebars'); ?></textarea>
						<p>
							<label for="openhook_before_sidebars_php">
								<input<?php checked('1', get_option('openhook_before_sidebars_php')); ?> value="1" id="openhook_before_sidebars_php" name="openhook_before_sidebars_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_sidebars"><?php _e('After Sidebars', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_sidebars</code></legend>
						<p><label for="openhook_after_sidebars"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_sidebars</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_sidebars" name="openhook_after_sidebars" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_sidebars'); ?></textarea>
						<p>
							<label for="openhook_after_sidebars_php">
								<input<?php checked('1', get_option('openhook_after_sidebars_php')); ?> value="1" id="openhook_after_sidebars_php" name="openhook_after_sidebars_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="multimedia_box"><?php _e('Multimedia Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_multimedia_box</code></legend>
						<p><label for="openhook_multimedia_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_multimedia_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_multimedia_box" name="openhook_multimedia_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_multimedia_box'); ?></textarea>
						<p>
							<label for="openhook_multimedia_box_php">
								<input<?php checked('1', get_option('openhook_multimedia_box_php')); ?> value="1" id="openhook_multimedia_box_php" name="openhook_multimedia_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_multimedia_box"><?php _e('After Multimedia Box', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_multimedia_box</code></legend>
						<p><label for="openhook_after_multimedia_box"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_multimedia_box</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_multimedia_box" name="openhook_after_multimedia_box" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_multimedia_box'); ?></textarea>
						<p>
							<label for="openhook_after_multimedia_box_php">
								<input<?php checked('1', get_option('openhook_after_multimedia_box_php')); ?> value="1" id="openhook_after_multimedia_box_php" name="openhook_after_multimedia_box_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_sidebar_1"><?php _e('Before Sidebar 1', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_sidebar_1</code></legend>
						<p><label for="openhook_before_sidebar_1"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_sidebar_1</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_sidebar_1" name="openhook_before_sidebar_1" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_sidebar_1'); ?></textarea>
						<p>
							<label for="openhook_before_sidebar_1_php">
								<input<?php checked('1', get_option('openhook_before_sidebar_1_php')); ?> value="1" id="openhook_before_sidebar_1_php" name="openhook_before_sidebar_1_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_sidebar_1"><?php _e('After Sidebar 1', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_sidebar_1</code></legend>
						<p><label for="openhook_after_sidebar_1"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_sidebar_1</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_sidebar_1" name="openhook_after_sidebar_1" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_sidebar_1'); ?></textarea>
						<p>
							<label for="openhook_after_sidebar_1_php">
								<input<?php checked('1', get_option('openhook_after_sidebar_1_php')); ?> value="1" id="openhook_after_sidebar_1_php" name="openhook_after_sidebar_1_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_sidebar_2"><?php _e('Before Sidebar 2', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_sidebar_2</code></legend>
						<p><label for="openhook_before_sidebar_2"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_sidebar_2</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_sidebar_2" name="openhook_before_sidebar_2" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_sidebar_2'); ?></textarea>
						<p>
							<label for="openhook_before_sidebar_2_php">
								<input<?php checked('1', get_option('openhook_before_sidebar_2_php')); ?> value="1" id="openhook_before_sidebar_2_php" name="openhook_before_sidebar_2_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_sidebar_2"><?php _e('After Sidebar 2', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_sidebar_2</code></legend>
						<p><label for="openhook_after_sidebar_2"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_sidebar_2</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_sidebar_2" name="openhook_after_sidebar_2" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_sidebar_2'); ?></textarea>
						<p>
							<label for="openhook_after_sidebar_2_php">
								<input<?php checked('1', get_option('openhook_after_sidebar_2_php')); ?> value="1" id="openhook_after_sidebar_2_php" name="openhook_after_sidebar_2_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="before_footer"><?php _e('Before Footer', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_before_footer</code></legend>
						<p><label for="openhook_before_footer"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_before_footer</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_before_footer" name="openhook_before_footer" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_before_footer'); ?></textarea>
						<p>
							<label for="openhook_before_footer_php">
								<input<?php checked('1', get_option('openhook_before_footer_php')); ?> value="1" id="openhook_before_footer_php" name="openhook_before_footer_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="after_footer">After Footer</h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_after_footer</code></legend>
						<p><label for="openhook_after_footer"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_after_footer</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_after_footer" name="openhook_after_footer" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_after_footer'); ?></textarea>
						<p>
							<label for="openhook_after_footer_php">
								<input<?php checked('1', get_option('openhook_after_footer_php')); ?> value="1" id="openhook_after_footer_php" name="openhook_after_footer_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="oh_footer"><?php _e('Footer', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>thesis_hook_footer</code></legend>
						<p><label for="openhook_footer"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>thesis_hook_footer</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_footer" name="openhook_footer" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_footer'); ?></textarea>
						<p>
							<label for="openhook_footer_php">
								<input<?php checked('1', get_option('openhook_footer_php')); ?> value="1" id="openhook_footer_php" name="openhook_footer_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
						<p>
							<label for="openhook_footer_thesis_attribution">
								<input<?php checked('1', get_option('openhook_footer_thesis_attribution')); ?> value="1" id="openhook_footer_thesis_attribution" name="openhook_footer_thesis_attribution" type="checkbox" />
								<?php _e('Remove Thesis attribution', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('Only those who purchased Thesis using the Developer’s Option are allowed to remove the Thesis attribution link. If you purchased the Personal Option and remove the Thesis attribution, be sure to include it within your own footer content (perhaps replacing it with <a href="http://aff.get-thesis.com/">an affiliate link to DIYthemes</a>).', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_footer_debug_info">
								<input<?php checked('1', get_option('openhook_footer_debug_info')); ?> value="1" id="openhook_footer_debug_info" name="openhook_footer_debug_info" type="checkbox" />
								<?php _e('Display debug information', 'thesis_openhook'); ?>
							</label><br />
							<small><?php _e('If you would like to keep tabs on how long <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> takes to process your page or on how many database queries are being made, turning on the debug information will add this data to your blog’s footer, visible to administrators only. <a href="http://rickbeckman.org/use-wordpress-debug-stats-to-trim-the-fat-from-your-blog/">More information on using debug information to speed up your site.</a>', 'thesis_openhook'); ?></small>
						</p>
						<p>
							<label for="openhook_footer_honeypot">
								<input<?php checked('1', get_option('openhook_footer_honeypot')); ?> value="1" id="openhook_footer_honeypot" name="openhook_footer_honeypot" type="checkbox" />
								<?php printf(__('Help fight spam by including an invisible <a href="%s">Project Honey Pot QuickLink</a> in the footer area.', 'thesis_openhook'), 'http://www.projecthoneypot.org/faq.php#f'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="wp_footer"><?php _e('WP Footer', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<fieldset>
						<legend class="hidden"><code>wp_footer</code></legend>
						<p><label for="openhook_wp_footer"><?php printf(__('Equivalent to adding to %1$s in your %2$s file.', 'thesis_openhook'), '<code>wp_footer</code>', '<code>custom_functions.php</code>'); ?></label></p>
						<textarea id="openhook_wp_footer" name="openhook_wp_footer" rows="10" cols="50" class="large-text code"><?php openhook_option('openhook_wp_footer'); ?></textarea>
						<p>
							<label for="openhook_wp_footer_php">
								<input<?php checked('1', get_option('openhook_wp_footer_php')); ?> value="1" id="openhook_wp_footer_php" name="openhook_wp_footer_php" type="checkbox" />
								<?php _e('Execute <abbr title="PHP: Hypertext Preprocessor">PHP</abbr> on this hook', 'thesis_openhook'); ?>
							</label>
						</p>
					</fieldset>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 id="openhook_save_button"><?php _e('Save Button', 'thesis_openhook'); ?></h3></th>
				<td class="toggle-container">
					<p><label for="openhook_save_button"><?php _e('You can replace the text of the save button with whatever text you want.', 'thesis_openhook'); ?></p>
						<p><input name="openhook_save_button" id="openhook_save_button" type="text" value="<?php openhook_option('openhook_save_button'); ?>" class="regular-text" /></p>
					<p class="submit"><input type="submit" class="button-primary" value="<?php echo $save_button; ?>" /></p>
				</td>
			</tr>
		</table>
	</form>
	<form id="jumpbox">
		<fieldset class="jumpbox">
			<label for="f" class="hidden"><?php _e('Jump to a hook', 'thesis_openhook'); ?>:</label>
			<select name="f" id="f" onchange="if(this.options[this.selectedIndex].value != -1){ window.location=this.options[this.selectedIndex].value }">
				<option value="-1"><?php _e('Select a hook', 'thesis_openhook'); ?></option>
				<option value="-1">-<>--<>--<>--<>--<>-</option>
				<option value="#wp_head">wp_head</option>
				<option value="#before_html">thesis_hook_before_html</option>
				<option value="#after_html">thesis_hook_after_html</option>
				<optgroup label="<?php _e('Header hooks', 'thesis_openhook'); ?>">
					<option value="#before_header">thesis_hook_before_header</option>
					<option value="#after_header">thesis_hook_after_header</option>
					<option value="#header">thesis_hook_header</option>
					<option value="#before_title">thesis_hook_before_title</option>
					<option value="#after_title">thesis_hook_after_title</option>
				</optgroup>
				<optgroup label="<?php _e('Content hooks', 'thesis_openhook'); ?>">
					<option value="#before_content_box">thesis_hook_before_content_box</option>
					<option value="#after_content_box">thesis_hook_after_content_box</option>
					<option value="#before_content">thesis_hook_before_content</option>
					<option value="#after_content">thesis_hook_after_content</option>
					<option value="#before_content_area">thesis_hook_before_content_area</option>
					<option value="#after_content_area">thesis_hook_after_content_area</option>
					<option value="#feature_box">thesis_hook_feature_box</option>
					<option value="#before_post_box">thesis_hook_before_post_box</option>
					<option value="#after_post_box">thesis_hook_after_post_box</option>
					<option value="#before_post">thesis_hook_before_post</option>
					<option value="#after_post">thesis_hook_after_post</option>
					<option value="#before_headline">thesis_hook_before_headline</option>
					<option value="#after_headline">thesis_hook_after_headline</option>
					<option value="#byline_item">thesis_hook_byline_item</option>
				</optgroup>
				<optgroup label="<?php _e('Teaser hooks', 'thesis_openhook'); ?>">
					<option value="#before_teasers_box">thesis_hook_before_teasers_box</option>
					<option value="#after_teasers_box">thesis_hook_after_teasers_box</option>
					<option value="#before_teaser_box">thesis_hook_before_teaser_box</option>
					<option value="#after_teaser_box">thesis_hook_after_teaser_box</option>
					<option value="#before_teaser">thesis_hook_before_teaser</option>
					<option value="#after_teaser">thesis_hook_after_teaser</option>
				</optgroup>
				<optgroup label="<?php _e('Comment hooks', 'thesis_openhook'); ?>">
					<option value="#before_comment_meta">thesis_hook_before_comment_meta</option>
					<option value="#after_comment_meta">thesis_hook_after_comment_meta</option>
					<option value="#after_comment">thesis_hook_after_comment</option>
					<option value="#comment_field">thesis_hook_comment_field</option>
					<option value="#comment_form">thesis_hook_comment_form</option>
				</optgroup>
				<optgroup label="<?php _e('Page templates, archives, and more'); ?>">
					<option value="#archives_template">thesis_hook_archives_template</option>
					<option value="#custom_template">thesis_hook_custom_template</option>
					<option value="#faux_admin">thesis_hook_faux_admin</option>
					<option value="#archive_info">thesis_hook_archive_info</option>
					<option value="#404_title">thesis_hook_404_title</option>
					<option value="#404_content">thesis_hook_404_content</option>
				</optgroup>
				<optgroup label="<?php _e('Sidebar hooks', 'thesis_openhook'); ?>">
					<option value="#before_sidebars">thesis_hook_before_sidebars</option>
					<option value="#after_sidebars">thesis_hook_after_sidebars</option>
					<option value="#multimedia_box">thesis_hook_multimedia_box</option>
					<option value="#after_multimedia_box">thesis_hook_after_multimedia_box</option>
					<option value="#before_sidebar_1">thesis_hook_before_sidebar_1</option>
					<option value="#after_sidebar_1">thesis_hook_after_sidebar_1</option>
					<option value="#before_sidebar_2">thesis_hook_before_sidebar_2</option>
					<option value="#after_sidebar_2">thesis_hook_after_sidebar_2</option>
				</optgroup>
				<optgroup label="<?php _e('Footer hooks', 'thesis_openhook'); ?>">
					<option value="#before_footer">thesis_hook_before_footer</option>
					<option value="#after_footer">thesis_hook_after_footer</option>
					<option value="#oh_footer">thesis_hook_footer</option>
					<option value="#wp_footer">wp_footer</option>
				</optgroup>
				<option value="#openhook_save_button"><?php _e('Rename the save button', 'thesis_openhook'); ?></option>
			</select>
		</fieldset>
	</form>
</div>