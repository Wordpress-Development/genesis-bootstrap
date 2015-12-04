<?php

add_filter('wp_generate_tag_cloud', 'gb3_title_tag_cloud_filter', 10, 2);
function gb3_title_tag_cloud_filter($return, $tags) {
   // $pattern = '/(\d+) topics/';
    foreach ( $tags as $key => $tag ) {
            $tag_name = $tags[ $key ]->name;
        	$tag_title = $tags[ $key ]->name;
            $tag_link = $tags[ $key ]->link;
            $term_id = $tags[ $key ]->id;
        echo "<a href='".$tag_link."' title='".$tag_title."' class='tag-link-".$term_id." '><span class='label label-primary'>".$tag_name."</span></a>\r\n";
    }
}


/* 
// Alternative Method

add_filter('wp_generate_tag_cloud', 'gb3_tag_cloud',10,1);
function gb3_tag_cloud($string){
   return preg_replace("/style='font-size:.+pt;'/", '', $string);
}

add_filter( 'wp_tag_cloud' , 'gb3_filter_tag_cloud' ) ; 
function gb3_filter_tag_cloud( $markup ) {
	$regex = '/(<a[^>]+?>)([^<]+?)(<\/a>)/';
	$replace_with = "$1<span class='label label-primary'>$2</span>$3";
	$markup = preg_replace( $regex , $replace_with , $markup );
  
	return $markup;
}

// */
