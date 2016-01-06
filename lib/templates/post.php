<?php

// Should we run this only in the loop since it messes with genesis widgets
add_action('genesis_entry_header', 'gb3_entry_archive_panel_wrapper_close', 1);
function gb3_entry_archive_panel_wrapper_close() {
    echo '<div class="panel-body">';
}
add_action('genesis_entry_footer', 'gb3_entry_archive_panel_wrapper_open' , 999);
function gb3_entry_archive_panel_wrapper_open() {
    echo '</div>';
}
