<?php
ini_set('memory_limit', '-1');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/xml; charset=utf-8");
header('Content-type: application/xml');
header('HTTP/1.1 200 OK');

global $wpdb, $region_obj, $feed_args;
$region_id = ($region_obj->url == '') ? '' : $region_obj->id;
$meta_prefix = ($region_id != '') ? $region_id : '';

$email = do_shortcode('[multiregion param="email" html="false"]');
$shop_name = get_option("shop-name_{$region_id}_{$feed_args['feed-id']}");

$products = [];
$ids = get_feed_products($feed_args['feed-id'], $region_id);
if($ids){
    $products = wc_get_products(['limit' => -1, 'status' => 'publish', 'include' => $ids ]);
}
echo "<?xml version=\"1.0\"?>\n";
?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title><?php echo $shop_name; ?></title>
        <link><?php echo home_url(); ?></link>
        <description>Кассовые аппараты и торговое оборудование для любых видов бизнеса</description>
        <?php foreach($products as $product): ?>
        <?php
            $category = ($product->get_category_ids()) ? get_term($product->get_category_ids()[0], 'product_cat') : '';
            $regular_price = get_post_meta($product->get_id(), $meta_prefix.'_regular_price', true);
            $stock_status = get_post_meta($product->get_id(), $meta_prefix.'_region_stock_status', true);
            $utm = str_replace('%product_name%', urlencode($product->get_name()), $feed_args['feed-utm']);
            $utm = htmlspecialchars($utm);

            $post_obj = new stdClass();
            $post_obj->ID = $product->get_id();
            $post_obj->post_title = $product->get_name();
            $description = yoast_custom_vars($product->get_description(), $post_obj);
            $description = do_shortcode($description);
        ?>
            <item>
                <g:id><?php echo $product->get_id(); ?></g:id>
                <g:title><?php echo $product->get_name(); ?></g:title>
                <g:description><![CDATA[ <?php echo $description; ?> ]]></g:description>
                <g:link><?php echo $product->get_permalink(); ?><?php echo $utm; ?></g:link>
                <g:image_link><?php echo get_the_post_thumbnail_url($product->get_id(), 'full'); ?></g:image_link>
                <g:condition>new</g:condition>
                <g:availability><?php echo ($stock_status != 'instock') ? 'preorder' : 'in stock'; ?></g:availability>
                <g:price><?php echo $regular_price; ?> RUB</g:price>
                <g:brand><?php echo strip_tags(wc_get_product_tag_list($product->get_id())); ?></g:brand>
                <g:mpn></g:mpn>
                <g:gtin></g:gtin>
                <g:identifier_exists>no</g:identifier_exists>
                <g:google_product_category><?php echo $category->name; ?></g:google_product_category>
                <g:product_type><?php echo $category->name; ?></g:product_type>
            </item>
        <?php endforeach; ?>

    </channel>
</rss>
