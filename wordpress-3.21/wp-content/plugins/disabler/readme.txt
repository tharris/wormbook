=== Disabler ===
Tags: disable, options, features
Contributors: ipstenu
Requires at least: 2.8
Tested up to: 3.1
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973
Stable tag: 1.2

Instead of installing a million plugins to turn off features you don't want, why not use ONE plugin?

== Description ==

I don't like certain things, like curly 'smart' quotes and self pings.  Instead of installing six or seven plugins to do this, I thought I'd make one plugin to cover the usual suspects.  Instead of just disabling everything, Disabler lets you pick and choose what settings you want turned off, in a dead simple UI.

This plugin will let you disable/remove the following features:

**Front End Settings**

* Texturization (including Smart/Curly quotes, EM dash, EN dash, and ellipsis)
* The automatic capitalization of the P in WordPress (WordPress 3.0+ only)
* The &lt;p&gt; that is automatically inserted in 
* Admin Bar (WordPress 3.1+ only)

**Back End Settings**

* Self Ping
* Autosaving of posts
* Post Revisions
* RSS Feeds

**Privacy Settings**

* Outputting WordPress version in your blog headers
* Sending your blog URL to WordPress when checking for updates on core/theme/plugins

All options default to off, and get cleaned up on uninstall.


* [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973)
* [Plugin Site](http://code.ipstenu.org/ban-hammer/)


==Changelog==
A giant thank you to everyone at http://wptavern.com for suggestions about what to add to this plugin.

= 1.0 - 24 November, 2010 = 

* Making it copacetic for 3.1!
* Re-renamed Typography back to Front End
* Added in removal of Admin Bar for 3.1 (thanks Ozh!)

= 0.4 - 14 July, 2010 =

* Typo! Post revisions wouldn't stay checked.  Thanks to utdemir for the catch!

= 0.3 - 13 July, 2010 =

* Renamed Front End to Typography

= 0.2 - 9 July, 2010 =

* Added in privacy and backend settings.

= 0.1 - 8 July, 2010 =

* Initial version.

== Installation ==

1. Unpack the *.zip file and extract the `/disabler/` folder and the files.
2. Using an FTP program, upload the full `/disabler/` folder to your WordPress plugins directory (Example: `/wp-content/plugins/`).
3. Go to Plugins > Installed and activate the plugin.

== To Do ==
* Find 'everything' you can disable.

== Frequently Asked Questions ==

= Will this work on older versions of WordPress? =

I tried to make it backwards compatible (that is, you can't disable the capital P in WordPress checker if you're NOT on WordPress 3.0 or higher), but I didn't bother coding anything for pre-2.8 WordPress.  You should upgrade.

= Will this work on MultiSite? =
In my rough testing, yes.  It even works network wide AND in the mu-plugins, though personally, I'd let people decide if they want it or not for their blogs. Activate it network wide, let people decide how they want to impliment it.

Remember, EVEN if you activate this site wide, the DEFAULT per blog is for the settings to be OFF. So if you want them on for each site without the option to change, then this is NOT the plugin for you. Sorry.

=Can you add in Feature X? =
Probably. Tell me what you want to add and I'll see if I can do it.

== Screenshots ==
1. Standard View
2. Options checked