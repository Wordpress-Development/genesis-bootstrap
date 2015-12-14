<?php

remove_theme_support( 'genesis-responsive-viewport' );
remove_action(  'genesis_doctype', 'genesis_do_doctype' );

add_action( 'genesis_doctype', 'twbsg_conditional_comments' );
function twbsg_conditional_comments() {
    
$doctype = <<<EOT
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
EOT;
    
    $doctype = preg_replace('/\t/', '', $doctype);
    echo $doctype;
    
}
