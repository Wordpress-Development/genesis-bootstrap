<?php

class Bootstrap_Responsive_Video extends WP_Widget {

	function __construct() {
		 $options = array( 'classname' => 'bootstrap-responsive-video' ,
				'description' => __( 'Video from YouTube, Vimeo, and more.' , 'bootstrap-responsive-video' ) ,
		 );
		 $this->WP_Widget( 'bootstrap_responsive_video' , __( 'Bootstrap Responsive Video Embed' , 'bootstrap-responsive-video' ) , $options );
	}

	function form( $instance ) {
		$video_url = isset( $instance[ 'video_url' ] ) ? $instance[ 'video_url' ] : "";
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'video_url' ); ?>">
	 			       <?php _e( 'Video url' , 'bootstrap-responsive-video' ); ?>
				</label>
				<input type="text" value="<?php echo esc_url( $video_url ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" placeholder="e.g. www.youtube.com/watch?v=mOXRZ0eYSA0" \>
			</p>
		<?php
	}

	function update( $new_instance , $previous_instance ) {
		$instance = $previous_instance;
		$video_url = isset( $new_instance[ 'video_url' ] ) ? $new_instance[ 'video_url' ] : "";
		if ( $video_url ) {
			$raw_iframe_code = gb3__get_raw_iframe_code( $video_url );
			$instance[ 'video_source' ] = gb3_get_iframe_attribute( $raw_iframe_code , 'src' );
			$instance[ 'aspect_ratio_class' ] = gb3_get_class_for_aspect_ratio( $raw_iframe_code );
			$instance[ 'video_url' ] = strip_tags( $video_url );
		}
		return $instance;
	}

	function widget( $args , $instance ) {
		$video_source = isset( $instance[ 'video_source' ] ) ? $instance[ 'video_source' ] : "";
		$aspect_ratio_class = isset( $instance[ 'aspect_ratio_class' ] ) ? $instance[ 'aspect_ratio_class' ] : "";
		if ( $video_source ) {
			$bootstrap_responsive_video = get_bootstrap_responsive_video( $video_source , $aspect_ratio_class );
			echo $args[ 'before_widget' ] . $bootstrap_responsive_video . $args[ 'after_widget' ];
		}
	}

}



function gb3_get_raw_iframe_code( $url ) {
	$raw_code = wp_oembed_get( esc_url( $url ) );
	return $raw_code;
}

function get_bootstrap_responsive_video( $src , $class ) {
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
	if ( is_ratio_closer_to_four_by_three( $aspect_ratio ) ) {
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


add_action( 'widgets_init' , 'gb3_register_widget_responsive_embed' );
function gb3_register_widget_responsive_embed() {
	register_widget( 'Bootstrap_Responsive_Video' );
}
