<?php
/*
Plugin Name: My WooCommerce Catalog
Plugin URI: http://bejda.com
Description: This WooCommerce extension turns your WooCommerce Store into a Catalog.
Author: Milos Bejda
Version: 1.0
Author URI: http://Bejda.com
*/

define('WC_CATALOG', plugin_dir_path( __FILE__ ));
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  if ( ! class_exists( 'WC_Catalog_Products' ) ) {
include(WC_CATALOG.'/main.php');
	
  }
}



?>