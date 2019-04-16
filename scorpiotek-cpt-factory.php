<?php

/*  	
    Plugin Name: ScorpioTek Custom Post Type Factory
    Description: Simplifies the creation and code of a new Custom Post Types
    @since  1.0
    Version: 1.0.3
	Text Domain: scorpiotek.com
*/

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Load the file that contains the ContentType class
if ( file_exists( plugin_dir_path( __FILE__ ) . '/include/content-type.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'include/content-type.php' );
}
else {
    error_log( 'Error loading file ' . plugin_dir( __FILE__) . 'include/content-type.php' );
}

// Load the file that contains the CustomTaxonomy
if ( file_exists( plugin_dir_path( __FILE__ ) . '/include/custom-taxonomy.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'include/custom-taxonomy.php' );
}
else {
    error_log( 'Error loading file ' . plugin_dir( __FILE__) . 'include/custom-taxonomy.php' );
}


