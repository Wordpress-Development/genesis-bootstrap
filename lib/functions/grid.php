<?php

// add bootstrap classes
$genesis_atts = array(
                  'nav-primary',
                  'nav-secondary',
                  'site-header',
                  'site-inner',
                  'content-sidebar-wrap',
                  'content',
                  'sidebar-primary',
                  'sidebar-secondary',
                  'archive-pagination',
                  'entry-content',
                  'entry-pagination',
                  'site-footer',
                  'nav-footer',
                  'comment-reply',
                  'comment-header',
                  'comment-time-link',
                  'comment-media',
                  'comment',
                  'comment-list',
                  'widget',
                  'entry',
		  'jumbotron-header'

    		);
foreach ( $genesis_atts as $context ) {
	$context = "genesis_attr_$context";
	add_filter( $context, 'bsg_add_markup_class', 10, 2 );
}

function bsg_add_markup_class( $attr, $context ) {
    $classes_to_add = apply_filters ('bsg-classes-to-add',
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
            'comment'                   => 'comment-body media',
            'comment-reply'             => 'reply text-muted small pull-right',
            'comment-header'            => 'media-heading',
            'comment-time-link'         => 'text-muted small',
            'comment-media'             => 'media-left',
            'nav-footer'                => 'pull-right',
            'comment-list'              => 'list-unstyled',
            'widget'                    => 'panel panel-default',
            'entry'                     => 'panel panel-default',
            'jumbotron-header'          => 'fullwidth'

        ),
        $context,
        $attr
    );
    $value = isset( $classes_to_add[ $context ] ) ? $classes_to_add[ $context ] : array();
    if ( is_array( $value ) ) {
        $classes_array = $value;
    } else {
        $classes_array = explode( ' ', (string) $value );
    }
    $classes_array = array_map( 'sanitize_html_class', $classes_array );
    $attr['class'] .= ' ' . implode( ' ', $classes_array );
    return $attr;
}
