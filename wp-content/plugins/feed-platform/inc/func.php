<?php
function get_feed_by_slug($slug, $feeds){
    $feedItem = array_filter($feeds, function($item) use($slug){
        return $item['feed-slug'] == $slug;
    });
    $feedItem = array_values($feedItem);
    return ! empty($feedItem) ? $feedItem[0] : false;
}

function get_feed_template($slug){
    return __DIR__ . "/../templates/{$slug}.php";
}

function get_editor_template(){
    return __DIR__ . "/../editor/editor.php";
}

function get_feed_products($feed_id, $gorod){
    global $wpdb;
    $ids = $wpdb->get_col("SELECT post_id FROM {$wpdb->prefix}feed_platform WHERE feed_id = '{$feed_id}' AND gorod = '{$gorod}' ");
    return !empty($ids) ? $ids : false;
}
