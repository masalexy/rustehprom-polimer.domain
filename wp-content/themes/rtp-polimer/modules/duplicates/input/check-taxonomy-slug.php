<?php
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
if( isset($_POST['tax_data']) ){
    global $wpdb;
    $slug = $_POST['tax_data']['slug'];
    $taxonomy = $_POST['tax_data']['type'];

    $taxonomy_query = $wpdb->query("SELECT * FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_taxonomy.term_id WHERE {$wpdb->prefix}terms.slug = '{$slug}' and {$wpdb->prefix}term_taxonomy.taxonomy = '{$taxonomy}' ");
    $duplicate_query = $wpdb->query("SELECT * FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_taxonomy.term_id INNER JOIN {$wpdb->prefix}termmeta ON {$wpdb->prefix}terms.term_id = {$wpdb->prefix}termmeta.term_id WHERE {$wpdb->prefix}termmeta.meta_key LIKE 'duplicate_pages_%_duplicate_page_slug' and {$wpdb->prefix}termmeta.meta_value = '{$slug}' and {$wpdb->prefix}term_taxonomy.taxonomy = '{$taxonomy}'");

    if($taxonomy_query == 0 && $duplicate_query == 0){
        echo 'NO_MATCH';
    }else{
        echo 'DISABLED';
    }
}
