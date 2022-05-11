<?php
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');

if( isset($_POST['wc_compare_add_product']) ){
    wccm_add_product_to_compare_list( $_POST['wc_compare_add_product'] );
    echo 'SUCCESS';
}


if( isset($_POST['wc_wishlist_add_product']) ){
    wccm_add_product_to_wish_list( $_POST['wc_wishlist_add_product'] );
    echo 'SUCCESS';
}
