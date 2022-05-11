<?php get_header(); ?>

<?php
    $term = get_queried_object();
    global $wp_query, $duplicateSettings;
    $archive_title = ( !empty($duplicateSettings) ) ? $duplicateSettings['title'] : woocommerce_page_title(false);
    $catalog_links = (!is_shop()) ? get_field('catalog_links', $term) : get_field('catalog_links', get_option('woocommerce_shop_page_id'));
?>


<!-- MAIN-CATALOG -->
    <div class="container container_main-catalog">
        <div class="main-catalog wrapper">
            <h1 class="main-catalog__title content-title"><?php echo $archive_title; ?></h1>

            <span class="content-subtitle">
                <?php
                    if( !empty($duplicateSettings) ){
                        echo $duplicateSettings['short_desc'];
                    }else{
                        if(is_shop()) the_field('taxonomy_short_description', get_option( 'woocommerce_shop_page_id'));
                        else the_field('taxonomy_short_description', $term);
                    }
                 ?>
            </span>
            <!-- ФИЛЬТРЫ-СОРТИРОВКА -->
            <div class="catalog-filters row">
                <!-- сортировка -->
                <div class="catalog-filters__sort">
                    <label for="catalog-sort">Сортировать по: </label>
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
                <div class="catalog-filters__view">
                    Вид
                    <button class="catalog-filters__view-plate active_catalog_view"><i class="fas fa-th"></i></button>
                    <button class="catalog-filters__view-list"><i class="fas fa-th-list"></i></button>
                </div>
            </div>
            <div class="catalog-sidebar">
                <?php dynamic_sidebar('primary-widget-area'); ?>
            </div>
            <!-- // ФИЛЬТРЫ-СОРТИРОВКА -->
            <?php
            if ( woocommerce_product_loop() ) {
            	woocommerce_product_loop_start();
            	if ( wc_get_loop_prop( 'total' ) ) {
            		while ( have_posts() ) {
            			the_post();
            			do_action( 'woocommerce_shop_loop' );
            			wc_get_template_part( 'content', 'product' );
            		}
            	}
            	woocommerce_product_loop_end();
            	do_action( 'woocommerce_after_shop_loop' );
            } else {
            	do_action( 'woocommerce_no_products_found' );
            }
            ?>


            <?php
                if( is_shop() ){
                    $shop_page = get_post(get_option('woocommerce_shop_page_id'));
                    echo apply_filters('the_content', $shop_page->post_content);
                }else{
                    echo term_description($term->term_id, $term->taxonomy);
                }
            ?>




            <?php if( $catalog_links ) : ?>
            <div class="catalog_links">
                <ul>
                <?php foreach($catalog_links as $item): ?>
                    <li>
                        <a href="<?php echo home_url($item['cl_url']); ?>"><?php echo $item['cl_name']; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

        </div>
    </div>
<!-- // MAIN-CATALOG -->




<?php get_footer(); ?>
