<?php
add_action('woocommerce_add_to_cart', function($key){
	add_action( 'wp_footer', function() use($key){
		global $woocommerce;
		$cart_items = WC()->cart->get_cart();
		$cartItem = $cart_items[$key];
		$_product = apply_filters( 'woocommerce_cart_item_product', $cartItem['data'], $cartItem, $cartItem['key'] );
        $qty = $cartItem['quantity'];

        $template = file_get_contents(__DIR__ . '/template.html');
        $template = str_replace(
            [
				'{{image}}',
				'{{name}}',
				'{{price}}',
				'{{shop-url}}',
				'{{cart-url}}'
			],
            [
				$_product->get_image(),
				$_product->get_name(),
				$_product->get_price_html(),
				get_permalink(wc_get_page_id('shop')),
				get_permalink(wc_get_page_id('cart'))
			],
            $template
        );
        echo $template;
    });
});
