<?php

/**
 * Add nav panel link.
 *
 * Adds the Thesis OpenHook management page to the admin panel
 * navigation menu.
 *
 * @since 1.0
 */
function add_openhook_options_page() {
	add_theme_page(__('Thesis OpenHook', 'thesis_openhook'), __('Thesis OpenHook', 'thesis_openhook'), 'edit_themes', dirname(__FILE__) . '/options.php');
	add_theme_page(__('Thesis Custom Styling', 'thesis_openhook'), __('Thesis Custom Styling', 'thesis_openhook'), 'edit_themes', dirname(__FILE__) . '/css-edit.php');
	add_theme_page(__('Thesis Custom Programming', 'thesis_openhook'), __('Thesis Custom Programming', 'thesis_openhook'), 'edit_themes', dirname(__FILE__) . '/php-edit.php');
}

/**
 * Register OpenHook settings.
 *
 * @since 2.0
 */
function openhook_settings() {
	register_setting('thesis_options', 'openhook_save_button');
	register_setting('thesis_options', 'openhook_wp_head');
	register_setting('thesis_options', 'openhook_wp_head_php');
	register_setting('thesis_options', 'openhook_before_html');
	register_setting('thesis_options', 'openhook_before_html_php');
	register_setting('thesis_options', 'openhook_after_html');
	register_setting('thesis_options', 'openhook_after_html_php');
	register_setting('thesis_options', 'openhook_after_html_footer_scripts');
	register_setting('thesis_options', 'openhook_after_html_ie_clear');
	register_setting('thesis_options', 'openhook_before_header');
	register_setting('thesis_options', 'openhook_before_header_php');
	register_setting('thesis_options', 'openhook_before_header_nav_menu');
	register_setting('thesis_options', 'openhook_after_header');
	register_setting('thesis_options', 'openhook_after_header_php');
	register_setting('thesis_options', 'openhook_header');
	register_setting('thesis_options', 'openhook_header_php');
	register_setting('thesis_options', 'openhook_header_default_header');
	register_setting('thesis_options', 'openhook_before_title');
	register_setting('thesis_options', 'openhook_before_title_php');
	register_setting('thesis_options', 'openhook_after_title');
	register_setting('thesis_options', 'openhook_after_title_php');
	register_setting('thesis_options', 'openhook_before_content_box');
	register_setting('thesis_options', 'openhook_before_content_box_php');
	register_setting('thesis_options', 'openhook_after_content_box');
	register_setting('thesis_options', 'openhook_after_content_box_php');
	register_setting('thesis_options', 'openhook_before_content');
	register_setting('thesis_options', 'openhook_before_content_php');
	register_setting('thesis_options', 'openhook_after_content');
	register_setting('thesis_options', 'openhook_after_content_php');
	register_setting('thesis_options', 'openhook_before_content_area');
	register_setting('thesis_options', 'openhook_before_content_area_php');
	register_setting('thesis_options', 'openhook_after_content_area');
	register_setting('thesis_options', 'openhook_after_content_area_php');
	register_setting('thesis_options', 'openhook_after_content_post_navigation');
	register_setting('thesis_options', 'openhook_after_content_prev_next_posts');
	register_setting('thesis_options', 'openhook_feature_box');
	register_setting('thesis_options', 'openhook_feature_box_php');
	register_setting('thesis_options', 'openhook_before_post_box');
	register_setting('thesis_options', 'openhook_before_post_box_php');
	register_setting('thesis_options', 'openhook_before_post_box_add_post_image');
	register_setting('thesis_options', 'openhook_after_post_box');
	register_setting('thesis_options', 'openhook_after_post_box_php');
	register_setting('thesis_options', 'openhook_before_teasers_box');
	register_setting('thesis_options', 'openhook_before_teasers_box_php');
	register_setting('thesis_options', 'openhook_after_teasers_box');
	register_setting('thesis_options', 'openhook_after_teasers_box_php');
	register_setting('thesis_options', 'openhook_before_post');
	register_setting('thesis_options', 'openhook_before_post_php');
	register_setting('thesis_options', 'openhook_after_post');
	register_setting('thesis_options', 'openhook_after_post_php');
	register_setting('thesis_options', 'openhook_after_post_trackback_rdf');
	register_setting('thesis_options', 'openhook_after_post_post_tags');
	register_setting('thesis_options', 'openhook_after_post_comments_link');
	register_setting('thesis_options', 'openhook_before_teaser_box');
	register_setting('thesis_options', 'openhook_before_teaser_box_php');
	register_setting('thesis_options', 'openhook_before_teaser_box_add_thumb');
	register_setting('thesis_options', 'openhook_after_teaser_box');
	register_setting('thesis_options', 'openhook_after_teaser_box_php');
	register_setting('thesis_options', 'openhook_before_teaser');
	register_setting('thesis_options', 'openhook_before_teaser_php');
	register_setting('thesis_options', 'openhook_after_teaser');
	register_setting('thesis_options', 'openhook_after_teaser_php');
	register_setting('thesis_options', 'openhook_before_headline');
	register_setting('thesis_options', 'openhook_before_headline_php');
	register_setting('thesis_options', 'openhook_after_headline');
	register_setting('thesis_options', 'openhook_after_headline_php');
	register_setting('thesis_options', 'openhook_before_teaser_headline');
	register_setting('thesis_options', 'openhook_before_teaser_headline_php');
	register_setting('thesis_options', 'openhook_after_teaser_headline');
	register_setting('thesis_options', 'openhook_after_teaser_headline_php');
	register_setting('thesis_options', 'openhook_byline_item');
	register_setting('thesis_options', 'openhook_byline_item_php');
	register_setting('thesis_options', 'openhook_before_comment_meta');
	register_setting('thesis_options', 'openhook_before_comment_meta_php');
	register_setting('thesis_options', 'openhook_after_comment_meta');
	register_setting('thesis_options', 'openhook_after_comment_meta_php');
	register_setting('thesis_options', 'openhook_comment_field');
	register_setting('thesis_options', 'openhook_comment_field_php');
	register_setting('thesis_options', 'openhook_comment_form');
	register_setting('thesis_options', 'openhook_comment_form_php');
	register_setting('thesis_options', 'openhook_comment_form_show_subscription_checkbox');
	register_setting('thesis_options', 'openhook_archives_template');
	register_setting('thesis_options', 'openhook_archives_template_php');
	register_setting('thesis_options', 'openhook_archives_template_archives_template');
	register_setting('thesis_options', 'openhook_archive_info_default_archive_info');
	register_setting('thesis_options', 'openhook_custom_template');
	register_setting('thesis_options', 'openhook_custom_template_php');
	register_setting('thesis_options', 'openhook_custom_template_custom_template_sample');
	register_setting('thesis_options', 'openhook_faux_admin');
	register_setting('thesis_options', 'openhook_faux_admin_php');
	register_setting('thesis_options', 'openhook_archive_info');
	register_setting('thesis_options', 'openhook_archive_info_php');
	register_setting('thesis_options', 'openhook_404_title');
	register_setting('thesis_options', 'openhook_404_title_php');
	register_setting('thesis_options', 'openhook_404_title_404_title');
	register_setting('thesis_options', 'openhook_404_content');
	register_setting('thesis_options', 'openhook_404_content_php');
	register_setting('thesis_options', 'openhook_404_content_404_content');
	register_setting('thesis_options', 'openhook_before_sidebars');
	register_setting('thesis_options', 'openhook_before_sidebars_php');
	register_setting('thesis_options', 'openhook_after_sidebars');
	register_setting('thesis_options', 'openhook_after_sidebars_php');
	register_setting('thesis_options', 'openhook_after_multimedia_box');
	register_setting('thesis_options', 'openhook_after_multimedia_box_php');
	register_setting('thesis_options', 'openhook_multimedia_box');
	register_setting('thesis_options', 'openhook_multimedia_box_php');
	register_setting('thesis_options', 'openhook_before_sidebar_1');
	register_setting('thesis_options', 'openhook_before_sidebar_1_php');
	register_setting('thesis_options', 'openhook_after_sidebar_1');
	register_setting('thesis_options', 'openhook_after_sidebar_1_php');
	register_setting('thesis_options', 'openhook_before_sidebar_2');
	register_setting('thesis_options', 'openhook_before_sidebar_2_php');
	register_setting('thesis_options', 'openhook_after_sidebar_2');
	register_setting('thesis_options', 'openhook_after_sidebar_2_php');
	register_setting('thesis_options', 'openhook_before_footer');
	register_setting('thesis_options', 'openhook_before_footer_php');
	register_setting('thesis_options', 'openhook_after_footer');
	register_setting('thesis_options', 'openhook_after_footer_php');
	register_setting('thesis_options', 'openhook_footer');
	register_setting('thesis_options', 'openhook_footer_php');
	register_setting('thesis_options', 'openhook_footer_thesis_attribution');
	register_setting('thesis_options', 'openhook_footer_debug_info');
	register_setting('thesis_options', 'openhook_footer_honeypot');
	register_setting('thesis_options', 'openhook_wp_footer');
	register_setting('thesis_options', 'openhook_wp_footer_php');
}

