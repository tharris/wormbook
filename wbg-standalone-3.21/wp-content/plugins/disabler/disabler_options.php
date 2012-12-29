<div class="wrap">

<h2>Disabler</h2>

<p>Here's where you can disable whatever you want.</p>

<?php
global $wpdb;

        if (isset($_POST['update']))
        {
                if ($new_smartquotes = $_POST['new_smartquotes'])       // Texturization
					{ update_option('disabler_smartquotes', $new_smartquotes); }
                else { update_option('disabler_smartquotes', '0'); }           
                if ($new_capitalp = $_POST['new_capitalp'])             // Capital P
					{ update_option('disabler_capitalp', $new_capitalp); }
                else { update_option('disabler_capitalp', '0'); }
                if ($new_autop = $_POST['new_autop'])                	// AutoP
					{ update_option('disabler_autop', $new_autop); }
                else { update_option('disabler_autop', '0'); }
                if ($new_autop = $_POST['new_adminbar'])                	// Admin Bar
					{ update_option('disabler_adminbar', $new_adminbar); }
                else { update_option('disabler_adminbar', '0'); }
                
                if ($new_selfping = $_POST['new_selfping'])             // SelfPing
					{ update_option('disabler_selfping', $new_selfping); }
                else { update_option('disabler_selfping', '0'); }
                if ($new_norss = $_POST['new_norss'])             // RSS
					{ update_option('disabler_norss', $new_norss); }
                else { update_option('disabler_norss', '0'); }				
				if ($new_autosave = $_POST['new_autosave'])                // AutoSaves
					{ update_option('disabler_autosave', $new_autosave); }
                else { update_option('disabler_autosave', '0'); }
				if ($new_revisions = $_POST['new_revisions'])                // Post Revisions
					{ update_option('disabler_revisions', $new_revisions); }
                else { update_option('disabler_revisions', '0'); }

				if ($new_version = $_POST['new_version'])               // Version
					{ update_option('disabler_version', $new_version); }
                else { update_option('disabler_version', '0'); }
				if ($new_nourl = $_POST['new_nourl'])                	// Phone Home URL
					{ update_option('disabler_nourl', $new_nourl); }
                else { update_option('disabler_nourl', '0'); }


?>
        <div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>
<?php
        }

        if (get_option('disabler_smartquotes') != '0' )
			{ $smartquotes = ' checked="checked"'; } 
			else { $smartquotes = ''; }
		if (get_option('disabler_capitalp') != '0' )
			{ $capitalp = ' checked="checked"'; } 
			else { $capitalp = ''; }
		if (get_option('disabler_autop') != '0' )
			{ $autop = ' checked="checked"'; } 
			else { $autop = ''; }	
		if (get_option('disabler_adminbar') != '0' )
			{ $adminbar = ' checked="checked"'; } 
			else { $adminbar = ''; }	

		if (get_option('disabler_selfping') != '0' )
			{ $selfping = ' checked="checked"'; } 
			else { $selfping = ''; }
		if (get_option('disabler_norss') != '0' )
			{ $norss = ' checked="checked"'; } 
			else { $norss = ''; }
		if (get_option('disabler_autosave') != '0' )
			{ $autosave = ' checked="checked"'; } 
			else { $autosave = ''; }		
		if (get_option('disabler_revisions') != '0' )
			{ $revisions = ' checked="checked"'; } 
			else { $revisions = ''; }		
		
		if (get_option('disabler_version') != '0' )
			{ $version = ' checked="checked"'; } 
			else { $version = ''; }		
		if (get_option('disabler_nourl') != '0' )
			{ $nourl = ' checked="checked"'; } 
			else { $nourl = ''; }		
?>

<form method="post" width='1'>

<h3>Front End Settings</h3>

<p>These are settings are changes on the front end. These are the things that affect what your site looks like when other people visit. What THEY see.  While these are actually things that annoy <strong>you</strong>, it all comes back to being things on the forward facing part of your site.</p>

