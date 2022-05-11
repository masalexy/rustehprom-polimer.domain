<?php
/*
    * Multi Region Select
    * Plugin Name: Мультирегион
    * Description: Добавьте и редактируйте города
    * Version:     1.0
    * Author:      Levon Manukyan
*/

register_activation_hook( __FILE__, function () {
    global $wpdb;
    $create_table_query = "
        CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}multiregions` (
          `id` int NOT NULL AUTO_INCREMENT,
          `name` text NOT NULL,
          `url` text NOT NULL,
          `url_type` text NOT NULL,
          `name_ask` text NOT NULL,
          `region` text NOT NULL,
          `phone` text NOT NULL,
          `email` text NOT NULL,
          `address` text NOT NULL,
          `grafik` text NOT NULL,
          `head_scripts` text NOT NULL,
          `body_scripts` text NOT NULL,
           PRIMARY KEY (id)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
    ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $create_table_query );

    $region = $wpdb->get_results("SELECT url FROM {$wpdb->prefix}multiregions WHERE url = '' ");
    if( empty($region) ) {

        $default_region = [
        	'name' => 'Москва',
        	'url' => '',
        	'url_type' => '0',
        	'name_ask' => '',
        	'region' => '',
        	'phone' => '',
        	'email' => '',
        	'address' => '',
        	'grafik' => '',
        	'head_scripts' => '',
        	'body_scripts' => ''
        ];

        $wpdb->insert(
        	$wpdb->prefix.'multiregions',
        	$default_region,
        	[
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        		'%s',
        	]
        );
    }

});

add_action( 'activated_plugin', function ( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=multiregion_requirement') ) );
    }
});

add_filter('plugin_action_links_'.plugin_basename(__FILE__), function($links){
	$links[] = '<a href="/wp-admin/admin.php?page=multiregion_requirement" style="color: #ff0000;">Требование</a>';
	return $links;
});


require 'inc/admin-settings.php';
require 'inc/virtual-pages.php';
require 'modules/loader.php';