function openhook_remove_actions() {
	if (get_option('openhook_after_html_footer_scripts'))
		remove_action('thesis_hook_after_html', 'thesis_footer_scripts');
	if (get_option('openhook_after_html_ie_clear'))
		remove_action('thesis_hook_after_html', 'thesis_ie_clear');
	if (get_option('openhook_before_header_nav_menu'))
		remove_action('thesis_hook_before_header', 'thesis_nav_menu');
	if (get_option('openhook_header_default_header'))
		remove_action('thesis_hook_header', 'thesis_default_header');
	if (get_option('openhook_before_post_box_add_post_image'))
		remove_action('thesis_hook_before_post_box', 'thesis_add_post_image');
	if (get_option('openhook_after_post_trackback_rdf'))
		remove_action('thesis_hook_after_post', 'thesis_trackback_rdf');
	if (get_option('openhook_after_post_post_tags'))
		remove_action('thesis_hook_after_post', 'thesis_post_tags');
	if (get_option('openhook_after_post_comments_link'))
		remove_action('thesis_hook_after_post', 'thesis_comments_link');
	if (get_option('openhook_before_teaser_box_add_thumb'))
		remove_action('thesis_hook_before_teaser_box', 'thesis_add_thumb');
	if (get_option('openhook_after_content_post_navigation'))
		remove_action('thesis_hook_after_content', 'thesis_post_navigation');
	if (get_option('openhook_after_content_prev_next_posts'))
		remove_action('thesis_hook_after_content', 'thesis_prev_next_posts');
	if (get_option('openhook_comment_form_show_subscription_checkbox'))
		remove_action('thesis_hook_comment_form', 'show_subscription_checkbox');
	if (get_option('openhook_archive_info_default_archive_info'))
		remove_action('thesis_hook_archive_info', 'thesis_default_archive_info');
	if (get_option('openhook_archives_template_archives_template'))
		remove_action('thesis_hook_archives_template', 'thesis_archives_template');
	if (get_option('openhook_custom_template_custom_template_sample'))
		remove_action('thesis_hook_custom_template', 'thesis_custom_template_sample');
	if (get_option('openhook_404_title_404_title'))
		remove_action('thesis_hook_404_title', 'thesis_404_title');
	if (get_option('openhook_404_content_404_content'))
		remove_action('thesis_hook_404_content', 'thesis_404_content');
	if (get_option('openhook_footer_thesis_attribution'))
		remove_action('thesis_hook_footer', 'thesis_attribution');
}

