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

/* Shortcode on the Page */
add_shortcode("thpp", "thpp_sh");

//Show the Shortcode in the post/site/content
function thpp_sh($atts) {

  //Data of the current Post
  global $post;

  // Shortcode Parameter
	extract(shortcode_atts(array(
		'link_target'		=> 'self',
		'orderby'			=> 'date',
    'order'				=> 'ASC',
    'partnername' => '',
    'partnerID' => '',
    ), $atts));
    
  $link_target 		  = ( $link_target == 'blank' ) 		? '_blank' 	: '_self';
  $order 				    = ( strtolower($order) == 'asc' ) 	? 'ASC' : 'DESC';
  $orderby 			    = !empty($orderby)	 				? $orderby 	: 'date';
  $partnername		  = !empty($partnername)              ? $partnername : '';
  $partnerID		       = !empty($partnerID)              ? $partnerID : '';
        
  // WP Query Parameters
  $query_args = array(
    'post_type' 			  => 'thpp',
    'post_status' 			=> array( 'publish' ),
    'posts_per_page'		=> -1,
    'order'          		=> $order,
	  'orderby'        		=> $orderby,
  );

  //search single partner
  if(!empty($partnerID)){
    $query_args['p'] = $partnerID;
  }

  if(!empty($partnername)){
    $query_args['name'] = $partnername;
  }

  // WP Query Parameters
	$thpp_query = new WP_Query($query_args);
  $post_count = $thpp_query->post_count;

  $single_partner=false;
  if( $post_count == 1 ){
    $single_partner=true;
  }
  
  //Output
  $htmlout = '';

  // Gets table slug (post name)
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );

  //Style
  $main_color = get_option( 'thpp_setting_main_color' , '#237dd1');
  $border_color = get_option( 'thpp_setting_border_color_hover' , '#237dd1');

  if( $thpp_query->have_posts() ) { 
    $htmlout .= thpp_getOutputList( $thpp_query, $post );
  }

  wp_reset_postdata(); // Reset WP Query
  return $htmlout;

}

/**
 * Get HTMl Code
 *
 * @param [type] $thpp_query
 * @return void
 */
function thpp_getOutputList( $thpp_query, $post ){

  if (empty($link_target)){
    $link_target = '_self';
  }
  
  $htmlout = '<!-- Start Triopsi Hosting Partner List -->';

  if( $thpp_query->have_posts() ) { 
    
    //itteration
    $i=0;

    $htmlout .='<ul class="thpp-panel cs-hidden">';

    //Outputt all Services
    foreach ($thpp_query->get_posts() as $partner):

      //itteration high
      $i++;

      $htmlout .='<!--'.$i.'-->';

      //Default Link=true
      $nolink=true;

      //Get the title
      $title_partner = $partner->post_title;  

      //Get the image
      $partner_image = thpp_get_logo_image($partner->ID);

      //Get links
      $partner_url_page_id = (int)get_post_meta( $partner->ID, '_thpp_partner_url_page_id', true );
      $partner_url_post_id = (int)get_post_meta( $partner->ID, '_thpp_partner_url_post_id', true );
      $partner_url_link = get_post_meta( $partner->ID, '_thpp_partner_url_link', true );

      //Default url
      $htmlurl='';

      //Set the url
      if($partner_url_page_id !=0){
        $htmlurl=get_page_link($partner_url_page_id);
      }
      if($partner_url_post_id !=0){
        $htmlurl=get_page_link($partner_url_page_id);
      }
      if($partner_url_link !=''){
        $htmlurl=$partner_url_link;
      }
      if($partner_url_page_id ==0 && $partner_url_post_id ==0 && empty($partner_url_link)){
        $nolink=false;
      }

      //Start List
      $htmlout .='<li id="thpp-partner-id-'.$partner->ID.'" class="thpp-partner thpp-partner-'.$i.'">';
      if($nolink){
        $htmlout .='<a target="'.esc_html($link_target).'" href="'.$htmlurl.'">';
      }
      $htmlout .= '<img src="'.$partner_image.'">';
      if($nolink){
        $htmlout .='</a>';
      }
      $htmlout .='</li>';
    endforeach;

    $htmlout .='</ul><!-- END UL-->';
  }
  $htmlout .= '<!-- End Triopsi Hosting Partner List -->';
  return $htmlout; 
}