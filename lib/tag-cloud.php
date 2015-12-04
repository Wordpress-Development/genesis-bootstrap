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
