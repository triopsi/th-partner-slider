<?php
/**
* Author: triopsi
* Author URI: http://wiki.profoxi.de
* License: GPL3
* License URI: https://www.gnu.org/licenses/gpl-3.0
*
* partner is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*  
* partner is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*  
* You should have received a copy of the GNU General Public License
* along with partner. If not, see https://www.gnu.org/licenses/gpl-3.0.
**/

/* Add CSS Class to the front */
add_action( 'wp_enqueue_scripts', 'thpp_add_partner_front_css', 99 );
function thpp_add_partner_front_css() {
  wp_enqueue_style( 'partner-slider-css', plugins_url('../assets/css/lightslider.css', __FILE__));
  wp_enqueue_style( 'partner', plugins_url('../assets/css/front-style.css', __FILE__));
}

// Add User Script
add_action( 'wp_enqueue_scripts', 'thpp_add_thpartner_slider_js', 99 );
function thpp_add_thpartner_slider_js() {
  wp_enqueue_script( 'lightslider-js', plugins_url('../assets/js/lightslider.min.js', __FILE__));
  wp_enqueue_script( 'thpp-js', plugins_url('../assets/js/content.js', __FILE__));
}

/**
 * Function to get post featured image
 */
function thpp_get_logo_image( $post_id = '', $size = 'full' ) {
	$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );	
	if( !empty($imageurl) ) {
		$imageurl = isset($imageurl[0]) ? $imageurl[0] : '';
	}
	return $imageurl;
}