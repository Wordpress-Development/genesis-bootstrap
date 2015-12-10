<?php
// Display Archive


//remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
//add_action(    'genesis_entry_header',  'genesis_do_post_image', 0 );
add_filter( "genesis_attr_entry-image", 'bsg_archive_image_attr_filter' );
function bsg_archive_image_attr_filter( $attributes ) {
    $attributes['class'] .= ' wp-post-image archive-featured-image img-responsive';
    return $attributes;
}



// Display Single
add_action( 'genesis_entry_header', 'bsg_single_featured_image', 5 );
function bsg_single_featured_image() {
    global $post;
    if ( ! is_singular() ) {
        return;
    }
    if ( ! has_post_thumbnail() ) {
        return;
    }
    $featured_image_attr = apply_filters( 'bsg-featured-image-attr', array(
        'class' => 'single-featured-image img-responsive'
    ) );
    $size = apply_filters( 'bsg-featured-image', 'bsg-featured-image' );
    the_post_thumbnail( $size, $featured_image_attr );
}
