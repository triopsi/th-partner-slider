<?php
/**
 * Plugin Name: TH Partner Slider
 * Plugin URI: https://www.wiki.profoxi.de
 * Description: A simple our partner plugin. Create items and copy-paste the shortcode everywhere in your post or site.
 * Version: 1.2.2
 * Author: triopsi
 * Author URI: http://wiki.profoxi.de
 * Text Domain: thpp
 * Domain Path: /lang/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0
 *
 * thpp is free software: you can redistribute it and/or modify
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

// Definie plugin version.
if ( ! defined( 'THPP_VERSION' ) ) {
	define( 'THPP_VERSION', '1.2.2' );
}

/* Loads plugin's text domain. */
add_action( 'init', 'thpp_load_plugin_textdomain' );

/* Admin */
require_once 'inc/thpp-admin.php';
require_once 'inc/thpp-types.php';
require_once 'inc/thpp-post-metabox.php';
require_once 'inc/thpp-help.php';
require_once 'inc/thpp-setting.php';

/* Shortcode */
require_once 'inc/thpp-user.php';
require_once 'inc/thpp-shortcode.php';

/* Widget */
require_once 'inc/thpp-widget.php';

/**
 * Init Script. Load languages
 *
 * @return void
 */
function thpp_load_plugin_textdomain() {
	load_plugin_textdomain( 'thpp', '', 'th-partner-slider/lang/' );
}
