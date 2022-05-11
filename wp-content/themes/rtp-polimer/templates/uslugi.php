<?php /* Template Name: Услуги */ ?>

<?php get_header(); ?>

<div class="container container_content">
    <div class="content wrapper">
        <?php if ( have_posts() ) : ?>
            <?php  while ( have_posts() ) : the_post(); ?>
                <h1 class="content__title content-title"><?php the_title(); ?></h1>



                <?php
                    $child_pages = get_posts([
                        'post_type'      => 'page',
                        'posts_per_page' => -1,
                        'post_parent'    => get_the_ID(),
                        'order'          => 'ASC'
                    ]);
                ?>

                <div class="woocommerce columns-4">
                    <div class="products-catalog">
                    <?php foreach($child_pages as $page): ?>
                                <li class="product-category product">
                                	<a href="<?php echo get_permalink($page->ID); ?>">
                                        <?php echo get_the_post_thumbnail($page->ID, [300,300]); ?>
                                        <h2 class="woocommerce-loop-category__title"><?php echo get_the_title($page->ID); ?></h2>
                                	</a>
                                </li>
                    <?php endforeach; ?>
                    </div>
                </div>




            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
