=== WP-CMS Post Control ===
Contributors: Jonnyauk
Tags: post, page, metabox, autosave, revisions, flash, uploader, cms, Tags, Categories, Excerpt, Trackbacks, Custom fields, Discussion, Comment, ping, Author, upload
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 2.3

Hides unwanted items within the write/edit page and post admin area for each user role. Also controls autosave, revisions and flash uploader.

== Description ==

**Post Control** from <a href="http://wp-cms.com/">WordPress CMS Modifications</a> gives you complete control over your write options **for every user level/role**. It not only allows you to hides unwanted items like custom fields, trackbacks, revisions etc. but also gives you a whole lot more control over how WordPress deals with creating content.

Simplify the and customise the write post and page areas of WordPress and just show the controls you need. Great for de-cluttering - do you really need those pingback and trackback options... now you can decide what level of users can see and use!

You can also disable autosaves, revisions and disable the Flash uploader.

**NEW** - Control how many revisions are saved when you are amending your content - stops your database getting clogged up!

You can control the display of the following post options for each role level (administrator, editor, author and contributor):

* Post Tags
* Post Categories
* Post Excerpt
* Post Trackbacks
* Post Custom Fields
* Post Discussion
* Post Comment & Ping Options
* Post Author

You can control the display of the following page options:

* Page Custom Fields
* Page Discussion
* Page Comment & Ping Options
* Page Attributes

You can control the display of the following global post/page options:

* **NEW** - Limit the number of post and page revisions saved
* Post/Page Media upload
* Disable Autosave
* Disable Post Revisions
* Disable flash uploader and just use browser uploader

== Installation ==

= First time install =

You can use the built-in WordPress add plugin system to install Post Control once logged into your site, it's quick and easy!

If you want to manually upload and install:

1. Get the latest version of this plugin at the <a href="http://wordpress.org/extend/plugins/wp-cms-post-control/">official WordPress plugin directory</a>.
2. Decompress .zip file, retaining file structure.
3. Upload directory `wp-cms-post-control` and all containing files to your plugins directory - normally `/wp-content/plugins/`
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure options through `Settings > Post Control`

= Update existing install =

The automatic plugin update feature of WordPress works fine with this plugin. If your server supports it you should certainly use this as it's the easiest way to keep your plugins up-to-date.

If you are updating via FTP, simply delete the entire folder called 'wp-cms-post-control' from your plugins directory and replace with the newest version.

**IMPORTANT** When you upgrade, you should go to the options page and re-save your Post Control options to refresh the settings. In most cases everything will be fine, but this will ensure that if there have been any updates to WordPress the plugin will refresh and update the relevant Post Control options.

== Frequently Asked Questions ==

= I'm using v2.2x with WordPress 3.0 - post options work but the page options do nothing! =

2.3 (and above) fixes this glitch in WordPress 3.0 - with the introduction of custom post types things have changed a bit and I have now amended the plugin to accommodate this.

= I'm using v2.2x with WordPress 2.9 (or below) - post options and/or other things don't work! =

2.22 was the last version with WordPRess 2.9 conpatibility. If you are using an earlier version of WordPress you really should upgrade - you get lots of cool new stuff and a faster, smarter WordPress!

= I'm using v2.x and I have some error messages appear at the top of the screen. =

2.2 (and above) fixes this glitch - thanks for the feedback!

= I used versions of this plugin prior to v2 and sometimes the controls wouldn't re-appear once deactivated. =

2.0 and above is a complete re-write using a new method to remove the controls. Because of this, these issues are now completely resolved.

= Can you change the options for any user role? =

**YES!** Administrators, editors, authors and contributors can all have different settings.

= Can devious users still reveal the controls if they are hidden using tools like Firebug? =

**NO!** All of the core controls are removed in a completely different way now - not just hidden with CSS. They can't be revealed by hacking the browser rendered CSS, as they are not even rendered to the page anywhere!

= What options get used if I hide a control - like pingbacks and trackbacks? =

The global options you set in the main WordPress options are used.

= How do I delete the option(s) out of my database permanently? =

In v2.1 and above just dectivate the plugin and then delete it using the WordPress plugin page option (not just of your server via FTP!). When the plugin is deleted through WordPress, it also deletes the option(s) from the database options table that are created.

= What happens if I activate/deactivate this plugin? =

In v2.1 the options are set to be persistent - so if you deactivate the plugin and re-enable it, the settings will remain saved. Delete the plugin to delete the saved database options.

= I installed v.2.0 and I dont have autosave and other options =

These are now restored in v2.1 and above. Click on the **core functions** link at the top of the screen, or **Post Control Core** in the sidebar under **Settings** to turn off autosaves, revisions and the Flash uploader.

= It's not working! =

**Make sure you are using the latest version!** V2.0+ is designed for WordPress 2.9 and above. If you are using a version older than that, you will have to use an older version of the plugin - and really should think about upgrading, this plugin is ready for you!

