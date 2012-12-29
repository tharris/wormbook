=== Ambrosite Next/Previous Post Link Plus ===
Contributors: ambrosite
Donate link: http://www.ambrosite.com/plugins
Tags: adjacent, next, previous, post, link, links, sort, sorted, sortable, order, reordered, thumbnail, thumbnails, truncate, loop
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: trunk

Upgrades the next/previous post link functions to reorder or loop adjacent post navigation links, display post thumbnails, and truncate link titles.

== Description ==

**IMPORTANT: If you are upgrading from plugin version 1.1, you will need to update your templates** (see the instructions below on configuring parameters). If you still need version 1.1, the file and documentation may be downloaded here:
http://www.ambrosite.com/download/ambrosite-nextprevious-post-link-plus.1.1.zip

This plugin creates two new template tags -- **next_post_link_plus** and **previous_post_link_plus** -- which are upgraded versions of the core WordPress next/previous post link template tags. The new tags include all of the functionality of the core tags, plus the following additional options:

* Sort the next/previous post links on columns other than post_date (e.g. alphabetically).
* Sort the next/previous links on custom fields.
* Loop around to the first post if there is no next post (and vice versa).
* Truncate the link titles to any length, and display the full titles in the tooltip.
* Display post thumbnails alongside the links (WordPress 2.9 or higher).
* Return multiple next/previous links (e.g. the next N links, in an HTML list).
* Optionally display the category of the next/previous links.
* Return false if no next/previous post is found, so themes may conditionally display alternate text.
* Full WordPress 3.0 compatibility, including support for custom post types, and custom taxonomies.

The most important difference from the core next/previous functions is that the parameters must be passed either as an array definition (recommended):

`<?php next_post_link_plus( array(
                    'order_by' => 'post_date',
                    'meta_key' => '',
                    'loop' => false,
                    'thumb' => false,
                    'max_length' => 0,
                    'format' => '%link &raquo;',
                    'link' => '%title',
                    'before' => '',
                    'after' => '',
                    'in_same_cat' => false,
                    'ex_cats' => '',
                    'num_results' => 1,
                    'echo' => true
                    ) ); ?>`

Or as a URL query style string (the 'format' and 'link' parameters cannot be specified using a query string, and *true* and *false* must be specified as '1' and '0'):

`<?php next_post_link_plus('order_by=post_date&meta_key=&loop=0&thumb=0&max_length=0&in_same_cat=1&excats=&num_results=1&echo=1'); ?>`

The above parameters show the default usage. The benefit of the wp_parse_args approach is that you need only specify a parameter when you want to override the defaults. Note that this is the same way arguments work for the query_posts, wp_list_pages, and wp_list_categories functions.

= Parameters =

**order_by**
If you are using either the query_posts function, or a plugin like postMash or Query Posts Widget to display your posts in alphabetical order (or in any order besides reverse chronological), then you will want your next/previous post links to cycle through the posts in the same order. The order_by parameter specifies which column should be used to sort the next/previous post links. The following are valid values:

post_date, post_title, post_excerpt, post_name, post_modified, ID, post_author, post_parent, menu_order, comment_count, custom

For example, to move through the posts in alphabetical order:

`<?php next_post_link_plus( array('order_by' => 'post_title') ); ?>`

You may set order_by to 'custom' to sort on a custom field (see below).

**meta_key**
Specifies which custom field to use for a custom sort. Posts not having that custom field are excluded. For example, to sort the next/previous post links on the custom field 'event_date':

`<?php next_post_link_plus( array('order_by' => 'custom', 'meta_key' => 'event_date') ); ?>`

If no meta_key is specified, 'custom' is ignored and the function defaults to sorting on post date.

**loop**
If loop is set to *true* (or 1), then the next post link will loop around to the first post if there is no next post (and vice versa). The default is *false* (no looping). For example, if I want the next post link to lead back to "Alligator" once I get to "Zebra":

`<?php next_post_link_plus( array('order_by' => 'post_title', 'loop' => true) ); ?>`

**thumb**
Displays the post thumbnail alongside the next/previous link. The default is *false* (no post thumbnail). Note that you may specify the thumbnail size to display. Valid values are *true* (i.e. the 'post-thumbnail' size), as well as all size values accepted by wp_get_attachment_image (e.g. 'thumbnail', 'medium', 'large', 'full').

Display the default 'post-thumbnail' size image:

`<?php next_post_link_plus( array('thumb' => true) ); ?>`

Display the 'medium' size image:

`<?php next_post_link_plus( array('thumb' => 'medium') ); ?>`

