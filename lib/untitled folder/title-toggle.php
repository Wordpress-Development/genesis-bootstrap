<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_title-toggle',
		'title' => 'Title Toggle',
		'fields' => array (
			array (
				'key' => 'field_568b84d254b82',
				'label' => 'Hide Title',
				'name' => 'hide_title',
				'type' => 'true_false',
				'instructions' => 'Hide the title on this page / post.',
				'message' => '',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

function genesis_remove_action_title_toggle() {
    remove_action( 'genesis_post_title',   'genesis_do_post_title' );
    remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
}

function title_toggle() {
  if(function_exists( 'get_field' )){
    if(get_field('hide_title')) {
        add_action('genesis_before', 'genesis_remove_action_title_toggle');
    }
  }
}

function genesis_get_header_acf_hide_title() {
        title_toggle();
}
add_action('get_header','genesis_get_header_acf_hide_title');
