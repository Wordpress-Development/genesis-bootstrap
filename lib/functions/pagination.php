<?php
/**
 * Add class "bsg-pagination-numeric" or "bsg-pagination-prev-next" depending on
 * the pagination style selected in the Genesis theme options
 *
 * @since 0.7.0
 */
remove_filter( 'genesis_attr_archive-pagination', 'genesis_attributes_pagination' );
add_filter( 'bsg-add-class', 'bsg_prev_next_or_numeric_archive_pagination', 10, 2 );
function bsg_prev_next_or_numeric_archive_pagination( $classes_array, $context ) {
    if ( 'archive-pagination' !== $context ) {
        return $classes_array;
    }

    if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
        $classes_array[] = 'bsg-pagination-numeric';
    } else {
        $classes_array[] = 'bsg-pagination-prev-next';
    }

    return $classes_array;

}



/**
 * Modify Previous Page / Next Page to use Bootstrap styling
 *
 * To generate the proper markup, we've recreated genesis_posts_nav()
 * and genesis_prev_next_posts_nav() since there was not a good way
 * to hook in and modify the markup.
 *
 * @since 0.7.0
 */

add_filter( 'genesis_prev_link_text', 'bsg_genesis_prev_link_text_numeric' );
add_filter( 'genesis_next_link_text', 'bsg_genesis_next_link_text_numeric' );

function bsg_genesis_prev_link_text_numeric( $text ) {
    if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
        return '<span aria-hidden="true">&laquo;</span>'
            . '<span class="sr-only">' . __( 'Previous Page', 'genesis' ) . '</span>';
    }
    return $text;
}

function bsg_genesis_next_link_text_numeric( $text ) {
    if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
        return '<span class="sr-only">' . __( 'Next Page', 'genesis' ) . '</span>'
            . '<span aria-hidden="true">&raquo;</span>';
    }
    return $text;
}





/**
 * Modify Previous Page / Next Page to use Bootstrap styling
 *
 * To generate the proper markup, we've recreated genesis_posts_nav()
 * and genesis_prev_next_posts_nav() since there was not a good way
 * to hook in and modify the markup.
 *
 * @since 0.7.0
 */
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
add_action( 'genesis_after_endwhile', 'bsg_genesis_posts_nav' );

/**
 * Replacement for genesis_posts_nav() that replaces the call to
 * genesis_prev_next_posts_nav() with
 * bsg_genesis_prev_next_posts_nav()
 *
 * @since 0.7.0
 */
function bsg_genesis_posts_nav() {
    if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
		bsg_genesis_numeric_posts_nav();
    } else {
        bsg_genesis_prev_next_posts_nav();
    }
}

/*
 * Replacement for genesis_prev_next_posts_nav() that uses the preferred
 * Bootstrap markup for Pager
 *
 * See http://getbootstrap.com/components/#aligned-links
 *
 * @since 0.7.0
 */
function bsg_genesis_prev_next_posts_nav() {
	$prev_link = get_previous_posts_link( apply_filters( 'genesis_prev_link_text', '<span aria-hidden="true">&larr;</span> ' . __( 'Previous Page', 'genesis' ) ) );
	$next_link = get_next_posts_link( apply_filters( 'genesis_next_link_text', __( 'Next Page', 'genesis' ) . ' <span aria-hidden="true">&rarr;</span>' ) );

	$prev = $prev_link ? '<li class="previous">' . $prev_link . '</li>' : '';
	$next = $next_link ? '<li class="next">' . $next_link . '</li>' : '';

	$nav .= genesis_markup( array(
		'html5'   => '<div class="clearfix"></div><nav %s><ul class="pager">',
		'xhtml'   => '<div class="navigation">',
		'context' => 'archive-pagination',
		'echo'    => false,
	) );

	$nav .= $prev;
	$nav .= $next;
	$nav .= '</ul></nav>';

	if ( $prev || $next )
		echo $nav;

}





/**
 * Apply Bootstrap Styles to Page links when a post has multiple
 * pages via the <!--nextpage--> tag.
 *
 * See https://codex.wordpress.org/Styling_Page-Links
 *
 * @since 0.4.0
 */

// remove default post_content_nav
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );

// add custom post_content_nav
add_action( 'genesis_entry_content', 'bsg_do_post_content_nav', 12 );

// filter page links for correct bootstrap format
add_filter( 'wp_link_pages_link', 'bsg_wp_link_pages_link' );

function bsg_wp_link_pages_link( $link ) {
    if ( $link && '<' !== $link[0] ) {
        // this link is NOT an anchor tag,
        // it is the current item
        // add anchor tag and class active
        return '<li class="active"><a href="#">' . $link . '</a></li>';
    } else {
        return '<li>' . $link . '</li>';
    }
}

function bsg_do_post_content_nav( $attr ) {
    wp_link_pages( array(
        'before' => '<div class="bsg-post-content-nav">'
                . '<p>' . __( 'Pages:', 'genesis' ) . '</p>'
                . genesis_markup( array(
                    'html5'   => '<nav %s><ul>',
                    'xhtml'   => '<div %s><ul>',
                    'context' => 'entry-pagination',
                    'echo'    => false,
                ) ),
        'after'  => genesis_html5() ? '</ul></nav></div>' : '</ul></div></div>',
    ) );
}





function bsg_genesis_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    if ( $paged >= 1 )
        $links[] = $paged;

    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="clearfix"></div>';

    printf( '<div %s>', genesis_attr( 'archive-pagination' ) );

    $before_number = genesis_a11y( 'screen-reader-text' ) ? '<span class="sr-only">' . __( 'Page ', 'genesis' ) .  '</span>' : '';

    printf( '<ul %s>', genesis_attr( 'pagination' ) ); // pagination-lg pagination-sm

    if ( get_previous_posts_link() )
        printf( '<li class="pagination-previous">%s</li>' . "\n", get_previous_posts_link( apply_filters( 'genesis_prev_link_text', '&#x000AB; ' . __( 'Previous Page', 'genesis' ) ) ) );

    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), $before_number . '1' );
    }

    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"  aria-label="' . __( 'Current page', 'genesis' ) . '"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $before_number . $link );
    }

    if ( ! in_array( $max, $links ) ) {
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $before_number . $max );
    }

    if ( get_next_posts_link() )
        printf( '<li class="pagination-next">%s</li>' . "\n", get_next_posts_link( apply_filters( 'genesis_next_link_text', __( 'Next Page', 'genesis' ) . ' &#x000BB;' ) ) );
    echo '</ul></div>' . "\n";
}