The thumbnail and link are given CSS classes named 'post-thumbnail' and 'post-link' to add in styling. By default, they appear next to each other, however if you want the link to appear underneath the thumbnail, add the following styles to your CSS file:

`.post-thumbnail { float: left; }
.post-link { float: left; clear: left; }`

**max_length**
Truncates the post titles to the nearest whole word under the length you specify, while adding three dots at the end to signify that the title was trimmed. Default is zero (do not truncate). For example:

`<?php next_post_link_plus( array('max_length' => 25) ); ?>`

This will trim *The New York Giants Win Super Bowl XLII in Overtime* to *The New York Giants Win...* The full title will be displayed in the tooltip when the mouse hovers over the link.

**before and after**
Text to place before and after the link(s). If no links are found, the before/after text is not displayed. Especially useful for formatting multiple links (see example below).

**num_results**
Returns multiple next/previous links. Default is 1. If this parameter is set to a value greater than 1, the next/previous links will be wrapped in `<li>` tags; you should surround them with `<ul>` tags by setting the 'before' and 'after' parameters. For example:

`<?php previous_post_link_plus( array(
                         'order_by' => 'post_date',
                         'format' => '%link',
                         'link' => '%title',
                         'before' => '<h4>Older posts</h4><ul>',
                         'after' => '</ul>',
                         'in_same_cat' => true,
                         'num_results' => 3
                    ) );?>`

**format, link, in_same_cat, ex_cats**
These parameters work exactly the same as described in the WordPress Codex, with one difference: There is now an extra variable **%category** that may be used in the 'format' parameter to list all categories to which a post belongs. Expanding on the previous example:

`<?php previous_post_link_plus( array(
                         'order_by' => 'post_date',
                         'format' => '%link (posted in %category on %date)',
                         'link' => '%title',
                         'before' => '<h4>Older posts</h4><ul>',
                         'after' => '</ul>',
                         'max_length' => 35,
                         'in_same_cat' => false,
                         'num_results' => 3
                    ) );?>`

**The return value**
This makes it much easier to create alternate styles in the event that no next/previous post is found. For example, if you wanted to have grayed out inactive links, you can simply test the return value as follows:

`<?php if ( !previous_post_link_plus() ) {
    echo '<span class="inactive">&laquo; Previous</span>'; // if there are no older articles
} ?>`

Note that if the $loop parameter is set to 'loop', the function will never return false, since an adjacent post will always be found.

**echo**
If 'echo' is set to *false*, the functions will not produce any output. Rather, they will simply return true/false depending on whether any links were found. This is in response to an enhancement request made in Trac ticket #13489 (although in many cases the 'before' and 'after' parameters can be used to solve the problem reported there).

**Complete Example**
The following pair of template tags cycle through all posts in alphabetical order, within the same category, with looping, but no post thumbnails, using the default link title and format, and truncating the title to the nearest whole word under 30 characters:

`<?php previous_post_link_plus( array('order_by' => 'post_title', 'loop' => true, 'max_length' => 30, 'in_same_cat' => true) ); ?> | <?php next_post_link_plus( array('order_by' => 'post_title', 'loop' => true, 'max_length' => 30, 'in_same_cat' => true) ); ?>`

== Installation ==

* Upload ambrosite-post-link-plus.php to the /wp-content/plugins/ directory.
* Activate the plugin through the Plugins menu in WordPress.
* Edit your single.php file (plus any other single post template files you may have created), and replace the next_post_link and previous_post_link template tags with next_post_link_plus and previous_post_link_plus. Configure them using parameters as explained above.

== Frequently Asked Questions ==

= Is there any way to use an image instead of link text? =

Yes. First of all, if you are using WordPress 2.9 or higher, the plugin has built-in support for post thumbnails, so you should consider using them. Otherwise, something like this will work:

`<?php previous_post_link_plus( array(
                         'format' => '%link',
                         'link' => '<img src="images/prev.png" />'
                    ) );?>
<?php next_post_link_plus( array(
                         'format' => '%link',
                         'link' => '<img src="images/next.png" />'
                    ) );?>`

== Changelog ==

= 2.0 =
* Full WordPress 3.0 compatibility, including custom post types.
* Rewrote the plugin using wp_parse_args to simplify the function calls.
* Added option to sort the next/previous links on custom fields.
* Added option to return multiple next/previous links.
* Fix for custom taxonomies.
* Added %category variable to the format parameter.
* Added 'before' and 'after' parameters.
* Added support for post thumbnail sizes.
* Added 'echo' parameter.

= 1.1 =
* Added truncate link title and loop options.
* Added support for post thumbnails.

= 1.0 =
* Initial version.
