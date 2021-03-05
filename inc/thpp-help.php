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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Menue.
add_action( 'admin_menu', 'thpp_register_help_page' );

/**
 * Add help page function
 *
 * @return void
 */
function thpp_register_help_page() {
	add_submenu_page(
		'edit.php?post_type=thpp',
		__( 'How It Works', 'thpp' ),
		__( 'Help', 'thpp' ),
		'manage_options',
		'thpp_help',
		'thpp_help_page'
	);
}

/**
 * Text HTML
 *
 * @return void
 */
function thpp_help_page() { ?>
	
	<style type="text/css">
		.thpp-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>

	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								
								<h3 class="hndle">
									<span><?php esc_html_e( 'How It Works - Display and shortcode', 'thpp' ); ?></span>
								</h3>
								
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php esc_html_e( 'Geeting Started with TH partner Slider', 'thpp' ); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php esc_html_e( 'Step 1. Go to "All Partners --> Add New Partner"', 'thpp' ); ?></li>
														<li><?php esc_html_e( 'Step 2. Add Partner title, a partner image or logo under the featured image section and insert optimal a partner link.', 'thpp' ); ?></li>
														<li><?php esc_html_e( 'Step 3a. Copy-paste the shortcode <span class="thpp-shortcode-preview">[thpp]</span> anywhere in your post or site for show a slideshow', 'thpp' ); ?></li>
														<li><b><?php esc_html_e( 'or', 'thpp' ); ?></b></li>
														<li><?php esc_html_e( 'Step 3b. Copy-paste the shortcode <span class="thpp-shortcode-preview">[thpp partnerid="&lt;id&gt;"]</span> anywhere in your post or site for show a single partner', 'thpp' ); ?></li>
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php esc_html_e( 'All Shortcodes', 'thpp' ); ?>:</label>
												</th>
												<td>
													<span class="thpp-shortcode-preview">[thpp]</span> – <?php esc_html_e( 'Partner Slide Shortcode. Show all partner in a slideshow', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">[thpp partnerid="&lt;id&gt;"]</span> – <?php esc_html_e( 'show a single partner', 'thpp' ); ?> <br />
												</td>
											</tr>			
											
											<tr>
												<th>
													<label><?php esc_html_e( 'All Shortcodes parameters', 'thpp' ); ?>:</label>
												</th>
												<td>
													<span class="thpp-shortcode-preview">link_target="self"</span> – <?php esc_html_e( 'Partner link target. Value=self or blank, Default=self', 'thpp' ); ?> <br />													
													<span class="thpp-shortcode-preview">orderby="date"</span> – <?php esc_html_e( 'orderby the atribute of partners Value=date, ID, title, name or rand, Default=date', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">order="asc"</span> – <?php esc_html_e( 'sort the partner in ascending or descending order. Value=asc or desc, Default=ASC', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">partnername="&lt;slug-name&gt;"</span> – <?php esc_html_e( 'Show a partner - single view', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">partnerid="&lt;id&gt;"</span> – <?php esc_html_e( 'Show a partner - single view', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_items="4"</span> – <?php esc_html_e( 'Number of partner to show at a time. Default=4', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_loop="true"</span> – <?php esc_html_e( 'If false, will disable the ability to loop back to the beginning of the slide when on the last element. Default=4', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_slidemove="2"</span> – <?php esc_html_e( 'Number of partner to be moved at a time. Default=2', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_auto="true"</span> – <?php esc_html_e( 'If true, the Slider will automatically start to play. Default=true', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_pauseonhover="true"</span> – <?php esc_html_e( 'Pause autoplay on hover. Default=true', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_speed="600"</span> – <?php esc_html_e( 'Transition duration (in ms). // ex = speed:400. Default=600', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_autowidth="false"</span> – <?php esc_html_e( 'Custom width for each slide. Default=false', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_controls="false"</span> – <?php esc_html_e( 'If false, prev/next buttons will not be displayed. Default=false', 'thpp' ); ?> <br />
													<span class="thpp-shortcode-preview">thpp_wg_pager="false"</span> – <?php esc_html_e( 'Enable pager option. Default=false', 'thpp' ); ?> <br />
													<br />
													<?php esc_html_e( 'e.g.', 'thpp' ); ?>
													<span class="thpp-shortcode-preview">[thpp thpp_wg_items="6" thpp_wg_controls="true" thpp_wg_slidemove="1" thpp_wg_auto="true" thpp_wg_autowidth="true"]</span>
												
												</td>
											</tr>	
											<tr>
												<th>
													<label><?php esc_html_e( 'Widget', 'thpp' ); ?>:</label>
												</th>
												<td><p>
														<?php esc_html_e( 'Use the widget to insert a slideshow in your page or post.', 'thpp' ); ?> <br />
														<img title="widget" src="<?php echo plugins_url( '../assets/img/screenshot-5.png', __FILE__ ); ?>">
													</p>
												</td>
											</tr>		

											<tr>
												<th>
													<label><?php esc_html_e( 'Need Support?', 'thpp' ); ?></label>
												</th>
												<td>
													<p><?php esc_html_e( 'Check plugin document for shortcode parameters.', 'thpp' ); ?></p> <br/>
													<a class="button button-primary" href="http://wiki.profoxi.de" target="_blank"><?php esc_html_e( 'Documentation', 'thpp' ); ?></a>									
													<a class="button button-secondary" href="http://paypal.me/triopsi" target="_blank">❤️ <?php esc_html_e( 'Donate', 'thpp' ); ?></a>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php esc_html_e( 'Used libraries', 'thpp' ); ?></label>
												</th>
												<td>
													<p>lightSlider v1.1.6</p> <br/>
													<a class="button button-secondary" href="http://sachinchoolur.github.io" target="_blank">http://sachinchoolur.github.io</a>									
												</td>
											</tr>
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
	<?php
}
