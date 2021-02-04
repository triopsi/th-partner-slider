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
**/

/* Hooks the metabox */
add_action('admin_init', 'thpp_add_partner', 1);

function thpp_add_partner() {
	add_meta_box( 
		'thpp-partner-url', 
		__('Patner details', 'thpp' ), 
		'thpp_add_partner_url_display',
		'thpp', 
		'normal'
	);
}

/**
 * Show the add/edit postpage in admin
 *
 * @return void
 */
function thpp_add_partner_url_display( $post ){
	
	//get post meta data
	$partnerurlpageid = (int)get_post_meta( $post->ID, '_thpp_partner_url_page_id', true);
	$partnerurlpostid = (int)get_post_meta( $post->ID, '_thpp_partner_url_post_id', true);
	$partnerurllink = get_post_meta( $post->ID, '_thpp_partner_url_link', true);

	$partnerurlpageid = (empty($partnerurlpageid))?0:$partnerurlpageid;
	$partnerurlpostid = (empty($partnerurlpostid))?0:$partnerurlpostid;
	$partnerurllink = (empty($partnerurllink))?'':$partnerurllink;

	//Hidden field.
    wp_nonce_field( 'thpp_meta_box_nonce', 'thpp_meta_box_nonce' ); 
	
    ?>
    
	<div class="thpp_field">
		<div class="thpp_field_title">
			<?php echo __('More information URL','thpp'); ?>
		</div>
		<div class="thpp_field_title">
			<?php echo __('Site','thpp'); ?>
		</div>
		<?php
		wp_dropdown_pages(array(
			'selected' => $partnerurlpageid,
			'name'   => 'thpp_info_url_page_id',
			'show_option_none'  => __('Please Choose','thpp'),
			'option_none_value' => 0,
			'hierarchical' => true,
			'id'	=> 'infoLinkInputId',
			'selected' => $partnerurlpageid,
			));
		?>
		<br>
		<small> - <?= __('or','thpp') ?> - </small>
		<br>
		<div class="thpp_field_title">
			<?php echo __('Post','thpp'); ?>
		</div>
		<select name="thpp_info_url_post_id" id="page_id">
			<option value="0"><?php echo __('Please Choose','thpp'); ?></option>
			<?php
			
			global $post;
			$args = array( 'numberposts' => -1);
			$posts = get_posts($args);
			foreach( $posts as $post ) : setup_postdata($post); 
				if($partnerurlpostid == $post->ID){
				?>
					<option value="<?= $post->ID; ?>" selected><?php the_title(); ?></option>
				<?php
				}else{ ?>
				<option value="<?= $post->ID; ?>"><?php the_title(); ?></option>
			<?php 
				}
			endforeach; 
			?>
		</select>
		<br>
		<small> - <?= __('or','thpp') ?> - </small>
		<br>
		<div class="thpp_field_title">
			URL
		</div>
			<input class="thpp-field regular-text" id="infoLinkInputLink" name="thpp_info_url" type="text" value="<?php echo esc_url( $partnerurllink ) ?>" placeholder="<?php echo __('e.g. https://example.com','thpp'); ?>">
        </br>
        <em><?= __('Empty Value = No Link','thpp') ?></em>
    </div>

<?php
}

/**
 * Post Data Form
 */
add_action( 'save_post', 'thpp_save_meta_box_data' );

function thpp_save_meta_box_data( $post_id ) {

	if ( ! isset( $_POST['thpp_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['thpp_meta_box_nonce'], 'thpp_meta_box_nonce' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'thpp' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['thpp_info_image'] ) ) {
		return;
	}
    
	//Site Link
	$partner_url_page_id = stripslashes( strip_tags( sanitize_text_field( $_POST['thpp_info_url_page_id'] ) ) );
	$partner_url_post_id = stripslashes( strip_tags( sanitize_text_field( $_POST['thpp_info_url_post_id'] ) ) );
	$partner_url_link = stripslashes( strip_tags( sanitize_text_field( $_POST['thpp_info_url'] ) ) );

	if($partner_url_page_id != 0){
		update_post_meta( $post_id, '_thpp_partner_url_page_id', $partner_url_page_id );
		update_post_meta( $post_id, '_thpp_partner_url_post_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_link', '' );
	}

	if($partner_url_post_id != 0){
		update_post_meta( $post_id, '_thpp_partner_url_page_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_post_id', $partner_url_post_id );
		update_post_meta( $post_id, '_thpp_partner_url_link', '' );
	}

	if(!empty($partner_url_link)){
		update_post_meta( $post_id, '_thpp_partner_url_page_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_post_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_link', $partner_url_link );
	}

	if($partner_url_page_id==0 && $partner_url_post_id==0 && empty($partner_url_link)){
		update_post_meta( $post_id, '_thpp_partner_url_page_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_post_id', 0 );
		update_post_meta( $post_id, '_thpp_partner_url_link', '' );
	}
}