<fieldset class="options">
<p> <input type="checkbox" id="new_smartquotes" name="new_smartquotes" value="1" <?php echo $smartquotes ?> /> Disable Texturization -- smart quotes (a.k.a. curly quotes), em dash, en dash and ellipsis.</p>
</fieldset>

<?php
        $blog_version = get_bloginfo('version');
        if ( $blog_version >= '3.0' )
		{ ?>
<fieldset class="options">
<p> <input type="checkbox" id="new_capitalp" name="new_capitalp" value="1" <?php echo $capitalp ?> /> Disable auto-correction of WordPress capitalization.</p>
</fieldset>
<?php } ?>


<fieldset class="options">
<p> <input type="checkbox" id="new_autop" name="new_autop" value="1" <?php echo $autop ?> /> Disable paragraphs (i.e. &lt;p&gt;  tags) from being automatically inserted in your posts.</p>
</fieldset>

<?php
        $blog_version = get_bloginfo('version');
        if ( $blog_version >= '3.1' )
		{ ?>
<fieldset class="options">
<p> <input type="checkbox" id="new_adminbar" name="new_adminbar" value="1" <?php echo $adminbar ?> /> Disable WordPress admin bar.</p>
</fieldset>

<p>If you want to turn this off sitewide, you should use <a href="http://wordpress.org/extend/plugins/disable-admin-bar/">Ozh's Disable Admin Bar</a> plugin instead.</p>
<?php } ?>

<h3>Back End Settings</h3>

<p>Back End settings affect how WordPress runs. Nothing here will <em>break</em> your install, but some turn off 'desired' functions.</p>

<fieldset class="options">
<p> <input type="checkbox" id="new_selfping" name="new_selfping" value="1" <?php echo $selfping ?> /> Disable self pings (i.e. trackbacks/pings from your own domain).</p>
</fieldset>

<fieldset class="options">
<p> <input type="checkbox" id="new_norss" name="new_norss" value="1" <?php echo $norss ?> /> Disable all RSS feeds.</p>
</fieldset>

<fieldset class="options">
<p> <input type="checkbox" id="new_autosave" name="new_autosave" value="1" <?php echo $autosave ?> /> Disable auto-saving of posts.</p>
</fieldset>

<fieldset class="options">
<p> <input type="checkbox" id="new_revisions" name="new_revisions" value="1" <?php echo $revisions ?> /> Disable post revisions. (If you need more granual revision control, consider the plugin <a href="http://wordpress.org/extend/plugins/revision-control/">Revision Control</a>)</p>
</fieldset>

<h3>Privacy Settings</h3>

<p>These settings help obfuscate information about your blog to the world (inclyding to Wordpress.org). While they don't protect you from anything, they do make it a little harder for people to get information about you and your site.</p>

<fieldset class="options">
<p> <input type="checkbox" id="new_version" name="new_version" value="1" <?php echo $version ?> /> Disable WordPress from printing it's version in your headers (only seen via View Source).</p>
</fieldset>

<fieldset class="options">
<p> <input type="checkbox" id="new_nourl" name="new_nourl" value="1" <?php echo $nourl ?> /> Disable WordPress from sending your URL information when checking for updates.</p>
</fieldset>

<p>If you need to totally disable WordPress' ability to 'phone home', please use these plugins:</p>
<ul>
  <li><a href="http://wordpress.org/extend/plugins/disable-wordpress-core-update/">Disable Core Update Notifications</a></li>
  <li><a href="http://wordpress.org/extend/plugins/disable-wordpress-plugin-updates/">Disable WordPress Plugin Updates</a></li>
  <li><a href="http://wordpress.org/extend/plugins/disable-wordpress-theme-updates/">Disable WordPress Theme Updates</a></li>
</ul>

</fieldset>
        <p class="submit"><input type="submit" name="update" value="Update Options" /></p>
</form>

</div>