/**
 * function openhook_cleanup()
 *
 * @since 2.2.1
 */
function openhook_cleanup() {
	# Removed in 2.2.1
	if (get_option('openhook_footer_admin_link'))
		delete_option('openhook_footer_admin_link');
}

/**
 * function openhook_wp_head()
 *
 * @since 2.2
 */
function openhook_wp_head() {
	$val = stripslashes(get_option('openhook_wp_head'));

	if (get_option('openhook_wp_head_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_html() {
	$val = stripslashes(get_option('openhook_before_html'));

	if (get_option('openhook_before_html_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_html() {
	$val = stripslashes(get_option('openhook_after_html'));

	if (get_option('openhook_after_html_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_header() {
	$val = stripslashes(get_option('openhook_before_header'));

	if (get_option('openhook_before_header_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_header() {
	$val = stripslashes(get_option('openhook_after_header'));

	if (get_option('openhook_after_header_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_header() {
	$val = stripslashes(get_option('openhook_header'));

	if (get_option('openhook_header_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_title() {
	$val = stripslashes(get_option('openhook_before_title'));

	if (get_option('openhook_before_title_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_title() {
	$val = stripslashes(get_option('openhook_after_title'));

	if (get_option('openhook_after_title_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before content box
 *
 * @since 2.0
 */
function openhook_before_content_box() {
	$val = stripslashes(get_option('openhook_before_content_box'));

	if (get_option('openhook_before_content_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After content box
 *
 * @since 2.0
 */
function openhook_after_content_box() {
	$val = stripslashes(get_option('openhook_after_content_box'));

	if (get_option('openhook_after_content_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_content() {
	$val = stripslashes(get_option('openhook_before_content'));

	if (get_option('openhook_before_content_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_content() {
	$val = stripslashes(get_option('openhook_after_content'));

	if (get_option('openhook_after_content_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before content area
 *
 * @since 2.1
 */
function openhook_before_content_area() {
	$val = stripslashes(get_option('openhook_before_content_area'));

	if (get_option('openhook_before_content_area_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After content area
 *
 * @since 2.1
 */
function openhook_after_content_area() {
	$val = stripslashes(get_option('openhook_after_content_area'));

	if (get_option('openhook_after_content_area_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Feature box
 *
 * @since 2.0
 */
function openhook_feature_box() {
	$val = stripslashes(get_option('openhook_feature_box'));

	if (get_option('openhook_feature_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before post box
 *
 * @since 2.0
 */
function openhook_before_post_box() {
	$val = stripslashes(get_option('openhook_before_post_box'));

	if (get_option('openhook_before_post_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After post box
 *
 * @since 2.0
 */
function openhook_after_post_box() {
	$val = stripslashes(get_option('openhook_after_post_box'));

	if (get_option('openhook_after_post_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before teasers box
 *
 * @since 2.0
 */
function openhook_before_teasers_box() {
	$val = stripslashes(get_option('openhook_before_teasers_box'));

	if (get_option('openhook_before_teasers_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After teasers box
 *
 * @since 2.0
 */
function openhook_after_teasers_box() {
	$val = stripslashes(get_option('openhook_after_teasers_box'));

	if (get_option('openhook_after_teasers_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_post() {
	$val = stripslashes(get_option('openhook_before_post'));

	if (get_option('openhook_before_post_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_post() {
	$val = stripslashes(get_option('openhook_after_post'));

	if (get_option('openhook_after_post_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before teaser box
 *
 * @since 2.0
 */
function openhook_before_teaser_box() {
	$val = stripslashes(get_option('openhook_before_teaser_box'));

	if (get_option('openhook_before_teaser_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After teaser box
 *
 * @since 2.0
 */
function openhook_after_teaser_box() {
	$val = stripslashes(get_option('openhook_after_teaser_box'));

	if (get_option('openhook_after_teaser_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before teaser
 *
 * @since 2.0
 */
function openhook_before_teaser() {
	$val = stripslashes(get_option('openhook_before_teaser'));

	if (get_option('openhook_before_teaser_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After teaser
 *
 * @since 2.0
 */
function openhook_after_teaser() {
	$val = stripslashes(get_option('openhook_after_teaser'));

	if (get_option('openhook_after_teaser_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_headline() {
	$val = stripslashes(get_option('openhook_before_headline'));

	if (get_option('openhook_before_headline_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_headline() {
	$val = stripslashes(get_option('openhook_after_headline'));

	if (get_option('openhook_after_headline_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before teaser headline
 *
 * @since 2.0
 */
function openhook_before_teaser_headline() {
	$val = stripslashes(get_option('openhook_before_teaser_headline'));

	if (get_option('openhook_before_teaser_headline_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * After teaser headline
 *
 * @since 2.0
 */
function openhook_after_teaser_headline() {
	$val = stripslashes(get_option('openhook_after_teaser_headline'));

	if (get_option('openhook_after_teaser_headline_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_byline_item() {
	$val = stripslashes(get_option('openhook_byline_item'));

	if (get_option('openhook_byline_item_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_comment_meta() {
	$val = stripslashes(get_option('openhook_before_comment_meta'));

	if (get_option('openhook_before_comment_meta_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_comment_meta() {
	$val = stripslashes(get_option('openhook_after_comment_meta'));

	if (get_option('openhook_after_comment_meta_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_comment() {
	$val = stripslashes(get_option('openhook_after_comment'));

	if (get_option('openhook_after_comment_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Comment field
 *
 * @since 2.2
 */
function openhook_comment_field() {
	$val = stripslashes(get_option('openhook_comment_field'));

	if (get_option('openhook_comment_field_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_comment_form() {
	$val = stripslashes(get_option('openhook_comment_form'));

	if (get_option('openhook_comment_form_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_archives_template() {
	$val = stripslashes(get_option('openhook_archives_template'));

	if (get_option('openhook_archives_template_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_custom_template() {
	$val = stripslashes(get_option('openhook_custom_template'));

	if (get_option('openhook_custom_template_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

/**
 * Before teasers box
 *
 * @since 2.0
 */
function openhook_faux_admin() {
	$val = stripslashes(get_option('openhook_faux_admin'));

	if (get_option('openhook_faux_admin_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_archive_info() {
	$val = stripslashes(get_option('openhook_archive_info'));

	if (get_option('openhook_archive_info_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_404_title() {
	$val = stripslashes(get_option('openhook_404_title'));

	if (get_option('openhook_404_title_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_404_content() {
	$val = stripslashes(get_option('openhook_404_content'));

	if (get_option('openhook_404_content_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_sidebars() {
	$val = stripslashes(get_option('openhook_before_sidebars'));

	if (get_option('openhook_before_sidebars_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_sidebars() {
	$val = stripslashes(get_option('openhook_after_sidebars'));

	if (get_option('openhook_after_sidebars_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_multimedia_box() {
	$val = stripslashes(get_option('openhook_multimedia_box'));

	if (get_option('openhook_multimedia_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_multimedia_box() {
	$val = stripslashes(get_option('openhook_after_multimedia_box'));

	if (get_option('openhook_after_multimedia_box_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_sidebar_1() {
	$val = stripslashes(get_option('openhook_before_sidebar_1'));

	if (get_option('openhook_before_sidebar_1_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_sidebar_1() {
	$val = stripslashes(get_option('openhook_after_sidebar_1'));

	if (get_option('openhook_after_sidebar_1_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_sidebar_2() {
	$val = stripslashes(get_option('openhook_before_sidebar_2'));

	if (get_option('openhook_before_sidebar_2_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_sidebar_2() {
	$val = stripslashes(get_option('openhook_after_sidebar_2'));

	if (get_option('openhook_after_sidebar_2_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_before_footer() {
	$val = stripslashes(get_option('openhook_before_footer'));
	if (get_option('openhook_before_footer_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_after_footer() {
	$val = stripslashes(get_option('openhook_after_footer'));

	if (get_option('openhook_after_footer_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

function openhook_footer() {
	$val = stripslashes(get_option('openhook_footer'));

	if (get_option('openhook_footer_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
	
	if (get_option('openhook_footer_debug_info') && current_user_can('edit_themes')) {
		echo "\t\t<p>", get_num_queries(), __(' queries. ');
		timer_stop(1);
		_e('seconds.');
		echo "</p>\n";
	}

	if (get_option('openhook_footer_honeypot')) {
		echo "\t\t<p><a href=\"http://www.projecthoneypot.org/faq.php#f\" rel=\"nofollow\"><!-- ", rand(), " --></a></p>\n";
	}
}

/**
 * function openhook_wp_footer()
 *
 * @since 2.2
 */
function openhook_wp_footer() {
	$val = stripslashes(get_option('openhook_wp_footer'));

	if (get_option('openhook_wp_footer_php')) {
		ob_start();
		eval("?>$val<?php ");
		$val = ob_get_contents();
		ob_end_clean();
	}

	echo $val;
}

?>