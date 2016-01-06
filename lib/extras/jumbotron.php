<?php

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


add_action('widgets_init', 'register_jumbotron_sidebar');
function register_jumbotron_sidebar() {
    
    $jumbotron = array(
        'id'            => 'jumbotron-widget-area',
        'name'          => __( 'Jumbotron', 'gb3' ),
        'description'   => __( 'This is located inside the jumbotron header.',  'gb3'  ),
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h1>',
        'after_title'   => '</h1>',
        
    );  
    register_sidebar( $jumbotron );
}


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
