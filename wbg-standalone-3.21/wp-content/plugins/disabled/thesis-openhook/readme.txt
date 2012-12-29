=== Thesis OpenHook ===
Contributors: KingdomGeek
Tags: theme, customization, functions, display, Thesis, diythemes
Requires at least: 2.7
Tested up to: 2.8
Stable tag: trunk

This plugin allows you to insert arbitrary content into the many hooks that the Thesis Theme Framework provides. Never again edit a file!

== Description ==

Thesis OpenHook takes the process of modifying <a href="http://get-thesis.com/">Thesis</a> and simplifies it!

Where once users would be required to open and modify their `wp-content/themes/thesis/custom/custom_functions.php` file, users can now easily customize Thesis via a new “Thesis OpenHook” panel in the Design area of your blog administration.

Not only can arbitrary HTML, CSS, JavaScript, and even PHP be inserted into any of Thesis' hooks, you can also easily remove any of the hooked default elements within Thesis with the click of a button!

If you don't use Thesis, there's probably no reason you need to get this plugin, except to learn from (or port to another theme).

Thesis OpenHook is based heavily upon <a href="<a href="http://xentek.net/code/wordpress/plugins/k2-hook-up/">K2 Hook Up</a>.

== Installation ==

After you have downloaded the file and extracted the `thesis-openhook/` directory from the archive...

1. Upload the entire `thesis-openhook/` directory to the `wp-content/plugins/` directory.
1. Activate the plugin through the Plugins menu in WordPress.
1. Visit Design -> Thesis OpenHook and customize to your heart's content!

== Frequently Asked Questions ==

= I don't use Thesis; can I still use this plugin? =

Yes, but chances are, it won't do anything for you. Thesis' hooks are unique to Thesis, and this plugin relies on those hooks being present.

= What about the code in my custom_functions.php file? =

If you have already modified Thesis via custom_functions.php, you are welcome to port those changes into Thesis OpenHook to manage all of your changes in one place.

Note that your blog will use *both* custom_functions.php and Thesis OpenHook, so the two are complementary.

Likewise, custom_functions.php will be processed *after* Thesis OpenHook, so you can override Thesis OpenHook via the custom functions file, if you need to.

= Why can't I modify custom.css via OpenHook? =

Assuming all of the following things... Yes you can!

* `custom.css` must exist and be writable by the Web server (CHMOD to "666" via FTP)
* User must be allowed to edit themes

= Where can I get Thesis? =

You want to take your blog to the next level? Good for you! Grab Thesis at <a href="http://get-thesis.com/">Get-Thesis.com</a>.

== Changelog ==

= 2.2.5 =
* Reverted change introduced in 2.2.3 regarding stripping of slashes

= 2.2.4 =
* Fixed a syntax error, reported by multiple users.

= 2.2.3 =
* Fixed a bug which prevented the After Teasers Box hook from saving properly. Thanks, Michael Curving.
* Fixed an issue where the file editors would strip slashes unnecessarily. Thanks, Kristarella.