Ensure you have the plugin installed in the correct directory - you should have a directory called **wp-cms-post-control** in your plugins directory. Inside there should be another directory called **inc**.

= What you got planned? =

I've got quite a few things I'd like to do with this plugin, but don't hold your breath waiting for them to happen... you may burst!

= Wow, good work - I LOVE this plugin, and you did it all by yourself? =

What began as inherited code has now been completely re-written in v2.0 to use new methods and best practices in WordPress plugin development by Jonny. The first codebase began as a plugin build by Brady J. Frey and I maintained this version for some time, but version 2 is a complete re-write from the ground up.

== Screenshots ==

1. The first post control admin screen where the main options are set for each user level.
2. The core functions option screen, where more advanced WordPress controls are set.
3. An example of a customised write/edit page - much simpler to use for all your users and clients!
4. An example of a customised write/edit post - much simpler to use for all your users and clients!

== Changelog ==

= 2.3 =
* 31th July 2010
* REQUIRES WORDPRESS 3.0 OR ABOVE
* Fully tested and compatible with WordPress 3.0 post and page editors
* Fixed another bug with no values set
* Compatibility with WordPress 3.0 page editing

= 2.22 =

* 18th June 2010
* LAST VERSION TO BE COMPATIBILE WITH WORDPRESS 2.9
* WordPress 3.0 first pass compatibility

= 2.21 =
* 16th June 2010
* Tested upto WordPress 3.0-RC3
* Amended roles and capabilities
* Fully prepared and ready for WordPress 3.0 launch, whoot!

= 2.2 =
* 12th June 2010
* Bug that caused error messages when no options selected fixed
* Introduced new revisions number control

= 2.12 =
* 23th March 2010
* Bug that caused error messages fixed

= 2.11 =
* 22th March 2010
* Bug hunt

= 2.1 =
* 22th March 2010
* Added new Core Functions sub-menu page
* Added new disable autosave control
* Added new disable revisions control
* Added new disable flash uploader control
* Added cleanup of options on delete of plugin (not deactivation)

= 2.01 =
* 20th March 2010
* Fixed bug when values empty
* Amended data sanitisation input

= 2.0 =
* 19th March 2010
* Complete re-write of codebase = major efficiency improvements
* New code eliminates all previous reported user issues
* WordPress 2.9.2 compatibility updates
* Introduced multi-user level controls
* New remove media upload control

= v1.2.1 =
* 31st March 2009
* WordPress 2.7 author control

= v1.2 =
* 17th December 2008
* WordPress 2.7 compatibility build, re-write plugin controls to support new 'Crazy Horse' interface
* Fix basic text formatting in custom message box, remove strip slashes to allow basic formatting like <b> and <i>
* Changed option array function for more control
* Changed formatting of plugin options buttons

= v1.11 =
* 6th September 2008
* Option to hide editor sidebar shortcuts and 'Press It' function
* Remove redundant preview code
* Improved formatting for message box text and title input

= v1.1 =
* 5th September 2008
* Found potential conflict with options variables declared within a theme functions file
* Conflicting PHP variables for reference - 'options' and 'newoptions'
* Should solve conflicts with wrongly coded variables from other plugins/themes

= v1.03 =
* 4th September 2008
* Fix the bug introduced in v1.02 that broke the form fields
* After comments feedback, changed and documented admin control

= v1.02  =
* 3rd September 2008
* Bug catches, may help plugin compatibility on different servers

= v1.01 =
* 2nd August 2008
* Option to insert message panel
* General tidying on admin page

= v1.0  =
* 1st August 2008
* Option to disable post and page revisions
* Option to disable autosaves

= v0.4  =
1st August 2008
* Option to select uploader (Flash or standard)
* Option to hide revisions control
* Option to hide word count
* Option to hide Advanced Options header
* Fixed page custom field control
* Redesigned admin page

= v0.3 =
* 28th July 2008
* Introduced Admin user control.

= v0.2 =
* 26th July 2008
* Included clean-up of database on de-activation.

== Upgrade Notice ==

= 2.3 =
REQUIRES WORDPRESS 3.0 or above - please update to fix page controls bug!

= 2.22 =
Please upgrade for full WordPress 3.0 compatibility and get the new feature of limiting post revisions!

= 2.21 =
Please upgrade to fix minor bug and get the new feature of limiting post revisions!

= 2.2 =
Please upgrade to fix minor bug and get the new feature of limiting post revisions!

= 2.12 =
Please upgrade for bug fixes!

= 2.11 =
Please upgrade for bug fixes!

= 2.1 =
Please upgrade to get new features!

= 2.01 =
Please upgrade to the latest version with full WordPress 2.9 and above compatibility and to fix previous user issues reported.

= 2.0 =
Please upgrade to the latest version with full WordPress 2.9 and above compatibility and to fix previous user issues reported.