<?php defined( 'ABSPATH' ) || exit; ?>

<form class="cart__items woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

    <?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
    ?>

            <div class="cart-productshop_table shop_table_responsive cart woocommerce-cart-form__contents">
                <div class="cart-product__delete">
                    <?php
                        // @codingStandardsIgnoreLine
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                            __( 'Remove this item', 'woocommerce' ),
                            esc_attr( $product_id ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                    ?>
                </div>
                <div class="cart-product__image">
                    <?php
                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                    if ( ! $product_permalink ) {
                        echo $thumbnail; // PHPCS: XSS ok.
                    } else {
                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                    }
                    ?>
                </div>
                <div class="cart-product__desc row-left">
                    <span class="cart-product__title">
                    <?php
                    if ( ! $product_permalink ) {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                    } else {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                    }

                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                    // Meta data.
                    echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                    // Backorder notification.
                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                    }
                    ?>
                    </span>
                    <div class="cart-product__cols quantity">
                        <span class="cart-product__col cart-product__col_minus button-minus">-</span>

                        <input
                           type="text" step="1" min="1" max="" class="cart-product__col-field"
                           name="cart[<?php echo $cart_item_key; ?>][qty]" value="<?php echo $cart_item['quantity']; ?>"
                           title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"
                           onchange="jQuery('#update_cart').removeAttr('disabled').click()"
                        />

                        <span class="cart-product__col cart-product__col_plus button-plus">+</span>
                    </div>
                    <span class="cart-product__regular">
                        <?php
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                        ?>
                    </span>
                </div>
            </div>

    <?php endif; endforeach; ?>

    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    <button type="submit" class="button" name="update_cart" id="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" style="display: none;"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

</form>

<div class="cart__buttons">
    <a href="<?php echo home_url('/kupit/'); ?>" class="cart__btn ui-btn-dark">Продолжить покупки</a>
    <a href="<?php echo home_url('/checkout/'); ?>" class="cart__btn ui-btn-yellow">Оформить</a>
</div>
