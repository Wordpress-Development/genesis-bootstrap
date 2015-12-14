<?php

/*----------------------------------------------------------------------------*
 * Bootstrap Head Support
 *----------------------------------------------------------------------------*/
 
remove_theme_support( 'genesis-responsive-viewport' );
remove_action(  'genesis_doctype', 'genesis_do_doctype' );
remove_action( 'wp_head', 'genesis_do_meta_pingback' );
remove_action( 'wp_head', 'genesis_html5_ie_fix' );


add_action( 'genesis_doctype', 'twbsg_conditional_comments' );
function twbsg_conditional_comments() {
$doctype = <<<EOT
<!DOCTYPE html>
<html lang="en" dir="ltr" class="no-js">
<head profile="http://gmpg.org/xfn/11">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
EOT;
    $doctype = preg_replace('/\t/', '', $doctype);
    echo $doctype;
}


add_action( 'wp_head', 'html5_shiv_respond_js_add_last', 9999 );
function html5_shiv_respond_js_add_last() { ?>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php }
