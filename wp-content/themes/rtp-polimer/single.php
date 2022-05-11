<?php get_header(); ?>

<div class="container container_content">
    <div class="content wrapper">
        <?php if ( have_posts() ) : ?>
            <?php  while ( have_posts() ) : the_post(); ?>
                <h1 class="content__title content-title"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
