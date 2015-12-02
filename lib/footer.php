<?php

add_filter('genesis_footer_output', 'gb3_genesis_footer_output', 10, 3);

function gb3_genesis_footer_output( $output, $backtotop_text, $creds_text ) {

if ( is_active_sidebar( 'footer-inside' ) ) {
     dynamic_sidebar( 'footer-inside' );
}

ob_start();

genesis_nav_menu( array(
	'theme_location'  => 'footer',
	'container'       => 'div',
	'container_class' => '',
	'menu_class'      => 'menu genesis-nav-menu menu-footer list-inline',
	'depth'           => 1
) );

$footer_nav = ob_get_contents();

ob_end_clean();

$creds_text = '<div class="creds">Copyright [footer_copyright] <a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo('name') ) .' rel="nofollow"">'.get_bloginfo('name').'</a> &middot; All Rights Reserved</div>';

$backtotop_text ='<a id="back-to-top" href="#" class="btn btn-primary btn-sm back-to-top" role="button" title="Click to return on the top page" onclick="" data-toggle="tooltip" data-placement="left"><i class="glyphicon glyphicon-chevron-up"></i></a>';

$output = '<div class="row site-info">';
$output .= '<div class="col-sm-12 col-md-6 col-md-push-6">' . $footer_nav . '</div>';
$output .= '<div class="col-sm-12 col-md-6 col-md-pull-6">' . $creds_text . '</div>';
$output .= '</div>';
$output .= $backtotop_text;

    return $output;

}


add_action( 'wp_footer', 'amethyst_footer_menu', 9999 );
function amethyst_footer_menu() {
?>
<style type="text/css">
.creds, .nav-footer {
    text-align: center;
    margin-bottom: 0;
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
    .nav-footer {
        margin-bottom: 0;
        text-align: right;
    }
}
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
     	$(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 900);
            return false;
       });
});
</script>
<?php
}
