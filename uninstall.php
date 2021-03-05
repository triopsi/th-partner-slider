<?php
/**
 * Author: triopsi
 * Author URI: http://wiki.profoxi.de
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

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

/* Delete plugin options */
$option_version = 'thpp_plugin_version';

delete_option( $option_version );
delete_site_option( $option_version );

// Delete metadata and posts.
$post_type_arg   = array(
	'post_type'      => 'thpp',
	'posts_per_page' => -1,
);
$getpostsentries = get_posts( $post_type_arg );
foreach ( $getpostsentries as $delpost ) {
	wp_delete_post( $delpost->ID, true );
}

