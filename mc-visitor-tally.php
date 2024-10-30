<?php
/*
Plugin Name: MC Visitor Tally
Plugin URI: https://mid-coast.com/mc-visitor-tally
Description: Counts unique daily visits and displays in various timeframes: Today, Yesterday, Current Week, Current Month, Current Year.
Version: 2.8.3
Author: Mike Hickcox
Author URI: https://Mid-Coast.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

    Copyright (C)2021 Mike Hickcox

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see https://www.gnu.org/licenses.
*/

	defined('ABSPATH') or die( 'Not allowed to view this file.' );

	// INCLUDE NEEDED FILES
     	include 'inc/mc6397vt_date-codes.php';
     	include 'inc/mc6397vt_dashboard-widget.php';
     	include 'inc/mc6397vt_shortcode.php';
     	include 'inc/mc6397vt_settings.php';
     	include 'inc/mc6397vt_widget.php';

	// CREATE THE DATABASE TABLE
	register_activation_hook(__FILE__, 'mc6397vt_active_plugin');
	function mc6397vt_active_plugin()
{
    	global $wpdb;
    	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    	$table_name = $wpdb->prefix . 'mc6397_visitor_tally';


    	$sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
            visit_date date NOT NULL,
            ip varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            hits int(11) NOT NULL,
              PRIMARY KEY (id)
            );";
    	dbDelta($sql);
}


	// SAVE THE PLUGIN INSTALLATION DATE FOR PRINTOUT ON DASHBOARD WIDGET
	$InstallDate=current_time('F j, Y');
	add_option('mc6397vt_installed', "$InstallDate");



    // ADD A TIME DELAY TO LIMIT DUPLICATES WHEN MORE THAN ONE PAGE IS HIT AT ONCE
    function mc6397vt_usleep($mc6397vttime)
{
    mc6397vt_usleep($mc6397vttime * rand (10, 3000000));
}


	// EXECUTE ON EVERY PAGE HEADER
	add_action('wp_head',function(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'mc6397_visitor_tally';
    $mc6397vtdate=current_time('Y-m-d');
    $ip=$_SERVER['REMOTE_ADDR'];
    $sql="SELECT COUNT(*) FROM $table_name WHERE ip='".$ip."' AND visit_date='".$mc6397vtdate."'";
    $totalRecord=$wpdb->get_var($sql);



	// BLOCK BOTS AND CRAWLERS, THEN ADD RECORD IF IP IS NOT ALREADY IN THE DATABASE TODAY
	if(preg_match("/^(Mozilla)/i", $_SERVER['HTTP_USER_AGENT']) && (!preg_match("/amazon|aolbuild|baidu|bot|bubing|crawl|duckduck|facebook|fwdproxy|google|preview|proxy|scanner|slurp|spider|teoma|yandex/i", $_SERVER['HTTP_USER_AGENT']))) {
	if($totalRecord==0)
    {
        mc6397_visitor_tally_insert_data();
    }}

});

	// INSERT DATA INTO THE TABLE
	function mc6397_visitor_tally_insert_data()
{
    	global $wpdb;
    	$table_name = $wpdb->prefix . 'mc6397_visitor_tally';
    	$mc6397vtdate=current_time('Y-m-d');
    	$wpdb->insert($table_name, array(
           "visit_date" =>$mc6397vtdate,
           "ip" =>$_SERVER['REMOTE_ADDR'],
           "hits" =>1
   ));
}

	// REMOVE ALL DATA MORE THAN ONE YEAR OLD
	function mc6397_visitor_tally_delete_old_data()
{
	global $wpdb;
    	$table_name = $wpdb->prefix . 'mc6397_visitor_tally';
        $wpdb->query("DELETE FROM $table_name WHERE visit_date < DATE_SUB(NOW(), INTERVAL 1 YEAR);");
}
{
	mc6397_visitor_tally_delete_old_data();
}


	// COLLECT DATA BY TIME FRAME
	function mc6397vt_get_visitor_data()
{
    	global $wpdb;
    	$table_name = $wpdb->prefix . 'mc6397_visitor_tally';
    	$mc6397vtdata=[];


        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date='".mc6397vt_getToday()."'";
        $today = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date='".mc6397vt_getYesterday()."'";
        $yesterday = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date between '".date('Y-m-d', strtotime('-7 days'))."' and '".mc6397vt_getYesterday()."'";
        $pastWeek = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date between '".mc6397vt_getCurrent('month','first')."' and '".mc6397vt_getCurrent ('month','last')."'";          
        $thisMonth = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date between '".mc6397vt_getCurrent('year','first')."' and 
        '".mc6397vt_getCurrent('year','last')."'";
        $thisYear = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-01-%'";
        $januaryTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-02-%'";
        $februaryTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-03-%'";
        $marchTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-04-%'";
        $aprilTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-05-%'";
        $mayTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-06-%'";
        $juneTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-07-%'";
        $julyTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-08-%'";
        $augustTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-09-%'";
        $septemberTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-10-%'";
        $octoberTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-11-%'";
        $novemberTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name WHERE visit_date LIKE '%-12-%'";
        $decemberTotal = $wpdb->get_var($sql);

        $sql="SELECT SUM(hits) FROM $table_name";
        $yearTotal = $wpdb->get_var($sql);

        $mc6397vtdata['today']=number_format($today);
        $mc6397vtdata['yesterday']=number_format($yesterday);
        $mc6397vtdata['pastWeek']=number_format($pastWeek);
        $mc6397vtdata['thisMonth']=number_format($thisMonth);
        $mc6397vtdata['thisYear']=number_format($thisYear);
        $mc6397vtdata['January']=number_format($januaryTotal);
        $mc6397vtdata['February']=number_format($februaryTotal);
        $mc6397vtdata['March']=number_format($marchTotal);
        $mc6397vtdata['April']=number_format($aprilTotal);
        $mc6397vtdata['May']=number_format($mayTotal);
        $mc6397vtdata['June']=number_format($juneTotal);
        $mc6397vtdata['July']=number_format($julyTotal);
        $mc6397vtdata['August']=number_format($augustTotal);
        $mc6397vtdata['September']=number_format($septemberTotal);
        $mc6397vtdata['October']=number_format($octoberTotal);
        $mc6397vtdata['November']=number_format($novemberTotal);
        $mc6397vtdata['December']=number_format($decemberTotal);
        $mc6397vtdata['Year']=number_format($yearTotal);
        return $mc6397vtdata;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=mcvisitortally' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
