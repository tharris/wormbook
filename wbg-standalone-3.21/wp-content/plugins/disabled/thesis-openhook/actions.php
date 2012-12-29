<?php

add_action('admin_init', 'openhook_settings');
add_action('admin_init', 'openhook_cleanup');
add_action('admin_menu', 'add_openhook_options_page');

add_action('wp_head', 'openhook_wp_head');
add_action('thesis_hook_before_html', 'openhook_before_html');
add_action('thesis_hook_after_html', 'openhook_after_html');
add_action('thesis_hook_before_header', 'openhook_before_header');
add_action('thesis_hook_after_header', 'openhook_after_header');
add_action('thesis_hook_header', 'openhook_header');
add_action('thesis_hook_before_title', 'openhook_before_title');
add_action('thesis_hook_after_title', 'openhook_after_title');
add_action('thesis_hook_before_content_box', 'openhook_before_content_box');
add_action('thesis_hook_after_content_box', 'openhook_after_content_box');
add_action('thesis_hook_before_content', 'openhook_before_content');
add_action('thesis_hook_after_content', 'openhook_after_content');
add_action('thesis_hook_before_content_area', 'openhook_before_content_area');
add_action('thesis_hook_after_content_area', 'openhook_after_content_area');
add_action('thesis_hook_feature_box', 'openhook_feature_box');
add_action('thesis_hook_before_post_box', 'openhook_before_post_box');
add_action('thesis_hook_after_post_box', 'openhook_after_post_box');
add_action('thesis_hook_before_teasers_box', 'openhook_before_teasers_box');
add_action('thesis_hook_after_teasers_box', 'openhook_after_teasers_box');
add_action('thesis_hook_before_post', 'openhook_before_post');
add_action('thesis_hook_after_post', 'openhook_after_post');
add_action('thesis_hook_before_teaser_box', 'openhook_before_teaser_box');
add_action('thesis_hook_after_teaser_box', 'openhook_after_teaser_box');
add_action('thesis_hook_before_teaser', 'openhook_before_teaser');
add_action('thesis_hook_after_teaser', 'openhook_after_teaser');
add_action('thesis_hook_before_headline', 'openhook_before_headline');
add_action('thesis_hook_after_headline', 'openhook_after_headline');
add_action('thesis_hook_before_teaser_headline', 'openhook_before_teaser_headline');
add_action('thesis_hook_after_teaser_headline', 'openhook_after_teaser_headline');
add_action('thesis_hook_byline_item', 'openhook_byline_item');
add_action('thesis_hook_before_comment_meta', 'openhook_before_comment_meta');
add_action('thesis_hook_after_comment_meta', 'openhook_after_comment_meta');
add_action('thesis_hook_after_comment', 'openhook_after_comment');
add_action('thesis_hook_comment_field', 'openhook_comment_field');
add_action('thesis_hook_comment_form', 'openhook_comment_form');
add_action('thesis_hook_archives_template', 'openhook_archives_template');
add_action('thesis_hook_custom_template', 'openhook_custom_template');
add_action('thesis_hook_faux_admin', 'openhook_faux_admin');
add_action('thesis_hook_archive_info', 'openhook_archive_info');
add_action('thesis_hook_404_title', 'openhook_404_title');
add_action('thesis_hook_404_content', 'openhook_404_content');
add_action('thesis_hook_before_sidebars', 'openhook_before_sidebars');
add_action('thesis_hook_after_sidebars', 'openhook_after_sidebars');
add_action('thesis_hook_multimedia_box', 'openhook_multimedia_box');
add_action('thesis_hook_after_multimedia_box', 'openhook_after_multimedia_box');
add_action('thesis_hook_before_sidebar_1', 'openhook_before_sidebar_1');
add_action('thesis_hook_after_sidebar_1', 'openhook_after_sidebar_1');
add_action('thesis_hook_before_sidebar_2', 'openhook_before_sidebar_2');
add_action('thesis_hook_after_sidebar_2', 'openhook_after_sidebar_2');
add_action('thesis_hook_before_footer', 'openhook_before_footer');
add_action('thesis_hook_after_footer', 'openhook_after_footer');
add_action('thesis_hook_footer', 'openhook_footer');
add_action('wp_footer', 'openhook_wp_footer');

add_action('wp_head', 'openhook_remove_actions');

?>