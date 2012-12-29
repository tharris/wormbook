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
	* Executes on 'edit page' and 'new page'
	*
	* @since 2.0
	* @lastupdate 2.01
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
	* @lastupdate 2.01
	* 
	*
	* @param xx
	* @return xx
	*/  
	function pccore_metabox_helper($whichtype, $whichbox) {

		// 'pageparentdiv' which is set to 'advanced'
		$definition = ($whichbox == 'pageparentdiv') ? "advanced" : "normal";

		//Check for some values
		if ($whichbox != '') {

			foreach($whichbox as $which) {
				remove_meta_box(''.$which.'', ''.$whichtype.'', ''.$definition.''); 
			}
		
		}
		
	}
	
	/**
	* Loops through array of supplied values and removes actions from WordPress ie media upload
	* Better to remove than just hide with CSS, people have browser CSS editors!!
	*
	* @since 2.0
	* @lastupdate 2.0
	* 
	*
	* @param $whichbox = which function to remove
	* @return remove_action( '', '' )
	*/  
	function pccore_functionremove($whichfunc) {

	//Check for some values
		if ($whichfunc != '') {
		
			foreach($whichfunc as $which) {
				remove_action( ''.$which.'', ''.$which.'' );
			}
			
		}
	}

	
	/**
	* Can reuse for things like no flash
	*
	* @since 2.1
	* @lastupdate 2.1
	* 
	* @return false
	*/  
	function pccore_false() {
		return false;
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