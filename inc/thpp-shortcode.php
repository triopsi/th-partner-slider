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
		'link_target'		        => 'self',
		'orderby'			          => 'date',
    'order'				          => 'ASC',
    'partnername'           => '',
    'partnerid'             => '',
    'thpp_wg_items'         => 4,
    'thpp_wg_loop'          => 'true',
    'thpp_wg_slidemove'     => 2,
    'thpp_wg_auto'          => 'true',
    'thpp_wg_pauseonhover'  => 'true',
    'thpp_wg_speed'         => 600,
    'thpp_wg_autowidth'     => 'false',
    'thpp_wg_controls'      => 'false',
    'thpp_wg_pager'         => 'false',
    ), $atts));
    
  $link_target 		        = ( $link_target == 'blank' ) 		? '_blank' 	: '_self';
  $order 				          = ( strtolower($order) == 'asc' ) 	? 'ASC' : 'DESC';
  $orderby 			          = !empty($orderby)	 				? $orderby 	: 'date';
  $partnername		        = !empty($partnername)              ? $partnername : '';
  $partnerid		          = !empty($partnerid)              ? $partnerid : '';
  $thpp_wg_loop 		      = ( $thpp_wg_loop == 'false') 	    ? false	: true;
  $thpp_wg_auto 		      = ( $thpp_wg_auto == 'false') 	    ? false	: true;
  $thpp_wg_pauseonhover 	= ( $thpp_wg_pauseonhover == 'false') 	    ? false	: true;
  $thpp_wg_autowidth 		  = ( $thpp_wg_autowidth == 'false') 	    ? false	: true;
  $thpp_wg_controls 		  = ( $thpp_wg_controls == 'false') 	    ? false	: true;
  $thpp_wg_pager 		      = ( $thpp_wg_pager == 'false') 	    ? false	: true;
  $thpp_wg_items 			    = !empty($thpp_wg_items)	 				? $thpp_wg_items 	: '4';
  $thpp_wg_slidemove 			= !empty($thpp_wg_slidemove)	 				? $thpp_wg_slidemove 	: '2';
  $thpp_wg_speed 			    = !empty($thpp_wg_speed)	 				? $thpp_wg_speed 	: '600';
      
  // var_dump($partnerID);

  //Script Config
  $configscript = array( 
    'thpp_wg_items'         => $thpp_wg_items,
    'thpp_wg_loop'          => $thpp_wg_loop,
    'thpp_wg_slideMove'     => $thpp_wg_slidemove,
    'thpp_wg_auto'          => $thpp_wg_auto,
    'thpp_wg_pauseOnHover'  => $thpp_wg_pauseonhover,
    'thpp_wg_speed'         => $thpp_wg_speed,
    'thpp_wg_autoWidth'     => $thpp_wg_autowidth,
    'thpp_wg_controls'      => $thpp_wg_controls,
    'thpp_wg_pager'         => $thpp_wg_pager,
  );

  // WP Query Parameters
  $query_args = array(
    'post_type' 			  => 'thpp',
    'post_status' 			=> array( 'publish' ),
    'posts_per_page'		=> -1,
    'order'          		=> $order,
	  'orderby'        		=> $orderby,
  );

  //search single partner
  if(!empty($partnerid)){
    $query_args['p'] = $partnerid;
  }

  if(!empty($partnername)){
    $query_args['name'] = $partnername;
  }

  // var_dump($query_args);

  // WP Query Parameters
	$thpp_query = new WP_Query($query_args);

  // Gets table slug (post name)
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );

  //Style
  $main_color = get_option( 'thpp_setting_main_color' , '#237dd1');
  $border_color = get_option( 'thpp_setting_border_color_hover' , '#237dd1');

  //Default Output
  $htmlout = '';

  if( $thpp_query->have_posts() ) { 
    $idwid=uniqid();
    ob_start();
    thpp_print_scripts( $configscript, $idwid );
    $o = ob_get_clean();
    $htmlout .= thpp_getOutputList( $thpp_query, $post, $idwid, $link_target );
  }

  wp_reset_postdata(); // Reset WP Query
  return $o.$htmlout;

}

/**
 * Get HTMl Code
 *
 * @param [type] $thpp_query
 * @return void
 */
function thpp_getOutputList( $thpp_query, $post, $id, $link_target='_self' ){
  
  $htmlout = '<!-- Start Triopsi Hosting Partner List -->';

  if( $thpp_query->have_posts() ) { 
    
    //itteration
    $i=0;

    $htmlout .='<ul id="'.$id.'" class="thpp-panel cs-hidden">';

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


/**
* Print script.
*
* @since 1.0
*/
function thpp_print_scripts( $config, $id ) {
?>
<script>
			;(function($){
        $(document).ready(function (){ 
          $("#<?php echo esc_attr( $id ) ?>").lightSlider({
            item: <?php echo esc_attr((int)$config['thpp_wg_items']) ?>,
            loop: <?php echo ( esc_attr( $config['thpp_wg_loop'] ) )?'true':'false'; ?>,
            slideMove: <?php echo esc_attr((int)$config['thpp_wg_slideMove']) ?>,
            auto: <?php echo ( esc_attr($config['thpp_wg_auto']) )?'true':'false'; ?>,
            pauseOnHover: <?php echo ( esc_attr($config['thpp_wg_pauseOnHover']) )?'true':'false'; ?>,
            easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            speed: <?php echo esc_attr((int)$config['thpp_wg_speed']) ?>,
            autoWidth: <?php echo ( esc_attr($config['thpp_wg_autoWidth']) )?'true':'false'; ?>,
            controls: <?php echo ( esc_attr($config['thpp_wg_controls']) )?'true':'false'; ?>,
            pager: <?php echo ( esc_attr($config['thpp_wg_pager']) )?'true':'false'; ?>,
            onSliderLoad: function() {
                $('#autoWidth').removeClass('cS-hidden');
            },
            responsive : [
                {
                  breakpoint:800,
                  settings: {
                    item:3,
                    slideMove:1,
                    slideMargin:6,
                  }
                },
                {
                    breakpoint:480,
                    settings: {
                      item:2,
                      slideMove:1
                    }
                }
            ]
          });  
        });
    })(jQuery);
    </script>
<?php
}