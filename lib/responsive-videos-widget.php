<?php

add_action( 'widgets_init', function(){
     register_widget( 'Bootstrap_Responsive_Video' );
});


/**
 * Adds Bootstrap_Responsive_Video widget.
 */
class Bootstrap_Responsive_Video extends WP_Widget {

  
  	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		 $widget_options = array( 'classname' => 'bootstrap-responsive-video' ,
				'description' => __( 'Video from YouTube, Vimeo, and more.' , 'bootstrap-responsive-video' ) ,
		 );
        	$control_ops = array('width' => 250);
         	parent::__construct('bootstrap_responsive_video','Bootstrap Responsive Video Embed',$widget_options,$control_ops);
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {  
	  	if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Video Title' );
		}
		$video_url = isset( $instance[ 'video_url' ] ) ? $instance[ 'video_url' ] : "";
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'video_url' ); ?>">
	 			       <?php _e( 'Video url' , 'bootstrap-responsive-video' ); ?>
				</label>
				<input type="text" value="<?php echo esc_url( $video_url ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" placeholder="e.g. www.youtube.com/watch?v=mOXRZ0eYSA0" \>
			</p>
		<?php
	}

    
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance , $old_instance ) {
         // $instance = array();
	    $instance = $old_instance;
		$video_url = isset( $new_instance[ 'video_url' ] ) ? $new_instance[ 'video_url' ] : "";
		if ( $video_url ) {
		    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$raw_iframe_code = gb3_get_raw_iframe_code( $video_url );
			$instance[ 'video_source' ] = gb3_get_iframe_attribute( $raw_iframe_code , 'src' );
			$instance[ 'aspect_ratio_class' ] = gb3_get_class_for_aspect_ratio( $raw_iframe_code );
			$instance[ 'video_url' ] = strip_tags( $video_url );
		}
		return $instance;
	}
    
    
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args , $instance ) {
		$video_source = isset( $instance[ 'video_source' ] ) ? $instance[ 'video_source' ] : "";
		$aspect_ratio_class = isset( $instance[ 'aspect_ratio_class' ] ) ? $instance[ 'aspect_ratio_class' ] : "";
		if ( $video_source ) {
			$bootstrap_responsive_video = gb3_get_bootstrap_responsive_video( $video_source , $aspect_ratio_class );
 	  		echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
        	echo $bootstrap_responsive_video; 
			echo $args[ 'after_widget' ];
		}
	}
  
} // class Bootstrap_Responsive_Video



function gb3_get_raw_iframe_code( $url ) {
	$raw_code = wp_oembed_get( esc_url( $url ) );
	return $raw_code;
}

function gb3_get_bootstrap_responsive_video( $src , $class ) {
	$max_width = apply_filters( 'gb3_video_max_width' , '580' );
	return
		"<div class='responsive-video-container' style='max-width:{$max_width}px'>
			<div class='embed-responsive {$class}'>
			     <iframe class='embed-responsive-item' src='{$src}'>
			     </iframe>
			 </div>
		 </div>\n";
}

function gb3_get_iframe_attribute( $iframe , $attribute ) {
	$pattern	= '/<iframe.*?' . $attribute . '=\"([^\"]+?)\"/';
	preg_match( $pattern , $iframe , $matches );
	if ( isset( $matches[ 1 ] ) ) {
		return $matches[ 1 ];
	}
}

function gb3_get_class_for_aspect_ratio( $embed_code ) {
	$bootstrap_apect_ratio = gb3_get_bootstrap_aspect_ratio( $embed_code );
	return	'embed-responsive-' . $bootstrap_apect_ratio;
}

function gb3_get_bootstrap_aspect_ratio( $embed_code ) {
	$aspect_ratio = gb3_get_raw_aspect_ratio( $embed_code );
	if ( gb3_is_ratio_closer_to_four_by_three( $aspect_ratio ) ) {
		return '4by3';
	}
	return '16by9';
}

function gb3_get_raw_aspect_ratio( $embed_code ) {
	$embed_width = gb3_get_iframe_attribute( $embed_code , 'width' );
	$embed_height =	gb3_get_iframe_attribute( $embed_code , 'height' );
	if ( $embed_width && $embed_height ) {
		$aspect_ratio = floatval( $embed_width ) / floatval( $embed_height );
		return $aspect_ratio;
	}
}

function gb3_is_ratio_closer_to_four_by_three( $ratio ) {
	$difference_from_four_by_three = gb3_get_difference_from_four_by_three( $ratio );
	$difference_from_sixteen_by_nine = gb3_get_difference_from_sixteen_by_nine( $ratio );
	return ( $difference_from_four_by_three < $difference_from_sixteen_by_nine );
}

function gb3_get_difference_from_four_by_three( $value ) {
	$four_by_three = 1.3333;
	$difference_from_four_by_three = abs( $value - $four_by_three );
	return $difference_from_four_by_three;
}

function gb3_get_difference_from_sixteen_by_nine( $value ) {
	$sixteen_by_nine = 1.777;
	$difference_from_sixteen_by_nine = abs( $value - $sixteen_by_nine );
	return $difference_from_sixteen_by_nine;
}

add_filter( 'embed_oembed_html' , 'gb3_responsive_embed_result_filter' );
function gb3_responsive_embed_result_filter( $raw_embed_code ) {
	$src = gb3_get_iframe_attribute( $raw_embed_code , 'src' );
	$class = gb3_get_class_for_aspect_ratio( $raw_embed_code );
	$bootstrap_markup = gb3_get_bootstrap_responsive_video( $src , $class );
	return "<div class='post-responsive-video'>" . $bootstrap_markup . "</div>";
}
