<?php

	 // EXIT IF UNINSTALL CONSTANT IS NOT DEFINED
	if (!defined('WP_UNINSTALL_PLUGIN')) exit;

	// DETERMINE IF TABLE AND OPTIONS SHOULD BE DELETED

	$mc6397vtDelete=get_option('mc6397vt_deleteTable');
	if ($mc6397vtDelete!=No) {

	// IF NOT NO, DELETE OPTIONS
	delete_option( 'widget_mc6397vt_widget' );
	delete_option( 'mc6397vt_installed' );
	delete_option( 'mc6397vt_showyear' );
	delete_option( 'mc6397vt_deleteTable' );
	delete_option( 'mc6397vt_table_type' );
	delete_option( 'mc6397vt_table_color' );
	delete_option( 'mc6397vt_table_resp' );
	delete_option( 'mc6397vt_showmonths' );

	// IF NOT NO, DELETE TABLE
	global $wpdb;
	$table_name = $wpdb->prefix .'mc6397_visitor_tally';
	$wpdb->query("DROP TABLE IF EXISTS {$table_name}");
}
