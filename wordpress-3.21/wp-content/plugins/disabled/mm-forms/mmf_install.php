<?php

function install_mmf()
{
	global $wpdb;

	$contactform_config	 = $wpdb->prefix . 'contactform_config';
	$contactform = $wpdb->prefix . 'contactform';
	$contactform_submit = $wpdb->prefix . 'contactform_submit';
	$contactform_submit_data = $wpdb->prefix . 'contactform_submit_data';
	
	
	if($wpdb->get_var("show tables like '$contactform_config'") != $contactform_config) {
      
		$sql = "CREATE TABLE " . $contactform_config . " (
	   `id` int(11) NOT NULL auto_increment,
	   `config_option` varchar(20) NOT NULL,
	   `config_option_value` varchar(20) NOT NULL,
	    PRIMARY KEY  (`id`)
	    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
	
      dbDelta($sql); 
 				
   }

	if($wpdb->get_var("show tables like '$contactform'") != $contactform) {
      
		$sql = "CREATE TABLE " . $contactform . " (
	   `form_id` varchar(50) NOT NULL,
  	   `form_name` varchar(50) NOT NULL,
       `to` varchar(250) NOT NULL,
       `cc` varchar(250) default NULL,
       `bcc` varchar(250) default NULL,
       `form_fields` varchar(250) NOT NULL,
       `csv_separator` char(1) NOT NULL,
	   `export_form_ids` tinyint(1) NOT NULL default '0',
	   `save_data` binary(1) NOT NULL default '1',
	   `mail_format` char(4) default NULL,
       `rss_feed` TINYINT(1) default 0,
	   `all_form_fields` TINYINT(1) default 0,
  	    PRIMARY KEY  (`form_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	
      dbDelta($sql);

		// Insert default form
		$sql2 = "INSERT INTO " . $wp_contactform . " VALUES('1', 'Contact form 1', 'example@example.com', '[your-email]', '', '', ',', 0, '1', '', 0, 0);";
		dbDelta($sql2);
 				
   }
	
	if($wpdb->get_var("show tables like '$contactform_submit'") != $contactform_submit) {
      
		$sql = "CREATE TABLE " . $contactform_submit . " (
	   `id` int(11) NOT NULL auto_increment,
	   `fk_form_id` varchar(50) NOT NULL,
	   `session_id` varchar(50) NOT NULL,
	   `submit_date` datetime NOT NULL,
	   `client_ip` varchar(20) NOT NULL,
	   `client_browser` varchar(100) NOT NULL,
	   `request_url` varchar(100) NOT NULL,
	   `read_flag` tinyint(1) NOT NULL default '0',
	    PRIMARY KEY  (`id`),
	  	KEY `fk_form_id` (`fk_form_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;";
	
      dbDelta($sql); 
 				
   }
   
	if($wpdb->get_var("show tables like '$contactform_submit_data'") != $contactform_submit_data) {
      
		$sql = "CREATE TABLE " . $contactform_submit_data . " (
	  	`id` int(11) NOT NULL auto_increment,
  		`fk_form_joiner_id` int(11) NOT NULL,
  		`form_key` varchar(100) NOT NULL,
  		`value` text NOT NULL,
  		 PRIMARY KEY  (`id`),
		 KEY `fk_form_joiner_id` (`fk_form_joiner_id`),
                 KEY `form_key` (`form_key`),
                 KEY `value` (`value`(256)),
                 KEY `key_value` (`form_key`,`value`(64))
		 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1104 ;";
	
      	dbDelta($sql);
 				
   }   	
	
}
?>
