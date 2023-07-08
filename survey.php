<?php
   /*
	Plugin Name: Survey
	Plugin URI: 
	Description: Survey 
	Version: 1.1
	Author: Amirul Momenin patainc@gmail.com
	Author URI: 
	License: GPL
	*/
	ob_start(); // line 1
	session_start(); // line 2
	$PLUGIN_URL = plugin_dir_url(__FILE__);
	define('SURVEY_PLUGIN_URL',substr($PLUGIN_URL,0,strlen($PLUGIN_URL)-1));
	define('SURVEY_PLUGIN_PATH', str_replace('\\', '/', dirname(__FILE__)) );
	
	
	register_activation_hook(__FILE__,'survey_install'); 
	register_deactivation_hook( __FILE__, 'survey_remove' );
	function survey_install()
	 {  
	    create_page_survey('survey');
	 
		global $survey_db_version;
		$survey_db_version = "1.0";
		global $wpdb;
		global $survey_db_version;
	
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	 
		
		
		add_option("survey_db_version", $survey_db_version);
		
	}
	
	function create_table_survey() {
		global $wpdb;
		global $your_db_name;
		$charset_collate = $wpdb->get_charset_collate();
	 
		 $sql1 = "  CREATE TABLE ".$wpdb->prefix ."survey (
					  `id` int(10) NOT NULL AUTO_INCREMENT,		
					  `question` text,
                      `answer` text,
					  `created_at` datetime DEFAULT NULL,
					  `updated_at` datetime DEFAULT NULL,
					   UNIQUE KEY id (id)
					) $charset_collate;";
					
		 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql1);
			
	}
	// run the install scripts upon plugin activation
	register_activation_hook(__FILE__,'create_table_survey');
	
	function survey_remove()
	{
		global $wpdb;
		
		//remove page
		global $wpdb;
	
		$the_page_title = get_option( "my_plugin_page_title" );
		$the_page_name = get_option( "my_plugin_page_name" );
		$the_page_id = get_option( 'my_plugin_page_id' );
		if( $the_page_id ) {
			wp_delete_post( $the_page_id ); 
		}
		delete_option("my_plugin_page_title");
		delete_option("my_plugin_page_name");
		delete_option("my_plugin_page_id");
	}
	
	function create_page_survey($title)
	{
		global $wpdb; 
		
		//survey
		$the_page_title = $title;
		$the_page_name = $title;
		
		delete_option("my_plugin_page_title");
		add_option("my_plugin_page_title", $the_page_title, '', 'yes');
		
		delete_option("my_plugin_page_name");
		add_option("my_plugin_page_name", $the_page_name, '', 'yes');
		
		delete_option("my_plugin_page_id");
		add_option("my_plugin_page_id", '0', '', 'yes');
		
		$the_page = get_page_by_title( $the_page_title );
		if ( ! $the_page ) {
			$_p = array();
			$_p['post_title'] = $the_page_title;
			$_p['post_content'] = "[".$title."]";
			$_p['post_status'] = 'publish';
			$_p['post_type'] = 'page';
			$_p['comment_status'] = 'closed';
			$_p['ping_status'] = 'closed';
			$_p['post_category'] = array(1);
			$the_page_id = wp_insert_post( $_p );
		}
	}

    //Admin		
	add_action('admin_menu', 'survey_manage');
	function survey_manage(){
	  add_menu_page('Survey Settings', 'Survey', 'manage_options', 'survey', 'survey_settings_func');
	  add_submenu_page( 'survey', 'SurveyData', 'SurveyData', 'manage_options', 'surveydata', 'surveydata_func');
	}
	 
	function survey_settings_func(){
		 include_once dirname(__FILE__) . '/admin_survey.php';   
	}   

	function surveydata_func(){
		 include_once dirname(__FILE__) . '/admin_surveydata.php';   
	} 
	
	//short code surveys
	function survey_sort_code_func( $atts ) {
		include_once dirname(__FILE__) . '/template/front/survey.php';
	}
	add_shortcode( 'survey', 'survey_sort_code_func' );