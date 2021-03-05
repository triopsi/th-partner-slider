<?php
/**
 * Author: triopsi
 * Author URI: http://wiki.profoxi.de
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0
 *
 * Thpp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * thpp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with thpp. If not, see https://www.gnu.org/licenses/gpl-3.0.
 *
 * @package thpp
 **/

/**
 * Version Check
 *
 * @return void
 */
function thpp_check_version() {
	if ( THPP_VERSION !== get_option( 'thpp_plugin_version' ) ) {
		thpp_activation();
	}
}

// Loaded Plugin.
add_action( 'plugins_loaded', 'thpp_check_version' );

// Add Admin panel.
add_action( 'admin_enqueue_scripts', 'add_admin_thpp_style_js' );

/**
 * Undocumented function
 *
 * @return void
 */
function add_admin_thpp_style_js() {

	// Gets the post type.
	global $post_type;

	if ( 'thpp' === $post_type ) {

		// Add all JS, CSS and settings for the media js.
		wp_enqueue_media();

		// JS for metaboxes.
		wp_enqueue_script( 'logic-form', plugins_url( '../assets/js/logic-form.js', __FILE__ ) );

	}

}

/**
 * Update Version Number
 *
 * @return void
 */
function thpp_activation() {
	update_option( 'thpp_plugin_version', THPP_VERSION );
}
