<?php /* Template Name: Главная */ ?>
<?php get_header(); ?>




<!-- CATALOG PLATES -->
<div class="container container_cat-plates">
    <div class="cat-plates">
        <a href="<?php echo home_url('/kupit/category/strejch-plenka/'); ?>" class="cat-plate cat-plate_1">
            <span class="cat-plate__title">Стрейч пленка</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-1.png" alt="Стрейч пленка" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/kupit/category/skotch/'); ?>" class="cat-plate cat-plate_2">
            <span class="cat-plate__title">Скотч</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-2.png" alt="Скотч" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/uslugi/remont-shnekov-ekstrudera/'); ?>" class="cat-plate cat-plate_3">
            <span class="cat-plate__title">Ремонт экструдера</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-3.png" alt="Ремонт экструдера" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/zakupki/'); ?>" class="cat-plate cat-plate_4">
            <span class="cat-plate__title">Прием второсырья</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-4.png" alt="Прием второсырья" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/oborudovanie/'); ?>" class="cat-plate cat-plate_5">
            <span class="cat-plate__title">Оборудование</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-5.png" alt="Оборудование" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/kupit/category/drobilki/'); ?>" class="cat-plate cat-plate_6">
            <span class="cat-plate__title">Дробилки</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-6.png" alt="Дробилки" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/zakupki/priem-plenki/'); ?>" class="cat-plate cat-plate_7">
            <span class="cat-plate__title">Прием стрейч пленки</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-7.png" alt="Прием стрейч пленки" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/kupit/plenka-polietilenovaya-termousadochnaya/'); ?>" class="cat-plate cat-plate_8">
            <span class="cat-plate__title">Термоусадочная пленка</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-8.png" alt="Термоусадочная пленка" class="cat-plate__image">
        </a>
        <a href="<?php echo home_url('/zakupki/priem-othodov-pnd/'); ?>" class="cat-plate cat-plate_9">
            <span class="cat-plate__title">Прием пленки ПВД, ПНД</span>
            <img src="/wp-content/themes/rtp-polimer/assets/images/brick-9.png" alt="Прием пленки ПВД, ПНД" class="cat-plate__image">
        </a>
    </div>
</div>
<!-- / CATALOG PLATES -->

<!-- HEADER SLIDER -->
<div class="container container_main-slider">
    <div class="main-slider wrapper">
        <div class="main-slide row">
            <div class="main-slide__desc">
                <span class="main-slide__title"><b>Покупаем</b><br>отходы пвд и стрейч!</span>
                <a href="<?php echo home_url('/zakupki/'); ?>" class="main-slide__link ui-btn-yellow">Подробнее</a>
            </div>
            <div class="main-slide__image">
                <img src="/wp-content/themes/rtp-polimer/assets/images/slide-1.png" alt="Покупаем отходы пвд и стрейч">
            </div>
        </div>
    </div>
</div>
<!-- / HEADER SLIDER -->


<!-- PRODUCTS -->
    <div class="container container_index-products">
        <div class="index-products wrapper">
            <h2 class="index-products__title content-title">Оборудование</h2>
            <?php
                $oborudovanie_categories = [
                    'aglomeratory',
                    'granulyatory',
                    'drobilki',
                    'konvejery',
                    'moechnye-kompleksy'
                ];
                $oborudovanie_products = wc_get_products([
                    'category' => $oborudovanie_categories,
                    'limit' => 4
                ]);
                woocommerce_product_loop_start();
            	foreach($oborudovanie_products as $product) {
            		do_action('woocommerce_shop_loop');
            		wc_get_template_part('content', 'product');
            	}
            	woocommerce_product_loop_end();
            ?>
        </div>

        <div class="index-products wrapper">
            <h2 class="index-products__title content-title">Скотч</h2>
            <?php
                $skotch_categories = ['skotch'];
                $skotch_products = wc_get_products([
                    'category' => $skotch_categories,
                    'limit' => 4
                ]);
                woocommerce_product_loop_start();
            	foreach($skotch_products as $product) {
            		do_action('woocommerce_shop_loop');
            		wc_get_template_part('content', 'product');
            	}
            	woocommerce_product_loop_end();
            ?>
        </div>
        <div class="index-products wrapper">
            <h2 class="index-products__title content-title">Стрейч-пленка</h2>
            <?php
                $strejch_plenka_categories = ['strejch-plenka'];
                $strejch_plenka_products = wc_get_products([
                    'category' => $strejch_plenka_categories,
                    'limit' => 4
                ]);
                woocommerce_product_loop_start();
            	foreach($strejch_plenka_products as $product) {
            		do_action('woocommerce_shop_loop');
            		wc_get_template_part('content', 'product');
            	}
            	woocommerce_product_loop_end();
            ?>
<style>
.catalog_links li:before {
    content: "#";
    float: left;
    position: relative;
    top: 3px;
    left: 2px;
    z-index: 1;
    font-size: 14px;
}
.catalog_links a {
    display: inline-block;
    padding: 2px 2px;
    font-size: 14px;
}</p>
</style>
<div class="catalog_links">
<ul>
<li>
<a href="https://rustehprom-polimer.ru/kupit/plenka-polietilenovaya-vysokogo-davleniya-pvd/">производство пленки пвд</a>
</li>
</ul>
</div>
        </div>
    </div>
<!-- / PRODUCTCS -->

<?php get_footer(); ?>
