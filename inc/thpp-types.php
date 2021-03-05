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

// Registers the teams post type.
add_action( 'init', 'register_thpp_type' );

/**
 * Function about the ini of the Plugin
 *
 * @return void
 */
function register_thpp_type() {

	// Defines labels
	$labels = array(
		'name'               => __( 'TH Partner', 'thpp' ),
		'singular_name'      => __( 'Partner', 'thpp' ),
		'menu_name'          => __( 'TH Partner', 'thpp' ),
		'name_admin_bar'     => __( 'TH Partner', 'thpp' ),
		'add_new'            => __( 'Add New Partner', 'thpp' ),
		'add_new_item'       => __( 'Add New Partner', 'thpp' ),
		'new_item'           => __( 'New Partner', 'thpp' ),
		'edit_item'          => __( 'Edit Partner', 'thpp' ),
		'view_item'          => __( 'View Partner', 'thpp' ),
		'all_items'          => __( 'All Partners', 'thpp' ),
		'search_items'       => __( 'Search Partner', 'thpp' ),
		'not_found'          => __( 'No Partners found.', 'thpp' ),
		'not_found_in_trash' => __( 'No Partners found in Trash.', 'thpp' ),
	);

	// Defines permissions.
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_admin_bar'  => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'thumbnail' ),
		'menu_icon'          => 'dashicons-groups',
		'query_var'          => true,
		'rewrite'            => false,
	);

	// Registers post type.
	register_post_type( 'thpp', $args );

}


// Add update messages.
add_filter( 'post_updated_messages', 'thpp_updated_messages' );

/**
 * Update post message functions
 *
 * @param [type] $messages
 * @return void
 */
function thpp_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );
	$messages['thpp'] = array(
		1  => __( 'Partner updated.', 'thpp' ),
		4  => __( 'Partner updated.', 'thpp' ),
		6  => __( 'Partner published.', 'thpp' ),
		7  => __( 'Partners saved.', 'thpp' ),
		10 => __( 'Partners draft updated.', 'thpp' ),
	);

	return $messages;

}

/**
 * Shortcodestyle function
 *
 * @param [type] $column
 * @param [type] $post_id
 * @return void
 */
function thpp_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'thpp_shortcode':
			global $post;
			$slug      = '';
			$slug      = $post->ID;
			$shortcode = '<span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[thpp partnerid=&quot;' . $slug . '&quot;]" class="large-text code"></span>';
			echo $shortcode;
			break;
	}
}

  // Handles shortcode column display.
  add_action( 'manage_thpp_posts_custom_column', 'thpp_custom_columns', 10, 2 );



/**
 * AdminCollumnBar function
 *
 * @param [type] $columns
 * @return void
 */
function add_thpp_columns( $columns ) {
	$columns['title'] = __( 'Partner name', 'thpp' );
	unset( $columns['author'] );
	unset( $columns['date'] );
	return array_merge( $columns, array( 'thpp_shortcode' => 'Shortcode' ) );
}

  // Adds the shortcode column in the postslistbar.
  add_filter( 'manage_thpp_posts_columns', 'add_thpp_columns' );
