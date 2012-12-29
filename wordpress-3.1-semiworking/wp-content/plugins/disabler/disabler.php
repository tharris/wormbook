<?php
/*
Plugin Name: Disabler
Plugin URI: http://code.ipstenu.org/disabler/
Description: Instead of installing a million plugins to turn off features you don't want, why not use ONE plugin?
Version: 1.2
Author: Mika Epstein
Author URI: http://ipstenu.org/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

/* FRONT END SETTINGS */
/* Texturization */
if (get_option('disabler_smartquotes') != '0' ) {
	remove_filter('comment_text', 'wptexturize');
	remove_filter('the_content', 'wptexturize');
	remove_filter('the_excerpt', 'wptexturize');
	remove_filter('the_title', 'wptexturize');
	}
/* Disable Capital P in WordPress auto-correct */
if (get_option('disabler_capitalp') != '0' ) {
	remove_filter('the_content','capital_P_dangit');
	remove_filter('the_title','capital_P_dangit');
	remove_filter('comment_text','capital_P_dangit');
	}
/* Remove the <p> from being automagically added in posts */
if (get_option('disabler_autop') != '0' ) {
	remove_filter('the_content', 'wpautop');
	}

/* 3.1 Admin Bar -- http://wordpress.org/extend/plugins/disable-admin-bar/ */
if (get_option('disabler_adminbar') != '0' ) {
	remove_action( 'init', 'wp_admin_bar_init' );
	}
	
/* BACK END SETTINGS */
/* Disable Self Pings */
if (get_option('disabler_selfping') != '0' ) {
	function no_self_ping( &$links ) {
		$home = get_option( 'home' );
		foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, $home ) )
               unset($links[$l]);
		}
	add_action( 'pre_ping', 'no_self_ping' );
	}
/* No RSS */
if (get_option('disabler_norss') != '0' ) {
	function disabler_kill_rss() {
		wp_die( __('No feeds available, please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
	}
 
	add_action('do_feed', 'disabler_kill_rss', 1);
	add_action('do_feed_rdf', 'disabler_kill_rss', 1);
	add_action('do_feed_rss', 'disabler_kill_rss', 1);
	add_action('do_feed_rss2', 'disabler_kill_rss', 1);
	add_action('do_feed_atom', 'disabler_kill_rss', 1);
	}
/* Post Auto Saves */
if (get_option('disabler_autosave') != '0' ) {
	
	function disabler_kill_autosave(){
		wp_deregister_script('autosave');
		}
	add_action( 'wp_print_scripts', 'disabler_kill_autosave' );
	}
/* Post Revisions */
if (get_option('disabler_revisions') != '0' ) {
	remove_action ( 'pre_post_update', 'wp_save_post_revision' );
	}

	
/* PRIVACY SETTINGS */	
/* Remove WordPress version from header */
if (get_option('disabler_version') != '0' ) {
	remove_action('wp_head', 'wp_generator');
	}
/* Hide blog URL from Wordpress 'phone home' */
if (get_option('disabler_nourl') != '0' ) {
	function disabler_remove_url($default)
		{
  		global $wp_version;
  		return 'WordPress/'.$wp_version;
		}
	add_filter('http_headers_useragent', 'disabler_remove_url');
	}

	
// Create the options when turned on
function disabler_activate() {
        update_option('disabler_smartquotes', '0');
        update_option('disabler_capitalp', '0');
        update_option('disabler_autop', '0');
        update_option('disabler_adminbar', '0');

        update_option('disabler_selfping', '0');
        update_option('disabler_norss', '0');
        update_option('disabler_revisions', '0');
        update_option('disabler_autosave', '0');

        update_option('disabler_version', '0');
        update_option('disabler_nourl', '0');
}

// Delete the options if the plugin is being turned off (pet peeve)
function disabler_deactivate() {
        delete_option('disabler_smartquotes');
        delete_option('disabler_capitalp');
        delete_option('disabler_autop');
		delete_option('disabler_adminbar');

        delete_option('disabler_selfping');
        delete_option('disabler_norss');
        delete_option('disabler_revisions');
        delete_option('disabler_autosave');

        delete_option('disabler_version');
        delete_option('disabler_nourl');
}

// Load the options page
function disabler_options() {
        if (function_exists('add_submenu_page')) {
          add_submenu_page('options-general.php', 'Disabler', 'Disabler', '8', 'disabler/disabler_options.php');
        }
}


// Hooks
add_action('admin_menu', 'disabler_options');

register_activation_hook( __FILE__, 'disabler_activate' );
register_deactivation_hook( __FILE__, 'disabler_deactivate' );
	
?>
