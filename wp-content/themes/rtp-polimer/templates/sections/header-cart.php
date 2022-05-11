<?php
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $count = $woocommerce->cart->get_cart_contents_count();
    if($count == 0){
        $label = 'Корзина пуста';
    }elseif($count == 1){
        $label = '1 товар';
    }elseif($count > 1 && $count < 5){
        $label = $count . ' товара';
    }else{
        $label = $count . ' товаров';
    }
?>
<div class="header__cart">
    <img src="/wp-content/themes/rtp-polimer/assets/images/shopping-cart.png" class="header__cart-ico">
    <span class="header__cart-title">Корзина</span>
    <span class="header__cart-col"><?php echo $count; ?></span>
    <div class="cart-popup">
        <div class="cart-popup__cols"><?php echo $label; ?></div>
        <div class="cart-popup__products">
            <?php foreach($items as $item => $values): $_product =  wc_get_product( $values['data']->get_id()); ?>
                <a class="popup-product" href="<?php echo $_product->get_permalink(); ?>">
                    <div class="popup-product__desc">
                        <span class="popup-product__title">
                            <?php echo $_product->get_name(); ?> - <b>x<?php echo $values['quantity']; ?></b>
                        </span>
                    </div>
                    <div class="popup-product__thumb">
                        <?php echo $_product->get_image('thumbnail'); ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if($count > 0): ?>
            <div class="cart-popup__link">
                <a href="<?php echo home_url('/cart/'); ?>" class="cart-popup__btn ui-btn-yellow">Подробнее</a>
            </div>
        <?php endif; ?>
    </div>
</div>
