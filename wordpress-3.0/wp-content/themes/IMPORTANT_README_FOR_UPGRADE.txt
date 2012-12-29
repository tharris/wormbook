The entire contents of the following files/directories need to be preserved:

custom/                   // Preserve the entire contents

I don't think this was necessary in Thesis 1.8
lib/html/content_box.php      // COMMENTED OUT thesis_sidebars() in thesis_columns(). Still being called on archive pages.



INstall thesis:
Set columns to 1, width 800 px (first set sidebar cols to 0px, then select 1 column!)
Set pages to include in navigation: citing, archives, submit



Plugins for custom post types (and admin meta write boxes)

- Verve Meta Boxes + Custom Post Types UI
- Custom Field Types
-Magic Fields



Here are some helpful tips on creating custom write panels.
http://www.kevinleary.net/6-ways-to-create-custom-write-panels-in-wordpress/



2. Adminimize plugin - hide a whole bunch of things for Contributors

   Contributors should only see the title and WBG custom fields, nothing else.

   Other Plugins:
       (Post Control - used to hide options on the Contributor write panel  no longer required)




3. Allow contributors to upload files: custom/custom_functions.php
   http://wordpress.org/support/topic/allow-contributor-to-upload-media

if ( current_user_can('contributor') && !current_user_can('upload_files') )
   add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
	 $contributor = get_role('contributor');
	 $contributor->add_cap('upload_files');
}

4. Customize the login screen (see custom functions.php)

Add a function to custom_functions.css. This adds the image and sets up a custom_login.css file

Add and configure plugin Register Plus, including reCAPTCHA.

Note that I am maintingina the styling information outside of Register Plus in custom_login.css




5. Enable custom javascript (not added to admin sections, unfortunately)...
see custom_functions.php
http://www.customizethesis.com/adding-custom-javascript/
Other thesis tips:
http://www.customizethesis.com/




PodsCMS information
custom fields or pods CMS
http://www.mikevanwinkle.com/wordpress/wordpress-as-cms-pods-or-custom-fields/
