<?php
/*
    Plugin Name: Feed platforms
    Description: XML feed managment plugin
    Author: Levon Manukyan
    Version: 1.0
*/

date_default_timezone_set("Europe/Moscow");

require_once 'inc/func.php';

add_filter( 'template_include', function ( $template ) {
    global $feed_args;
    $uri = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    $uri_params = array_values($uri);
    $feeds = get_field('feed-platforms', 'option');
    $feed_args = get_feed_by_slug($uri_params[1], $feeds);

    if( in_array('genxmlfeed', $uri) && !!$feed_args ){
        $template = get_feed_template($feed_args['feed-template']);
    }

    if( in_array('editxmlfeed', $uri)  ){
        $template = get_editor_template();
    }

	return $template;
});



if( function_exists('acf_add_local_field_group') ):

$max = get_option('options_feed-platforms') + 1;

acf_add_local_field_group(array(
	'key' => 'group_5f9140a6d1555',
	'title' => 'Фид',
	'fields' => array(
		array(
			'key' => 'field_5f9140d5edfdc',
			'label' => 'Фид',
			'name' => 'feed-platforms',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => $max,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5f980064faa3d',
					'label' => 'ID фида',
					'name' => 'feed-id',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'readonly' => 1,
                    'default_value' => md5(date("Ymdh:i:s"))
				),
				array(
					'key' => 'field_5f9140f7edfdd',
					'label' => 'Slug фида',
					'name' => 'feed-slug',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => ''
				),
				array(
					'key' => 'field_5f914143edfde',
					'label' => 'UTM метка',
					'name' => 'feed-utm',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5f914185edfdf',
					'label' => 'Шаблон',
					'name' => 'feed-template',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'yandex-market' => 'yandex-market',
						'google-merchant' => 'google-merchant',
                        'o-yandex' => 'o-yandex'
					),
					'default_value' => false,
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'product_feed_platform',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
