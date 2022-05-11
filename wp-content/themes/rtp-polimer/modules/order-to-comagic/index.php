<?php
add_action( 'woocommerce_thankyou', function( $order_id ) {
    $order = new WC_Order( $order_id );
    $goods = '';
    $new_order = false;

    if(isset($_COOKIE['last_wc_order'])){
        if($_COOKIE['last_wc_order'] != $order->get_order_number()){
            $new_order = true;
        }
    }else{
        $new_order = true;
    }

    if( $new_order ){
        $id = $order->get_order_number();
    	$name = $order->get_billing_first_name();
    	$phone = $order->get_billing_phone();
    	$items = $order->get_items();
    	$total = $order->get_total();
    	$shipping_method = @array_shift($order->get_shipping_methods());
    	foreach($items as $item){
    		$goods .= "{$item->get_name()} x {$item['qty']}шт -> {$item['subtotal']}руб, ";
    	}
    	$message = "Заказ[{$id}]. Имя: {$name}, Телефон: {$phone}. Товары: {$goods}. Всего: {$total}руб. Способ доставки: {$shipping_method['method_title']}.";

        setcookie('last_wc_order', $id, time() + (86400 * 365), "/");
        file_put_contents(__DIR__ . "/orders.log", $message . PHP_EOL, FILE_APPEND);

        add_action('wp_footer', function() use($name, $phone, $message){
            echo "
                <script>
                jQuery(window).on('load',function(){
                    Comagic.addOfflineRequest({
                        name: '{$name}',
                        phone: '{$phone}',
                        message: '{$message}'
                    });
                });
                </script>
            ";
        });
    }
},  1, 1  );
