<?php
header("Content-Type: text/xml; charset=utf-8");
header('Content-type: application/xml');
header( 'HTTP/1.1 200 OK' );
global $region_obj;
$region_id = ($region_obj->url == '') ? '' : $region_obj->id;
echo '<?xml version="1.0"?>
    <rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"><channel>
    <title>МАГВЕЙ</title>
    <link>'.home_url().'</link>
    <description>Кассовые аппараты и торговое оборудование для любых видов бизнеса</description>
';

$products = wc_get_products(['limit' => -1, 'status' => 'publish']);
foreach($products as $product){
    $image = get_the_post_thumbnail_url($product->get_id());
    $description = product_dup_vars($product->get_description());
    $price = auto_price($product);
    $category_id = $product->get_category_ids()[0];
    if( class_exists('WPSEO_Primary_Term') ){
    	$wpseo_primary_term = new WPSEO_Primary_Term('product_cat', $product->get_id());
    	$category_id = $wpseo_primary_term->get_primary_term();
    }
    if ( !empty($product->get_tag_ids()) ) {
        $tag_id = $product->get_tag_ids()[0];
        $tag = get_term($tag_id, 'product_tag');
        $vendor = "<g:brand>{$tag->name}</g:brand>";
    }
    $category = get_term($category_id, 'product_cat');
    $stock_status = get_post_meta($product->get_id(), $region_id.'_region_stock_status', true);
    $inStore = ($stock_status != 'outofstock') ? 'in_stock' : 'out_of_stock';
    echo "
    	<item>
    	<g:id>{$product->get_id()}</g:id>
    	<g:title>{$product->get_name()}</g:title>
    	<g:description><![CDATA[{$description}]]></g:description>
    	<g:link>{$product->get_permalink()}</g:link>
    	<g:image_link>{$image}</g:image_link>
    	<g:condition>new</g:condition>
    	<g:availability>{$inStore}</g:availability>
    	<g:price>{$price} RUB</g:price>
    	{$vendor}
    	<g:mpn></g:mpn>
    	<g:gtin></g:gtin>
    	<g:identifier_exists>no</g:identifier_exists>
    	<g:google_product_category>{$category->name}</g:google_product_category>
    	<g:product_type>{$category->name}</g:product_type>
    	</item>
    ";

    $product_duplicates = get_field('duplicate_pages', $product->get_id());
    $product_duplicates = ($product_duplicates) ? $product_duplicates : [];
    foreach($product_duplicates as $dup){
        $product->set_description($description);
        $product->set_name($dup['duplicate_page_title']);
        if( $dup['duplicate_page_desc'] ){
        	$product->set_description($dup['duplicate_page_desc']);
        }
        $duplicateLink = home_url("/kupit/{$dup['duplicate_page_slug']}/");
        $duplicateDescription = product_dup_vars($product->get_description());
        echo "
        	<item>
        	<g:id>{$product->get_id()}</g:id>
        	<g:title>{$product->get_name()}</g:title>
        	<g:description><![CDATA[{$duplicateDescription}]]></g:description>
        	<g:link>{$duplicateLink}</g:link>
        	<g:image_link>{$image}</g:image_link>
        	<g:condition>new</g:condition>
        	<g:availability>in stock</g:availability>
        	<g:price>{$price} RUB</g:price>
        	{$vendor}
        	<g:mpn></g:mpn>
        	<g:gtin></g:gtin>
        	<g:identifier_exists>no</g:identifier_exists>
        	<g:google_product_category>{$category->name}</g:google_product_category>
        	<g:product_type>{$category->name}</g:product_type>
        	</item>
        ";
    }
}
?>


</channel>
</rss>
