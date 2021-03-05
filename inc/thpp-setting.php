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
 * top level menu
 */
function thpp_option_menue() {

	add_options_page(
		__( 'TH Partner Options', 'thpp' ),
		__( 'TH Partner Options', 'thpp' ),
		'manage_options',
		'thpp',
		'thpp_options_page_html'
	);
}

// register our thpp_options_page to the admin_menu action hook.
add_action( 'admin_menu', 'thpp_option_menue' );

/**
 *  top level menu
 *
 * @return void
 */
function thpp_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<div id="post-body-content">
			<div id="thpp-admin-page" class="meta-box-sortabless">
				<div id="thpp-shortcode" class="postbox">
					<div class="inside">
						<h3 class="wp-pic-title"><?php esc_html_e( 'Supports', 'thpp' ); ?></h3>
						<div class="thpp-wrap-option-page">
							<a href="https://paypal.me/triopsi" target="_blank" class="button button-secondary">❤️ <?php esc_html_e( 'Donate', 'thpp' ); ?></a> 
							<a href="edit.php?post_type=thpp&page=thpp_help" target="_self" class="button button-secondary">ℹ️ <?php esc_html_e( 'Help', 'thpp' ); ?></a> 
						</div>
					 </div>
				</div>
			</div>
		<?php if ( WP_DEBUG ) { ?>
			<div class="debug-info">
				<h3><?php _e( 'Debug information', 'thpp' ); ?></h3>
				<p><?php _e( 'You are seeing this because your WP_DEBUG variable is set to true.', 'thpp' ); ?></p>
				<pre>thpp_plugin_version: <?php print_r( get_option( 'thpp_plugin_version' ) ); ?></pre>
				<pre><?php esc_html_e( 'All Partners', 'thpp' ); ?>: <?php print_r( thpp_show_all_posts() ); ?></pre>
			</div><!-- /.debug-info -->
		<?php } ?>
	</div>
	<?php
}

/**
 * Find all partners
 *
 * @return void
 */
function thpp_show_all_posts() {

	$thpp_query = new WP_Query(
		array(
			'post_type'      => 'thpp',
			'post_status'    => array( 'any' ),
			'posts_per_page' => -1,
			'order'          => 'asc',
			'orderby'        => 'date',
		)
	);

	$post_type_arg   = array(
		'post_type'      => 'thpp',
		'posts_per_page' => -1,
	);
	$getpostsentries = get_posts( $post_type_arg );
	return $getpostsentries;
}
