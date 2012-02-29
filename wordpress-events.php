<?php 

/*
Plugin Name: WordPress Events
Plugin URI: http://fishcantwhistle.com
Description: 
Version: 0.8.4
Author: Fish Can't Whistle
*/

if (!defined("WPE_url")) { define("WPE_url", WP_PLUGIN_URL.'/wordpress-events'); } //NO TRAILING SLASH

if (!defined("WPE_dir")) { define("WPE_dir", WP_PLUGIN_DIR.'/wordpress-events'); } //NO TRAILING SLASH



include_once('includes/class-wordpress-events-setup.php'); //Set up

include('includes/class-wordpress-events-widget.php');

?>