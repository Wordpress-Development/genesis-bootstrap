<?php

add_action( 'widgets_init', 'gb3_register_footer_widgets' );
function gb3_register_footer_widgets() {
    // Moved from sidebars.php to stay modular
    $footer = array(
        'id'            => 'footer-inside',
        'name'          => __( 'Footer', 'gb3' ),
        'description'   => __( 'This is located inside the footer container.',  'gb3'  ),
        'class'         => 'gb3-footer',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer-widgettitle">',
        'after_title'   => '</h3>',
    );
    register_sidebar( $footer );
}



add_filter('genesis_footer_output', 'gb3_genesis_footer_output', 10, 3);
function gb3_genesis_footer_output( $output, $backtotop_text, $creds_text ) {
if ( is_active_sidebar( 'footer-inside' ) ) {
    dynamic_sidebar( 'footer-inside' );
}
ob_start();
genesis_nav_menu( array(
	'theme_location'  => 'footer',
	'container'       => 'div',
	'container_class' => 'site-info-nav',
	'menu_class'      => 'menu genesis-nav-menu menu-footer list-inline',
	'depth'           => 1
) );
$footer_nav = ob_get_contents();
ob_end_clean();
$backtotop_text ='<a id="gototop" href="#" class="btn btn-primary btn-sm back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="glyphicon glyphicon-chevron-up"></i></a>';
$creds_text = 'Copyright [footer_copyright] <a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo('name') ) .' rel="nofollow"">'.get_bloginfo('name').'</a> &middot; All Rights Reserved';
$creds_text = apply_filters( 'genesis_footer_creds_text', $creds_text );
$creds = $creds_text ? sprintf( '<div class="creds">%s</div></div>', $creds_text ) : '';
$output = '<div class="site-info">';
$output .= $footer_nav;
$output .= $creds;
$output .= '</div>';
$output .= $backtotop_text;
    return $output;
}




add_filter( 'genesis_attr_nav-footer', 'gb3_add_nav_footer_attr' );
function gb3_add_nav_footer_attr( $attributes ){
    $attributes['role'] = 'navigation';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'http://schema.org/SiteNavigationElement';
    return $attributes;
}






add_action( 'wp_footer', 'amethyst_footer_menu', 9999 );
function amethyst_footer_menu() {
?>
<style type="text/css">
footer.site-footer {
    padding-top: 20px;
    padding-bottom: 20px;
    color: #767676;
    border-top: 1px solid #e5e5e5;
}
.site-footer .row > span,
.site-footer .row > div {
 padding: 10px 0px;
}
.site-footer h3.widgettitle {
    margin-top: 0px;
}
.creds, .menu-footer {
    text-align: center;
    margin-bottom: 10;
}
.back-to-top {
    cursor: pointer;
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: none;
}
@media only screen and (min-width : 992px){
    .creds {
        text-align: left;
        margin-bottom: 0;
    }
    .menu-footer {
        margin-bottom: 0;
        text-align: right;
    }
}
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
     	$(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#gototop').fadeIn();
            } else {
                $('#gototop').fadeOut();
            }
        });
        $('#gototop').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 900);
            return false;
       });
});
</script>
<?php
}
