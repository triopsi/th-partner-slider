<?php
/**
* Plugin Name: TH Partner Slider
* Description: Das passende Widget fuer die Startseite.
* Version: 1.0
* Plugin URI: https://wiki.profoxi.de
* Author: Triopsi
* Author URI: https://wiki.profoxi.de/
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
            __('TH Partner Slider', 'thslidetext'),
            // Widget description
            array(
            'description' => __('Das passende Widget fuer die Sidebar.','thslidetext')
        ));
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance){

        extract( $args );
        // $cell1 = $instance[ 'cell1' ];
        // $cell2 = $instance[ 'cell2' ];
        // $cell3 = $instance[ 'cell3' ];
        // $button = $instance[ 'button' ] ? true : false;
        // $font_color = $instance[ 'font_color' ];
        // $button_text = $instance[ 'button_text' ];
        // $button_url = $instance[ 'button_url' ];

        // $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $before_widget;
        // if ( $title ) {
        //     echo $before_title . $title . $after_title;
        // }

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
            $htmlout = getOutputList( $thpp_query, $post );
          }
        echo $htmlout;
        echo $after_widget;
    }

    /**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
    }
    
    /**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}



     // Widget Backend
    public function form($instance){

        //Defaults
        // $defaults = array( 
        //     'cell1' => __('Zeile 1', 'thslidetext'),
        //     'cell2' => __('Zeile 2', 'thslidetext'),
        //     'cell3' => __('Zeile 3', 'thslidetext'),
        //     'button' => false,
        //     'font_color' => '#ffffff',
        //     'button_text' => __('Link Text', 'thslidetext'),
        //     'button_url' => 'http://',
        // );
        // $instance = wp_parse_args( ( array ) $instance, $defaults );
        // Widget admin form
        ?>
        <!-- <div style="margin-bottom:10px;">
            <label for="<?php echo $this->get_field_id('cell1'); ?>"><?php _e('Zeile 1:'); ?>
            <input class="widefat" id="<?= $this->get_field_id('cell1'); ?>" name="<?= $this->get_field_name('cell1'); ?>" type="text" value="<?= esc_attr( $instance[ 'cell1' ] ); ?>" />
            
            <label for="<?php echo $this->get_field_id('cell2'); ?>"><?php _e('Zeile 2:'); ?>
            <input class="widefat" id="<?= $this->get_field_id('cell2'); ?>" name="<?= $this->get_field_name('cell2'); ?>" type="text" value="<?= esc_attr( $instance[ 'cell2' ] ); ?>" />
            
            <label for="<?php echo $this->get_field_id('cell3'); ?>"><?php _e('Zeile 3:'); ?>
            <input class="widefat" id="<?= $this->get_field_id('cell3'); ?>" name="<?= $this->get_field_name('cell3'); ?>" type="text" value="<?= esc_attr( $instance[ 'cell3' ] ); ?>" />

            <p>
                <label for="<?php echo $this->get_field_id( 'font_color' ); ?>" style="display:block;"><?php _e( 'Schriftfarbe:' ); ?></label> 
                <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'font_color' ); ?>" name="<?php echo $this->get_field_name( 'font_color' ); ?>" type="text" value="<?= esc_attr( $instance[ 'font_color' ] ); ?>" />
            </p>

            <hr>
            <p>
                <input class="widefat" id="<?= $this->get_field_id('button'); ?>" name="<?= $this->get_field_name('button'); ?>" type="checkbox" <?php checked( $instance[ 'button' ], 'on' ); ?> />
                <label for="<?php echo $this->get_field_id('button'); ?>"><?php _e('Button anzeigen?'); ?>
            </p>

            <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button Text:'); ?>
            <input class="widefat" id="<?= $this->get_field_id('button_text'); ?>" name="<?= $this->get_field_name('button_text'); ?>" type="text" value="<?= esc_attr( $instance[ 'button_text' ] ); ?>"/>

            <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('Button URL:'); ?>
            <input class="widefat" id="<?= $this->get_field_id('button_url'); ?>" name="<?= $this->get_field_name('button_url'); ?>" type="text" value="<?= esc_attr( $instance[ 'button_url' ] ); ?>"/>
               
        </div> -->
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        // $instance['cell1'] = (!empty($new_instance['cell1'])) ? strip_tags($new_instance['cell1']) : '';
        // $instance['cell2'] = (!empty($new_instance['cell2'])) ? strip_tags($new_instance['cell2']) : '';
        // $instance['cell3'] = (!empty($new_instance['cell3'])) ? strip_tags($new_instance['cell3']) : '';
        // $instance['button'] = (!empty($new_instance['button'])) ? $new_instance['button'] : false;
        // $instance['font_color'] = (!empty($new_instance['font_color'])) ? strip_tags($new_instance['font_color']) : '#ffffff';
        // $instance['button_text'] = (!empty($new_instance['button_text'])) ? strip_tags($new_instance['button_text']) : '';
        // $instance['button_url'] = (!empty($new_instance['button_url'])) ? strip_tags($new_instance['button_url']) : '';
        return $instance;
    }

} // Class thppslidepanel_widget ends here


// Register and load the widget
function thpp_load_widget()
{
     register_widget('thppslidepanel_widget');
}
add_action('widgets_init', 'thpp_load_widget');