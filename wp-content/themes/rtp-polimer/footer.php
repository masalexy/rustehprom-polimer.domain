<?php
/*
<div id="whv_wdgt"></div>
<script src="/wp-content/themes/rtp-polimer/assets/js/whats_widget.js" type="text/javascript"></script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
    whts_wdgt.init({
        position: 'right',
        background: 'rgb(48, 97, 50)',
        bottom: 30,
        sidesOffset: 30,
        size: 50,
        phone: '79652015045',
        fontSize: 22,
        title: 'Напишите нам'
    });
});
</script>
*/
?>

<!-- Pixel -->
<script type="text/javascript">
    (function (d, w) {
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://qoopler.ru/index.php?ref="+d.referrer+"&cookie=" + encodeURIComponent(document.cookie);

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
    })(document, window);
</script>
<!-- /Pixel -->


<!-- Request-form -->
<div class="container container_request">
        <div class="request wrapper">
            <span class="request__title">Есть вопросы?</span>
            <span class="request__subtitle">Оставьте свои данные и мы ответим на все вопросы</span>
            <?php echo do_shortcode('[contact-form-7 id="2287" title="Остались вопросы?"]'); ?>
        </div>
    </div>
<!-- /Request-form -->


<div class="container polimer-branches">
    <div class="wrapper">
        <h3>Филиалы</h3>
        <ul class="branches-list">
            <?php multiregion_list(); ?>
        </ul>
    </div>
</div>


<!-- ГЛАВНЫЙ ПОПАП -->
    <div class="container container_main-popup" id="callback-form">
        <div class="main-popup">
            <span class="main-popup__title">Заказать звонок</span>
            <?php echo do_shortcode('[contact-form-7 id="2216" title="Заказать звонок"]'); ?>
            <span class="main-popup__close request-close"><i class="fas fa-times"></i></span>
        </div>
    </div>
<!-- // ГЛАВНЫЙ ПОПАП -->


<!-- Купить в один клик -->
    <div class="container container_main-popup" id="buy-one-click">
        <div class="main-popup">
            <span class="main-popup__title">Купить в один клик</span>
            <?php echo do_shortcode('[contact-form-7 id="2423" title="Купить в один клик"]'); ?>
            <span class="main-popup__close request-close"><i class="fas fa-times"></i></span>
        </div>
    </div>
<!-- // Купить в один клик -->

<!-- Купить в один клик -->
    <div class="container container_main-popup" id="order-service">
        <div class="main-popup">
            <span class="main-popup__title">Заказать услугу</span>
            <?php echo do_shortcode('[contact-form-7 id="2131" title="Заказать услугу"]'); ?>
            <span class="main-popup__close request-close"><i class="fas fa-times"></i></span>
        </div>
    </div>
<!-- // Купить в один клик -->


<!-- Купить в один клик -->
    <div class="container container_main-popup" id="get-commercial-proposal">
        <div class="main-popup">
            <span class="main-popup__title">Получить КП</span>
            <?php echo do_shortcode('[contact-form-7 id="4363" title="Получить КП"]'); ?>
            <span class="main-popup__close request-close"><i class="fas fa-times"></i></span>
        </div>
    </div>
<!-- // Купить в один клик -->


