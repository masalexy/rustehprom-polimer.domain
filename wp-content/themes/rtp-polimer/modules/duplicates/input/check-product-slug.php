<?php
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
if( isset($_POST['product_slug']) ){
    global $wpdb;
    $slug = $_POST['product_slug'];

    $product_query = $wpdb->query("SELECT * FROM {$wpdb->prefix}posts WHERE post_name = '{$slug}' and post_type = 'product' and post_status = 'publish' ");
    $duplicate_query = $wpdb->query("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'duplicate_pages_%_duplicate_page_slug' and meta_value = '{$slug}'");

    if($product_query == 0 && $duplicate_query == 0){
        echo 'NO_MATCH';
    }else{
        echo 'DISABLED';
    }
}
