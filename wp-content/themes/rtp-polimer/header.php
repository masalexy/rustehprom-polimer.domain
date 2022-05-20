<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="yandex-verification" content="dff7a4b2fcb956e3" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

		<?php if($_SERVER['HTTP_HOST'] != 'rustehprom-polimer.ru' && $_SERVER['REQUEST_URI'] != '/kontakty/'): ?>
			<meta name="robots" content="noindex" />
		<?php endif; ?>

    <?php if( is_single(4485) ): ?>
        <meta http-equiv="refresh" content="3;url=https://ya.cc/t/nrEs9QosEeYMG" />
    <?php endif; ?>
    <?php if( is_single(4487) ): ?>
        <meta http-equiv="refresh" content="2;url=https://goo.gl/maps/qNC69biVpiPJuNJV7" />
    <?php endif; ?>

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="/wp-content/themes/rtp-polimer/assets/css/powerange.min.css">
    <link rel="stylesheet" href="/wp-content/themes/rtp-polimer/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/wp-content/themes/rtp-polimer/assets/css/other.css?v=<?php echo time(); ?>">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59916398-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-59916398-1');
</script>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(28694586, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/28694586" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Global site tag (gtag.js) - Google Ads: 513511247 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-513511247"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-513511247');
    </script>

    <!-- Comagic -->
    <script type="text/javascript">
    var __cs = __cs || [];
    __cs.push(["setCsAccount", "MeeQnE5up4R0LFblvN_2_wxoPbWtDs1p"]);
    __cs.push(["setCsHost", "//server.comagic.ru/comagic"]);
    </script>
    <script type="text/javascript" async src="//app.comagic.ru/static/cs.min.js"></script>
    <!-- End Comagic -->



    <?php wp_head(); ?>
    <script>
    window.regionContacts = {
    	 address: "г. <?php echo do_shortcode('[multiregion param="name"]') . ', '. do_shortcode('[multiregion param="address"]'); ?>",
    	 phone: "<?php echo do_shortcode('[multiregion param="phone"]'); ?>",
    	 email: "<?php echo do_shortcode('[multiregion param="email"]'); ?>",
    	 production_address: 'г. Чехов, ул.Литейная, д.12',
    	 gorode: "<?php echo explode(';', do_shortcode('[multiregion param="name_ask"]'))[0]; ?>"
    }
    </script>
</head>
<body <?php body_class(); ?>>

<header class="header container">
    <?php /*
    <!--Баннер над шапкой-->
     <a href="https://www.digitalserv.ru/sredstva-individualnoj-zashhity/" class="medic-ref">
        <div class="medic-ref__desc">
            <img src="/wp-content/themes/rtp-polimer/assets/images/medic/antiseptik-header.jpg" alt="">
        </div>
        <div class="medic-ref__mobile">
            <img src="/wp-content/themes/rtp-polimer/assets/images/medic/antiseptik-header-mobile.jpg" alt="">
        </div>
        <style>
        .medic-ref { width: 100%; display: block; }
        .medic-ref img { width: 100%;}
        .medic-ref__mobile { display: none; }
        @media screen and (max-width: 720px) {
            .medic-ref__desc { display: none; }
            .medic-ref__mobile { display: block; }
        }
        </style>
    </a>
    <!-- / -->
    */ ?>

    <div class="header__top wrapper row">
        <a href="/" class="header__logo">
            <img src="/wp-content/themes/rtp-polimer/assets/images/rtpol-logo.jpg" alt="">
        </a>
        <a href="/" class="header__mobileLogo">
            <img src="/wp-content/themes/rtp-polimer/assets/images/logoIcon.png" alt="">
        </a>
        <div class="header__callback">
            <span class="header__phone"><?php echo do_shortcode('[multiregion param="phone"]'); ?></span>
            <span class="header__callback-btn request-btn" onclick="wpjshooks.popup('callback-form')"><i class="fas fa-phone-alt"></i>Обратный звонок</span>
        </div>
        <?php get_section('header-cart'); ?>
        <a href="<?php echo home_url('/cart/'); ?>" class="header__mobileCart">
            <img src="/wp-content/themes/rtp-polimer/assets/images/shopping-cart.png" alt="" class="header__cart-ico">
        </a>
        <div class="header__burger">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="header__nav">
        <div class="header__close"><i class="fas fa-times"></i></div>
        <nav class="header-nav wrapper">
            <?php
                wp_nav_menu([
                	'menu'  => 'Main Menu',
                	'container'       => false,
                	'container_class' => '',
                	'container_id'    => '',
                	'menu_class'      => 'header-main-menu',
                	'menu_id'         => ''
                ]);
            ?>
        </nav>
    </div>
</header>

<!-- BREADCRUMBS -->
<div class="container container_breadcrumbs">
    <div class="breadcrumbs wrapper">
        <?php woocommerce_breadcrumb(); ?>
    </div>
</div>
<!-- // BREADCRUMBS -->
