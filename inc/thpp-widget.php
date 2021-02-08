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

        //extract the args
        extract( $args );

        //Defaults options
        $defaults = array( 
            'thpp_link_target' => '_self',
            'thpp_wg_items' => 4,
            'thpp_wg_loop' => true,
            'thpp_wg_slideMove' => 2,
            'thpp_wg_auto' => true,
            'thpp_wg_pauseOnHover' => true,
            'thpp_wg_speed' => 600,
            'thpp_wg_autoWidth' => false,
            'thpp_wg_controls' => false,
            'thpp_wg_pager' => false,
        );

        //merge the options with default options
        $instance = wp_parse_args( ( array ) $instance, $defaults );

        //check the target link
        if($instance['thpp_link_target']){
            $instance['thpp_link_target'] = '_blank';
        }else{
            $instance['thpp_link_target'] = '_self';
        }

        //print scripts
        thpp_print_scripts( $instance, "thpp_".$widget_id );

        //print before scripte and text
        echo $before_widget;

        //set the query
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

        //gloabl post
        global $post;

        //check slideshow and print the output
        if( $thpp_query->have_posts() ) { 
            echo thpp_getOutputList( $thpp_query, $post, "thpp_".$widget_id, $instance['thpp_link_target'] );
        }

        //print after widget scripts and text
        echo $after_widget;
    }

    // Widget Backend
    public function form($instance){

        //Defaults
        $defaults = array( 
            'thpp_link_target' => false,
            'thpp_wg_items' => 4,
            'thpp_wg_loop' => true,
            'thpp_wg_slideMove' => 2,
            'thpp_wg_auto' => true,
            'thpp_wg_pauseOnHover' => true,
            'thpp_wg_speed' => 600,
            'thpp_wg_autoWidth' => false,
            'thpp_wg_controls' => false,
            'thpp_wg_pager' => false,
        );

        $instance = wp_parse_args( ( array ) $instance, $defaults );
        // Widget admin form
        ?>
        <div style="margin-bottom:10px;">
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_items')); ?>"><?php _e('Item size', 'thpp'); ?></label> <a href="#" title="<?php _e('Number of partner to show at a time', 'thpp'); ?>">[?]</a>
                <input class="widefat" step="1" step="1" min="1" max="" id="<?php echo esc_attr($this->get_field_id('thpp_wg_items')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_items')); ?>" type="number" value="<?php echo esc_attr( $instance[ 'thpp_wg_items' ] ); ?>" />
            </p> 
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_slideMove')); ?>"><?php _e('Slide move', 'thpp'); ?></label> <a href="#" title="<?php _e('Number of partner to be moved at a time', 'thpp'); ?>">[?]</a>
                <input class="widefat" step="1" step="1" min="1" max="" id="<?php echo esc_attr($this->get_field_id('thpp_wg_slideMove')); ?>" name="<?php echo $this->get_field_name('thpp_wg_slideMove'); ?>" type="number" value="<?php echo esc_attr( $instance[ 'thpp_wg_slideMove' ] ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_speed')); ?>"><?php _e('Speed', 'thpp'); ?></label> <a href="#" title="<?php _e('Transition duration (in ms). // ex = speed:400;', 'thpp'); ?>">[?]</a>
                <input class="widefat" step="1" step="1" min="1" max="" id="<?php echo esc_attr($this->get_field_id('thpp_wg_speed')); ?>" name="<?php echo $this->get_field_name('thpp_wg_speed'); ?>" type="number" value="<?php echo esc_attr( $instance[ 'thpp_wg_speed' ] ); ?>" />
            </p>
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_auto')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_auto')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_auto' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_auto')); ?>"><?php _e('Auto start', 'thpp'); ?></label> <a href="#" title="<?php _e('If true, the Slider will automatically start to play.', 'thpp'); ?>">[?]</a>
            </p>
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_pauseOnHover')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_pauseOnHover')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_pauseOnHover' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_pauseOnHover')); ?>"><?php _e('Pause on hover', 'thpp'); ?></label> <a href="#" title="<?php _e('Pause autoplay on hover.', 'thpp'); ?>">[?]</a>
            </p> 
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_autoWidth')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_autoWidth')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_autoWidth' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_autoWidth')); ?>"><?php _e('Auto width', 'thpp'); ?></label> <a href="#" title="<?php _e('Custom width for each slide', 'thpp'); ?>">[?]</a>
            </p>
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_controls')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_controls')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_controls' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_controls')); ?>"><?php _e('Show controls', 'thpp'); ?></label> <a href="#" title="<?php _e('If false, prev/next buttons will not be displayed.', 'thpp'); ?>">[?]</a>
            </p>
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_pager')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_pager')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_pager' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_pager')); ?>"><?php _e('Show pager controls', 'thpp'); ?></label> <a href="#" title="<?php _e('Enable pager option', 'thpp'); ?>">[?]</a>
            </p>  
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_wg_loop')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_wg_loop')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_wg_loop' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_wg_loop')); ?>"><?php _e('Loop', 'thpp'); ?></label> <a href="#" title="<?php _e('If false, will disable the ability to loop back to the beginning of the slide when on the last element.', 'thpp'); ?>">[?]</a>
            </p>   
            <p>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('thpp_link_target')); ?>" name="<?php echo esc_attr($this->get_field_name('thpp_link_target')); ?>" type="checkbox" <?php checked( $instance[ 'thpp_link_target' ] ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('thpp_link_target')); ?>"><?php _e('Link target open in new tab', 'thpp'); ?></label> <a href="#" title="<?php _e('If true, link will open in a new tab or window.', 'thpp'); ?>">[?]</a>
            </p>    
        </div>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['thpp_wg_items'] = (!empty($new_instance['thpp_wg_items'])) ? strip_tags($new_instance['thpp_wg_items']) : '';
        $instance['thpp_wg_loop'] = (!empty($new_instance['thpp_wg_loop'])) ? true : false;
        $instance['thpp_wg_slideMove'] = (!empty($new_instance['thpp_wg_slideMove'])) ? strip_tags($new_instance['thpp_wg_slideMove']) : '';
        $instance['thpp_wg_auto'] = (!empty($new_instance['thpp_wg_auto'])) ? true : false;
        $instance['thpp_wg_pauseOnHover'] = (!empty($new_instance['thpp_wg_pauseOnHover'])) ? true : false;
        $instance['thpp_wg_speed'] = (!empty($new_instance['thpp_wg_speed'])) ? strip_tags($new_instance['thpp_wg_speed']) : '';
        $instance['thpp_wg_autoWidth'] = (!empty($new_instance['thpp_wg_autoWidth'])) ? true : false;
        $instance['thpp_wg_controls'] = (!empty($new_instance['thpp_wg_controls'])) ? true : false;
        $instance['thpp_wg_pager'] = (!empty($new_instance['thpp_wg_pager'])) ? true : false;
        $instance['thpp_link_target'] = (!empty($new_instance['thpp_link_target'])) ? true : false;
        return $instance;
    }

} // Class thppslidepanel_widget ends here


// Register and load the widget
function thpp_load_widget()
{
     register_widget('thppslidepanel_widget');
}
add_action('widgets_init', 'thpp_load_widget');