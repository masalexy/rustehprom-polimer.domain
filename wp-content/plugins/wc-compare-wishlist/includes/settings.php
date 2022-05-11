<?php
// +----------------------------------------------------------------------+
// | Copyright 2014  Madpixels  (email : contact@madpixels.net)           |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+
// | Author: Eugene Manuilov <eugene.manuilov@gmail.com>                  |
// +----------------------------------------------------------------------+

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 404 Not Found', true, 404 );
	exit;
}

// register action hooks
add_action( 'woocommerce_settings_start', 'wccm_register_settings' );
add_action( 'woocommerce_settings_compare_list', 'wccm_render_settings_page' );
add_action( 'woocommerce_update_options_compare_list', 'wccm_update_options' );

// register filter hooks
add_filter( 'woocommerce_settings_tabs_array', 'wccm_register_settings_tab', PHP_INT_MAX );

/**
 * Returns array of the plugin settings, which will be rendered in the
 * WooCommerce settings tab.
 *
 * @since 1.0.0
 *
 * @return array The array of the plugin settings.
 */
function wccm_get_settings() {
	return array(
        array(
			'id'    => 'general-options',
			'type'  => 'title',
			'title' => 'Настройки',
		),

		array(
			'type'  => 'single_select_page',
			'id'    => 'wccm_compare_page',
			'class' => 'chosen_select_nostd',
            'title' => 'Выберите страницу сравнения'
		),

		array(
			'type'    => 'text',
			'id'      => 'wccm_compare_button_class',
			'title'   => 'Класс кнопки',
			'default' => '.compare_button',
		),


		array(
			'type'  => 'single_select_page',
			'id'    => 'wccm_wishlist_page',
			'class' => 'chosen_select_nostd',
            'title' => 'Выберите страницу избранное'
		),

		array(
			'type'    => 'text',
			'id'      => 'wccm_wishlist_button_class',
			'title'   => 'Класс кнопки',
			'default' => '.wishlist_button',
		),

		array( 'type' => 'sectionend', 'id' => 'general-options' ),
    );
}

/**
 * Registers plugin settings in the WooCommerce settings array.
 *
 * @since 1.0.0
 * @action woocommerce_settings_start
 *
 * @global array $woocommerce_settings WooCommerce settings array.
 */
function wccm_register_settings() {
    global $woocommerce_settings;
    $woocommerce_settings['compare_list'] = wccm_get_settings();
}

/**
 * Registers WooCommerce settings tab which will display the plugin settings.
 *
 * @since 1.0.0
 * @filter woocommerce_settings_tabs_array PHP_INT_MAX
 *
 * @param array $tabs The array of already registered tabs.
 * @return array The extended array with the plugin tab.
 */
function wccm_register_settings_tab( $tabs ) {
    $tabs['compare_list'] = 'Wishlist and Compare List';
    return $tabs;
}

/**
 * Renders plugin settings tab.
 *
 * @since 1.0.0
 * @action woocommerce_settings_compare_list
 *
 * @global array $woocommerce_settings The aggregate array of WooCommerce settings.
 * @global string $current_tab The current WooCommerce settings tab.
 */
function wccm_render_settings_page() {
    global $woocommerce_settings, $current_tab;
    woocommerce_admin_fields( $woocommerce_settings[$current_tab] );
}

/**
 * Updates plugin settings after submission.
 *
 * @since 1.0.0
 * @action woocommerce_update_options_compare_list
 */
function wccm_update_options() {
	if ( filter_input( INPUT_POST, 'wccm_compare_endpoint' ) != get_option( 'wccm_compare_endpoint' ) ) {
		flush_rewrite_rules();
	}

	woocommerce_update_options( wccm_get_settings() );
}
