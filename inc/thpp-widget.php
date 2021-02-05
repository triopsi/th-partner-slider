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

class thppslidepanel_widget extends WP_Widget {

    function __construct(){
        parent::__construct(
            // Base ID of your widget
            'thppsliderwidget',
            // Widget name will appear in UI
            __('TH Partner Slider', 'thpp'),
            // Widget description
            array(
            'description' => __('Widget for the Plugin TH Partner Slider','thpp')
        ));
    }

    // Creating widget front-end
    public function widget($args, $instance){

        extract( $args );
        echo $before_widget;
        $query_args = array(
            'post_type' 			=> 'thpp',
            'post_status' 			=> array( 'publish' ),
            'posts_per_page'		=> -1,
            'order'          		=> 'ASC',
            'orderby'        		=> 'date',
        );

        // WP Query Parameters
        $thpp_query = new WP_Query($query_args);
        $post_count = $thpp_query->post_count;

        global $post;

        if( $thpp_query->have_posts() ) { 
            $htmlout = thpp_getOutputList( $thpp_query, $post );
          }

        echo $htmlout;
        echo $after_widget;
    }

     // Widget Backend
    public function form($instance){

    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        return $instance;
    }

} // Class thppslidepanel_widget ends here


// Register and load the widget
function thpp_load_widget()
{
     register_widget('thppslidepanel_widget');
}
add_action('widgets_init', 'thpp_load_widget');