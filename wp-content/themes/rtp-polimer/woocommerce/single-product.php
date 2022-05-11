<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
?>

<?php
global $product; if ( ! is_object( $product)) $product = wc_get_product( get_the_ID() );
global $duplicateSettings;

if( !empty($duplicateSettings) ){
	$product->set_name($duplicateSettings['title']);

	if( $duplicateSettings['short_desc'] ){
		$product->set_short_description($duplicateSettings['short_desc']);
	}
	if( $duplicateSettings['desc'] ){
		$product->set_description($duplicateSettings['desc']);
	}
	if( $duplicateSettings['image'] ){
	    $product->set_image_id($duplicateSettings['image']);
	}
	if( $duplicateSettings['gallery'] ){
	    $product->set_gallery_image_ids( explode(',', $duplicateSettings["gallery"]) );
	}
}

$category_ids = $product->get_category_ids();
$imageUrl = wp_get_attachment_url($product->get_image_id());
$galleryIds = ($product->get_gallery_image_ids()) ? $product->get_gallery_image_ids() : [];
$product_alternatives = get_field('duplicate_pages');
$shortDescription = $product->get_short_description();

$unit = get_field('measurement');
$unit = ($unit != '') ? "/ {$unit}" : "";
?>


<!-- КАРТОЧКА ТОВАРА -->
    <div class="container container_product-cart">
        <div class="product-cart wrapper row-stretch">

            <!-- Левая часть карточки товара -->
            <div class="product-cart__galery">
                <div class="product-cart__image">
                    <?php
						$image_html = $product->get_image('full', ['class' => 'woo-single-attachment', 'source' => $imageUrl, 'alt' => $product->get_name()]);
						$image_html = preg_replace('/(<[^>]+) srcset=".*?"/i', '$1', $image_html);
						$image_html = preg_replace('/(<[^>]+) sizes=".*?"/i', '$1', $image_html);
						echo $image_html;
					?>

					<?php if( $product->get_stock_status() == 'instock' ): ?>
				        <span class="product__alert product__alert_green">В наличии</span>
				    <?php elseif( $product->get_stock_status() == 'onbackorder' ): ?>
				        <span class="product__alert product__alert_yellow">Под заказ</span>
				    <?php else: ?>
				        <span class="product__alert product__alert_red">Нет в наличии</span>
				    <?php endif; ?>

                </div>
				<?php if(!empty($galleryIds)): ?>
                <div class="product-cart__photos">
					<?php foreach($galleryIds as $id): ?>
	                    <div class="product-cart__photo">
	                        <img src="<?php echo wp_get_attachment_url($id); ?>" alt="">
	                    </div>
					<?php endforeach; ?>
                </div>
				<?php endif; ?>
            </div>
            <!-- // Левая часть карточки товара -->

            <!-- ПРАВАЯ ЧАСТЬ КАРТОЧКИ ТОВАРА -->
            <form class="product-cart__desc" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
                <h1 class="product-cart__title">
                    <?php echo $product->get_name(); ?>
                </h1>
				<div class="product-cart__icons">
	                <div class="product-cart__rating">
	                    <i class="fas fa-star"></i>
	                    <i class="fas fa-star"></i>
	                    <i class="fas fa-star"></i>
	                    <i class="fas fa-star"></i>
	                    <i class="fas fa-star"></i>
	                </div>
					<div class="wishlist_compare">
						<button class="comapare_add product__btn product__btn_simile <?php echo ( in_array($product->get_id(), wccm_get_compare_list()) ) ? 'added' : ''; ?>" data-id="<?php echo $product->get_id(); ?>"><i class="fas fa-exchange-alt"></i></button>
			            <button class="wishlist_add product__btn product__btn_favorite <?php echo ( in_array($product->get_id(), wccm_get_wish_list()) ) ? 'added' : ''; ?>" data-id="<?php echo $product->get_id(); ?>"><i class="far fa-heart"></i></button>
					</div>
				</div>

				<div class="shipping-info">
					<p>Отгружаем с документами</p>
					<p>Оплата нал/безнал</p>
					<p>Работаем без НДС (с НДС + 20%)</p>
				</div>

                <p class="product-cart__short-desc">
                    <?php echo $product->get_short_description(); ?>
                </p>
                <div class="product-cart__price-container row-left">
                    <div class="product-cart__cols">
						<span class="product-cart__col-btn product-cart__col-btn_minus button-minus">-</span>
                        <input type="text" name="quantity" class="product-cart__col-field" value="1">
						<span class="product-cart__col-btn product-cart__col-btn_plus button-plus">+</span>
                    </div>
                    <div class="product-cart__price">
                        <span class="product-cart__regular-price"><?php echo $product->get_price(); ?></span>
                        <span class="product-cart__currency">Р <?php echo $unit; ?></span>
                    </div>
                </div>
                <div class="product-cart__links">
					<?php
						$oneclick_args = [
							'productTitle' => $product->get_name(),
							'productPrice' => $product->get_price() . ' Р',
							'productLink' => $product->get_permalink()
						];
						$oneclick_args = json_encode($oneclick_args);
					?>

					<?php if( in_array($product->get_id(), [4293]) ): ?>
						<a class="product-cart__btn ui-btn-yellow get-cp" onclick='wpjshooks.set_form_values("get-commercial-proposal")'>Получить КП</a>
					<?php else: ?>
						<a class="product-cart__btn ui-btn-yellow" onclick='wpjshooks.set_form_values("buy-one-click", <?php echo $oneclick_args; ?>)'>Купить в один клик</a>
						<button class="product-cart__btn ui-btn-dark" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>">Положить в корзину</button>
					<?php endif; ?>
				</div>
            </form>
            <!-- // ПРАВАЯ ЧАСТЬ КАРТОЧКИ ТОВАРА -->



            <?php woocommerce_output_product_data_tabs(); ?>




            <!-- Нижняя часть карточки товара -->
            <div class="product-cart__other">

                <div class="product-cart__ident">
                    <h2 class="content-title ident-title">Похожие товары</h2>
					<?php
					woocommerce_related_products([
					    'posts_per_page' => 4,
					    'columns' => 4
					]);
					?>
                </div>
            </div>


			<div class="product-cart__other">

                <div class="product-cart__ident">
                    <h2 class="content-title ident-title">Вам может быть интересно</h2>
					<?php
					$buy_with_us_ids = get_field('buy_with_us_ids');
					if( !empty($buy_with_us_ids) ){
						$bw_ids = join(',', $buy_with_us_ids);
						$bw_count = count($buy_with_us_ids);
						echo do_shortcode("[products ids='{$bw_ids}' per_page='{$bw_count}']");
					}else{
						echo do_shortcode("[products limit='4' columns='4' best_selling='true' orderby='rand' ]");
					}
					?>
                </div>
            </div>


        </div>
    </div>
<!-- // КАРТОЧКА ТОВАРА -->




<?php get_footer(); ?>
