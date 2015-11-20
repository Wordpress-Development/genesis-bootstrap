 <?php



// add bootstrap classes
add_filter( 'genesis_attr_nav-primary',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_nav-secondary',       'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-header',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-inner',          'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_content-sidebar-wrap','bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_content',             'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-primary',     'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-secondary',   'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_archive-pagination',  'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_entry-content',       'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_entry-pagination',    'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-footer',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_comment',             'bsg_add_markup_class', 10, 2 );

function bsg_add_markup_class( $attr, $context ) {
    // default classes to add
    $classes_to_add = apply_filters ('bsg-classes-to-add',
        // default bootstrap markup values
        array(
            'nav-primary'               => 'navbar navbar-inverse navbar-static-top',
            'nav-secondary'             => 'navbar navbar-default navbar-static-top',
            'site-header'               => '',
            'site-inner'                => '',
            'site-footer'               => '',
            'content-sidebar-wrap'      => 'row',
            'content'                   => 'col-sm-12 col-md-8 col-lg-9',
            'sidebar-primary'           => 'hidden-sm col-md-4 col-lg-3',
            'archive-pagination'        => 'clearfix',
            'entry-content'             => 'clearfix',
            'entry-pagination'          => 'clearfix bsg-pagination-numeric',
            'comment'          => ' comment-body media'
        ),
        $context,
        $attr
    );

    // populate $classes_array based on $classes_to_add
    $value = isset( $classes_to_add[ $context ] ) ? $classes_to_add[ $context ] : array();

    if ( is_array( $value ) ) {
        $classes_array = $value;
    } else {
        $classes_array = explode( ' ', (string) $value );
    }

    // apply any filters to modify the class
    $classes_array = apply_filters( 'bsg-add-class', $classes_array, $context, $attr );

    $classes_array = array_map( 'sanitize_html_class', $classes_array );

    // append the class(es) string (e.g. 'span9 custom-class1 custom-class2')
    $attr['class'] .= ' ' . implode( ' ', $classes_array );

    return $attr;
}






/* Modify the Bootstrap Classes being applied
 * based on the Genesis template chosen
 */

// modify bootstrap classes based on genesis_site_layout
add_filter('bsg-classes-to-add', 'bsg_modify_classes_based_on_template', 10, 3);

// remove unused layouts

function bsg_layout_options_modify_classes_to_add( $classes_to_add ) {

    $layout = genesis_site_layout();

    // content-sidebar          // default

    // full-width-content       // supported
    if ( 'full-width-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-12';
    }

    // sidebar-content          // supported
     if ( 'sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-12 col-md-8 col-lg-9 col-md-push-4 col-lg-push-3';
        $classes_to_add['sidebar-primary'] = 'hidden-xs hidden-sm col-md-4 col-lg-3 col-md-pull-8 col-lg-pull-9';
    }

    // content-sidebar-sidebar  // supported
    if ( 'content-sidebar-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6';
        $classes_to_add['sidebar-primary'] = 'col-sm-3';
        $classes_to_add['sidebar-secondary'] = 'col-sm-3';
    }


    // sidebar-sidebar-content  // supported
    if ( 'sidebar-sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6 col-sm-push-6';
        $classes_to_add['sidebar-primary'] = 'col-sm-3 col-sm-pull-3';
        $classes_to_add['sidebar-secondary'] = 'col-sm-3 col-sm-pull-9';
    }


    // sidebar-content-sidebar  // supported
    if ( 'sidebar-content-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6 col-sm-push-3';
        $classes_to_add['sidebar-primary'] = 'col-sm-3 col-sm-push-3';
        $classes_to_add['sidebar-secondary'] = 'col-sm-3 col-sm-pull-9';
    }

    return $classes_to_add;
};

function bsg_modify_classes_based_on_template( $classes_to_add, $context, $attr ) {
    $classes_to_add = bsg_layout_options_modify_classes_to_add( $classes_to_add );

    return $classes_to_add;
}



/* Skip to Main Content - Accessibility Link
 *
 */

// add markup for the link
add_action( 'genesis_before', 'bsg_skip_navigation_add_link', 5 );
// add id="main-content-container" as target
add_filter( 'genesis_attr_content', 'bsg_skip_navigation_add_id_for_target' );


function bsg_skip_navigation_add_link() {
    echo '<a class="skip-to-main-content btn btn-large btn-danger" href="#main-content-container" tabindex="1">skip to main content</a>';
}

function bsg_skip_navigation_add_id_for_target( $attr ) {
    $attr['id'] = __( 'main-content-container', 'bsg' );

    return $attr;
}




remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action(    'genesis_after_content', 'genesis_get_sidebar_alt' );