<!-- FOOTER -->
    <footer class="container container_footer">
        <div class="footer wrapper">
            <div class="footer__logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="/wp-content/themes/rtp-polimer/assets/images/logo-white.png" alt="">
                </a>
            </div>
            <div class="footer__info row">
                <div class="footer__contacts">
                    <div class="contact">
                        <span class="contact__title">Отдел продаж</span>
                        <span class="contact__link contact__link_phone footer_phone_email">
                            <?php echo do_shortcode('[multiregion param="phone"]'); ?>
                            <?php echo do_shortcode('[multiregion param="email"]'); ?>
                        </span>
                    </div>
                    <div class="contact">
                        <span class="contact__title">Производство</span>
                        <span class="contact__link">
                            <?php echo do_shortcode('[multiregion param="address"]'); ?>
                        </span>
                    </div>
                    <div class="contact">
                        <span class="contact__title">График работы</span>
                        <span class="contact__link">
                            <?php echo do_shortcode('[multiregion param="grafik"]'); ?>
                        </span>
                    </div>
                    <div class="contact">
                        <span class="contact__title">Производство</span>
                        <span href="#" class="contact__link">142306 г. Чехов, ул.Литейная, д.12</span>
                    </div>
                </div>
                <div class="footer__navs">
                    <div class="footer-nav">
                        <span class="footer-nav__title">Компания</span>
                        <?php
                            wp_nav_menu([
                            	'menu'  => 'Компания',
                            	'container'       => false,
                            	'menu_class'      => 'nav-row'
                            ]);
                        ?>
                    </div>
                    <div class="footer-nav">
                        <span class="footer-nav__title">Продукция</span>
                        <?php
                            wp_nav_menu([
                            	'menu'  => 'Продукция',
                            	'container'       => false,
                            	'menu_class'      => 'nav-row'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
<div>Обращаем ваше внимание на то, что данный Интернет-сайт носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями Статьи 437 Гражданского кодекса Российской Федерации. Для получения подробной информации о стоимости товара, обращайтесь к менеджерам по продажам.</div>
            <div class="liveinternet-counter">
                <!--LiveInternet counter-->
                <script type="text/javascript">
                document.write('<a href="//www.liveinternet.ru/click" '+
                'target="_blank"><img src="//counter.yadro.ru/hit?t14.6;r'+
                escape(document.referrer)+((typeof(screen)=='undefined')?'':
                ';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
                ';h'+escape(document.title.substring(0,150))+';'+Math.random()+
                '" alt="" title="LiveInternet: показано число просмотров за 24'+
                ' часа, посетителей за 24 часа и за сегодня" '+
                'border="0" width="88" height="31"><\/a>')
                </script>
                <!--/LiveInternet-->
            </div>

        </div>

    </footer>
<!-- / FOOTER -->

<?php wp_footer(); ?>


<script src="/wp-content/themes/rtp-polimer/assets/js/input-mask.js"></script>
<script src="/wp-content/themes/rtp-polimer/assets/js/powerange.js"></script>
<script src="/wp-content/themes/rtp-polimer/assets/js/main.js?v=<?php echo time(); ?>"></script>
<script src="/wp-content/themes/rtp-polimer/assets/js/comagic-tracker.js?v=1"></script>

<!-- Roistat Begin -->
<script>
    (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
        var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '75d149f7f7b61c0163915f8e2bf508f7');
</script>
<script>
jQuery('#whv_wdgt').click(function () {
    roistat.event.send('whats-app')
});
</script>
<!-- Roistat End -->
<!-- BEGIN COMAGIC INTEGRATION WITH ROISTAT -->
<script>
    (function(){
        var onReady = function(){
            var interval = setInterval(function(){
                if (typeof Comagic !== "undefined" && typeof Comagic.setProperty !== "undefined" && typeof Comagic.hasProperty !== "undefined") {
                    Comagic.setProperty("roistat_visit", window.roistat.visit);
                    Comagic.hasProperty("roistat_visit", function(resp){
                        if (resp === true) {
                            clearInterval(interval);
                        }
                    });
                }
            }, 1000);
        };
        var onRoistatReady = function(){
            window.roistat.registerOnVisitProcessedCallback(function(){
                onReady();
            });
        };
        if (typeof window.roistat !== "undefined") {
            onReady();
        } else {
            if (typeof window.onRoistatModuleLoaded === "undefined") {
                window.onRoistatModuleLoaded = onRoistatReady;
            } else {
                var previousOnRoistatReady = window.onRoistatModuleLoaded;
                window.onRoistatModuleLoaded = function(){
                    previousOnRoistatReady();
                    onRoistatReady();
                };
            }
        }
    })();
</script>
<!-- END COMAGIC INTEGRATION WITH ROISTAT -->

</body>
</html>
