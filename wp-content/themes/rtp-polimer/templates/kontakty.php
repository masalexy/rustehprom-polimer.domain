<?php /* Template Name: Контакты */ ?>
<?php get_header(); ?>


<!-- Контакты -->
<div class="container container_contacts">
    <div class="contacts wrapper row-stretch">
        <h1 class="contacts__title content-title">Контакты</h1>
        <div class="contacts__district">
            <div class="contacts__map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A9fb8209d7f7a0c0702be1be83db77edc194a7c9a82cbc18712785f998d96b4fb&amp;width=555&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
            <div class="contacts__desc">
                <span class="contacts__title">Производство</span>
                <span class="contacts__adress">
                    <?php echo do_shortcode('[multiregion param="address"]'); ?>
                </span>
            </div>
        </div>
        <div class="contacts__district">
            <div class="contacts__map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A97f3c182acb4bdf1bdaa6b238bbdcb3389ebee3b5106865992ad264c4ae2aeb2&amp;width=555&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
            <div class="contacts__desc">
                <span class="contacts__title">Производство</span>
                <span class="contacts__adress">142306, г.Чехов, ул.Литейная, д.12</span>
                <span href="#" class="contacts__link">9:00 - 19:00 без выходных</span>
            </div>
        </div>

        <div class="contacts__district">
            <div class="contacts__desc">
                <span class="contacts__title">Юридический адрес</span>
                <span class="contacts__adress">109472, вн. тер. г. Муниципальный округ Выхино-Жулебино,
                ул. Ташкентская, д. 28, стр. 1, помещ. XIV, комн. 32</span>
                <span class="contacts__link" style="display: block;">
                    <?php echo do_shortcode('[multiregion param="email"]'); ?>
                </span>
                <span class="contacts__link">
                    <?php echo do_shortcode('[multiregion param="phone"]'); ?>
                </span>
            </div>
        </div>

        <div class="contacts__requisites">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<!-- // Контакты -->



<?php get_footer(); ?>
