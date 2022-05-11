<?php
ini_set('memory_limit', '-1');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/xml; charset=utf-8");
header('Content-type: application/xml');
header('HTTP/1.1 200 OK');

echo '<?xml version="1.0" encoding="utf-8"?>';

global $wpdb, $socr_gorod, $feed_args;
$meta_prefix = ($socr_gorod != 'msk') ? $socr_gorod : '';

$address = "Москва и Московская Область"; //do_shortcode('[multiregion param="address"]');

function filter_xml($text){
    $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
    $text = urldecode($text);
    return $text;
}



?>
<feed version="1">
<offers>

<?php
$products = [];
$ids = get_feed_products($feed_args['feed-id'], $socr_gorod);
if($ids){
    $products = wc_get_products(['limit' => -1, 'status' => 'publish', 'include' => $ids ]);
}

foreach($products as $product){

    $regular_price = get_post_meta($product->get_id(), $meta_prefix.'_regular_price', true);
    $sale_price = get_post_meta($product->get_id(), $meta_prefix.'_sale_price', true);
    $regular_price = ($regular_price) ? $regular_price : get_post_meta($product->get_id(), '_regular_price', true);


    $imagesHtml = "";
    $imageUrls = [];
    $main_image_id = get_post_thumbnail_id($product->get_id());
    $imageUrls[] = $main_image_id;
    $galleryIds = $product->get_gallery_image_ids();
    $imageUrls = ($galleryIds) ? array_merge($imageUrls, $galleryIds) : $imageUrls;

    foreach($imageUrls as $imid){
        $imagesHtml .= '<image>' . wp_get_attachment_url($imid) . '</image>';
    }



    $post_obj = new stdClass();
    $post_obj->ID = $product->get_id();
    $post_obj->post_title = $product->get_name();
    $description = yoast_custom_vars($product->get_description(), $post_obj);

    $description = strip_shortcodes($description);
    $description = preg_replace("/<audio(.*?)>(.*?)<\/audio>/i", "", $description);
    $description = preg_replace("/<video(.*?)>(.*?)<\/video>/i", "", $description);
    $description = preg_replace("/<script(.*?)>(.*?)<\/script>/i", "", $description);
    $description = preg_replace("/<style(.*?)>(.*?)<\/style>/i", "", $description);
    $description = preg_replace("/<table(.*?)>(.*?)<\/table>/s", "", $description);

    $description =  strip_tags($description,'<b><i><sup><sub><strong><tt><br><em><p><ul><ol><li><table>');






    if($sale_price != 0 && $sale_price < $price){
        $float_price = $sale_price;
    }else{
        $float_price = $regular_price;
    }


    $category = get_field('ya_ads_cat', $product->get_id());

    $attributes =  $product->get_attributes(); $params = '';
    if($attributes){
        foreach($attributes as $key => $attribute){
            $name = filter_xml($attribute->get_name());
            $value = filter_xml($product->get_attribute($key));
            if ( $attribute->is_taxonomy() ) {
                $label = filter_xml(wc_attribute_label($key));
            }else{
                $label = $name;
            }
            $value = str_replace('<', '&#60;', $value);
            $params .= "<li>{$label}: {$value}</li>";
        }
    }
    $attributes = ($params) ? "<ul>{$params}</ul>" : '';
    $description .= $attributes;

    $utm = str_replace('%product_name%', urlencode($product->get_name()), $feed_args['feed-utm']);
    $utm = htmlspecialchars($utm);

    echo "
        <offer>
            <id>{$product->get_id()}</id>
            <seller>
                <contacts>
                    <phone>+74951322697</phone>
                    <contact-method>any</contact-method>
                </contacts>
                <locations>
                    <location>
                        <address>{$address}</address>
                    </location>
                </locations>
            </seller>
            <title>{$product->get_name()}</title>
            <description><![CDATA[ {$description} ]]></description>
            <condition>new</condition>
            <category>{$category}</category>
            <images>{$imagesHtml}</images>
            <price>{$float_price}</price>
        </offer>
    ";

}

?>


    </offers>
</feed>
