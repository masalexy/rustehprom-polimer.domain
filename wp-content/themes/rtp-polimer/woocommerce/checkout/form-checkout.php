<form name="checkout" method="post" class="cart-order__form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <div class="checkout-fields">
        <?php do_action( 'woocommerce_checkout_billing' ); ?>
    </div>

    <div class="shipping_and_payment">
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
    </div>

    <button class="cart-order__btn ui-btn-yellow">Оформить заказ</button>
</form>
