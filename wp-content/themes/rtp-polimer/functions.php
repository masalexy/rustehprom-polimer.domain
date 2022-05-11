<?php
add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form'
    ));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'blankslate')
    ));
});


add_action('phpmailer_init', function($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.beget.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Username   = 'send@quadracon.ru';
    $phpmailer->Password   = '95GkEe&o*VhCN8zJ';
    $phpmailer->From       = 'send@quadracon.ru';
    $phpmailer->FromName   = 'Квадракон';
});


function init_modules(){
	$dir = opendir(__DIR__ . '/modules/'); $inc_file = '/index.php';
	while (false !== ($name = readdir($dir))) {
		$file =  __DIR__ . '/modules/'.$name.$inc_file;
		if ($name != "." && $name != ".." && file_exists($file) ) {
			include($file);
		}
	}
	closedir($dir);
}init_modules();

function get_section($name, $args = []){
	$file =  __DIR__ . '/templates/sections/'.$name.'.php';
	if ( file_exists($file ) ) {
		include($file);
	}
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('jquery');
});


add_action('widgets_init', function() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
});

add_filter('woocommerce_currency_symbol', function($currency_symbol, $currency){
     return 'Р';
}, 10, 2);

function product_primary_category($product, $echo = true){
    if ( class_exists('WPSEO_Primary_Term') ) {
        $wpseo_primary_term = new WPSEO_Primary_Term('product_cat', $product->get_id());
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
        $term = get_term( $wpseo_primary_term );
        if (is_wp_error($term)) {
            $categories = get_the_terms($product->get_id(), 'product_cat');
            $cat_name = $categories[0]->name;
        } else {
            $cat_name = $term->name;
        }
    } else {
        $categories = get_the_terms($product->get_id(), 'product_cat');
        $cat_name = $categories[0]->name;
    }
    if($echo === false) return $cat_name;
    else echo $cat_name;
}

add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');
add_filter('woocommerce_billing_fields', function($fields = []) {
	unset($fields['billing_company']);
	unset($fields['billing_last_name']);
	unset($fields['billing_address_2']);
	unset($fields['billing_state']);
	unset($fields['billing_city']);
	unset($fields['billing_postcode']);
	$fields['billing_email']['required'] = false;

    $fields['billing_first_name']['placeholder'] = 'Имя';
    $fields['billing_phone']['placeholder'] = 'Телефон';
    $fields['billing_email']['placeholder'] = 'Email';

	return $fields;
});
add_filter( 'woocommerce_checkout_fields' , function($fields){
     unset($fields['order']['order_comments']);
     return $fields;
});
add_filter('woocommerce_default_address_fields', function($address_fields){
    $address_fields['address_1']['placeholder'] = 'Адрес';
    return $address_fields;
}, 20, 1);

add_filter( 'default_checkout_billing_country', function(){
	return 'RU';
});

add_filter( 'the_content', function ($content) {
	global $post;

	if ($post->post_parent == 1798) {
        $service_args = json_encode([
            'serviceTitle' => $post->post_title,
            'serviceLink' => get_permalink($post->ID)
        ]);

		$button = "<div><a class='service-order-btn ui-btn-yellow' onclick='wpjshooks.set_form_values(`order-service`, {$service_args})'>Заказать услугу</a></div>";
		$content = $content . $button;
	}

	return $content;
});


add_filter( 'loop_shop_per_page', function($cols) {
  $cols = 18;
  return $cols;
}, 20 );




add_filter('woocommerce_taxonomy_args_product_cat', function($args){
    $args['rewrite']['hierarchical'] = false;
    return $args;
});


if( function_exists('acf_add_options_sub_page') ) {


    acf_add_options_sub_page([
    	'page_title' 	=> 'Feed XML Manager',
    	'menu_title' 	=> 'Feed XML Manager',
    	'parent_slug' 	=> 'edit.php?post_type=product',
    	'menu_slug' 	=> 'product_feed_platform',
    ]);

    add_action('admin_menu', function () {
        global $submenu;
        $submenu['edit.php?post_type=product'][] = [
            'Feed Product Manager',
            'manage_options',
            'https://rustehprom-polimer.ru/editxmlfeed/'
        ];
    });

}
