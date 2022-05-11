<?php
    defined( 'ABSPATH' ) || exit;
    global $product;

    $oneclick_args = [
        'productTitle' => $product->get_name(),
        'productPrice' => $product->get_price() . ' Р',
        'productLink' => $product->get_permalink()
    ];
    $oneclick_args = json_encode($oneclick_args);

    $unit = get_field('measurement');
    $unit = ($unit != '') ? "/ {$unit}" : "";
?>

<div class="product">

    <?php if( $product->get_stock_status() == 'instock' ): ?>
        <span class="product__alert product__alert_green">В наличии</span>
    <?php elseif( $product->get_stock_status() == 'onbackorder' ): ?>
        <span class="product__alert product__alert_yellow">Под заказ</span>
    <?php else: ?>
        <span class="product__alert product__alert_red">Нет в наличии</span>
    <?php endif; ?>

    <a href="<?php echo $product->get_permalink(); ?>" class="product__thumb">
        <?php echo $product->get_image('thumbnail', ['alt' => $product->get_name()]); ?>
    </a>
    <div class="product__desc">
        <span class="product__cat"><?php product_primary_category($product); ?></span>
        <span class="product__title"><a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a></span>
        <span class="product__price"><?php echo $product->get_price_html(); ?> <?php echo $unit; ?></span>
        <p class="product__short-desc"><?php echo $product->get_short_description(); ?></p>
    </div>
    <div class="product__links">
        <a href="#" class="product__one-click ui-btn-dark" onclick='wpjshooks.set_form_values("buy-one-click", <?php echo $oneclick_args; ?>)'>Купить в 1 клик</a>
        <a href="<?php echo $product->get_permalink(); ?>" class="product__read-more ui-btn-yellow" rel="nofollow">Подробнее</a>
        <div class="product__options">
            <button class="comapare_add product__btn product__btn_simile <?php echo ( in_array($product->get_id(), wccm_get_compare_list()) ) ? 'added' : ''; ?>" data-id="<?php echo $product->get_id(); ?>"><i class="fas fa-exchange-alt"></i></button>
            <button class="wishlist_add product__btn product__btn_favorite <?php echo ( in_array($product->get_id(), wccm_get_wish_list()) ) ? 'added' : ''; ?>" data-id="<?php echo $product->get_id(); ?>"><i class="far fa-heart"></i></button>
        </div>
    </div>
</div>
