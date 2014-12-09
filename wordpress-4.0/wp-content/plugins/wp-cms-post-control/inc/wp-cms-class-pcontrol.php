<?php

class wpcms_pcontrol {

	/**
	* Removes meta boxes from the page admin area
	* Executes on 'edit page' and 'new page'
	*
	* @since 2.0
	* @lastupdate 2.0
	*
	*
	*/
	function pccore_page() {

		// Load up common functions and helpers class
		$wpcms_pcpage_doit = new wpcms_pcontrol_engine;

		// Get user level and load options
		$myrole = $wpcms_pcpage_doit->pcore_userrole();
		$options = get_option('wpcms_pcontrolopts');
		$boxes = $options['pc_'.$myrole.'_pageops'];
		$extraops = $options['pc_'.$myrole.'_wpcoreops'];

		//Box controls
		$wpcms_pcpage_doit->pccore_metabox_helper('page', $boxes);

		//Extra controls
		$wpcms_pcpage_doit->pccore_functionremove($extraops);

	}

	/**
	* Removes meta boxes from the post admin area
	* Executes on 'edit post' and 'new post'
	*
	* @since 2.0
	* @lastupdate 2.5
	*
	*
	*/
	function pccore_post() {

		// Load up common functions and helpers class
		$wpcms_pcpost_doit = new wpcms_pcontrol_engine;

		// Get user level and load options
		$myrole = $wpcms_pcpost_doit->pcore_userrole();
		$options = get_option('wpcms_pcontrolopts');
		$boxes = $options['pc_'.$myrole.'_postops'];
		$extraops = $options['pc_'.$myrole.'_wpcoreops'];

		//Box controls
		$wpcms_pcpost_doit->pccore_metabox_helper('post', $boxes);

		//Extra controls
		$wpcms_pcpost_doit->pccore_functionremove($extraops);

	}

}


class wpcms_pcontrol_engine {

	/**
	* Loops through array of supplied values and removes meta boxes from posts/pages
	*
	* @since 2.0
	* @lastupdate 2.5
	*
	*
	* @param xx
	* @return xx
	*/
	function pccore_metabox_helper($whichtype, $whichbox) {

		// 'pageparentdiv' which is set to 'advanced'
		//$definition = ($whichbox == 'pageparentdiv') ? "advanced" : "normal";
		$definition = 'normal';

		//Check for some values
		if ($whichbox != '') {

			foreach($whichbox as $which) {
				if ($which == 'postimagediv') {
					add_action( 'do_meta_boxes', create_function( '', "remove_meta_box( '".$which."','".$whichtype."','side' );" ) );
				} else {
					remove_meta_box(''.$which.'', ''.$whichtype.'', ''.$definition.'');
				}
			}

		}

	}

	/**
	* Loops through array of supplied values and removes stuff from WordPress
	* Uses settings from advanced controls section
	* Better to remove than just hide with CSS, people have browser CSS editors!!
	*
	* @since 2.0
	* @lastupdate 2.81
	*
	*
	* @param $whichbox = which function to remove
	* @return remove_action( '', '' )
	*/
	function pccore_functionremove($whichfunc) {

	//Check for some values
		if ($whichfunc != '') {

			foreach($whichfunc as $which) {
				if ( $which == 'word_count' ) {
					// Get rid of specific word count JS
					wp_deregister_script( 'word-count' );
					// Have to hide word count with CSS even with JS removed - text still remains... grrrr!
					add_action('admin_head', array($this, 'pccore_css'), 10);
				} else {
					remove_action( ''.$which.'', ''.$which.'' );
				}
			}
		}
	}
	
	
	/**
	* Inserts CSS to hide word-count (JS is used to interact with this text, so doesn't disappear if script deregistered)
	*
	* @since 2.81
	* @lastupdate 2.81
	*
	*/
	function pccore_css() {
		echo '<style type="text/css"> #wp-word-count { display: none; } </style>';
	}


	/**
	* Returns user role of logged in user
	*
	* @since 2.0
	* @lastupdate 2.0
	*
	* @return User role: 'administrator', 'editor', 'author', 'contributor', subscriber'
	*/
	function pcore_userrole() {
	global $current_user;
	get_currentuserinfo();
	$theuser = new WP_User( $current_user->ID );

	if ( !empty( $theuser->roles ) && is_array( $theuser->roles ) ) {
	foreach ( $theuser->roles as $role )
	$theuserrole=$role;
	}

	return $theuserrole;
	}

}


?>