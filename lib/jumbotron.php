<?php

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_after_header', 'do_jumbotron_widget_area' );


function do_jumbotron_widget_area() {
	do_action('jumbotron');
}


add_action( 'jumbotron', 'jumbotron_widget_area_callback' );
function jumbotron_widget_area_callback() {

if ( is_active_sidebar( 'jumbotron-widget-area' ) ): ?>
<header <?php echo genesis_attr( 'jumbotron-header' ); ?>>
	<?php genesis_structural_wrap( 'jumbotron-outer' ); ?>
        	<div class="jumbotron">
                	<?php genesis_structural_wrap( 'jumbotron-inner' ); ?>
                    		<?php dynamic_sidebar( 'jumbotron-widget-area' ); ?>
                		<?php genesis_structural_wrap( 'jumbotron-inner', 'close' ); ?>
            		</div>
            	<?php genesis_structural_wrap( 'jumbotron-outer', close ); ?>
        </header>
<?php endif;

}






/*
    add_action( 'template_redirect', 'bsg_title_area_jumbotron_unit_on_front_page' );

function bsg_title_area_jumbotron_unit_on_front_page() {
    if ( is_front_page() ) {
        add_action( 'genesis_site_title', 'bsg_jumbotron_unit_open', 2 );
        add_action( 'genesis_site_description', 'bsg_jumbotron_unit_close', 30 );
    }
    else {
        remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
        remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
    }
}



function bsg_jumbotron_unit_open() {
echo '<div class="jumbotron">';
genesis_structural_wrap( 'jumbotron-inner' );
}

function bsg_jumbotron_unit_close() {
    genesis_structural_wrap( 'jumbotron-inner', 'close' );
    echo '</div>';
}

// */
