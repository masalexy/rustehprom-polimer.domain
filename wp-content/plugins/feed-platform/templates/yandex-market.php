<?php
ini_set('memory_limit', '-1');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/xml; charset=utf-8");
header('Content-type: application/xml');
header('HTTP/1.1 200 OK');

echo "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">";

global $wpdb, $region_obj, $feed_args;
$region_id = ($region_obj->url == '') ? '' : $region_obj->id;
$meta_prefix = ($region_id != '') ? $region_id : '';

$email = do_shortcode('[multiregion param="email" html="false"]');
$shop_name = get_option("shop-name_{$region_id}_{$feed_args['feed-id']}");
$shop_sales_note = get_option("shop-sales-note_{$region_id}_{$feed_args['feed-id']}");
$shop_delivery = get_option("shop-delivery_{$region_id}_{$feed_args['feed-id']}");
$shop_delivery_price = get_option("shop-delivery-price_{$region_id}_{$feed_args['feed-id']}");
$shop_pickup = get_option("shop-pickup_{$region_id}_{$feed_args['feed-id']}");
$shop_is_store = get_option("shop-is-store_{$region_id}_{$feed_args['feed-id']}");
$shop_is_warranty = get_option("shop-is-warranty_{$region_id}_{$feed_args['feed-id']}");

function filter_xml($text){
    $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
    $text = urldecode($text);
    return $text;
}



?>

<yml_catalog date="<?php echo date('Y-m-d h:i'); ?>">
<shop>
<name><?php echo $_SERVER['SERVER_NAME']; ?></name>
<company><?php echo $shop_name; ?></company>
<url><?php echo home_url(); ?></url>
<email><?php echo $email; ?></email>
<currencies>
    <currency id="RUR" rate="1"/>
</currencies>
<categories>
<?php
$categories = get_categories(['taxonomy' => 'product_cat', 'exclude' => [3037]]);
foreach($categories as $category){
    $parent = ($category->parent != 0) ? "parentId='{$category->parent}'" : '';
    echo "<category id='{$category->term_id}' {$parent}>{$category->name}</category>";
}
?>
</categories>
<?php if($shop_delivery): ?>
<delivery-options>
    <option cost="<?php echo $shop_delivery_price; ?>" days=""/>
</delivery-options>
<?php endif; ?>
<cpa>1</cpa>
<offers>
<?php
$products = [];
$ids = get_feed_products($feed_args['feed-id'], $region_id);
if($ids){
    $products = wc_get_products(['limit' => -1, 'status' => 'publish', 'include' => $ids ]);
}

foreach($products as $product){

    $regular_price = get_post_meta($product->get_id(), $meta_prefix.'_regular_price', true);
    $sale_price = get_post_meta($product->get_id(), $meta_prefix.'_sale_price', true);
    $sales_note = get_post_meta($product->get_id(), $meta_prefix.'_sales_note', true);
    $delivery_date = get_post_meta($product->get_id(), $meta_prefix.'_delivery_date', true);
    $stock_status = get_post_meta($product->get_id(), $meta_prefix.'_region_stock_status', true);

    $sales = @ $sales_note ? $sales_note : $shop_sales_note;

    $regular_price = ($regular_price) ? $regular_price : get_post_meta($product->get_id(), '_regular_price', true);
    $delivery_date = ($delivery_date) ? $delivery_date : get_post_meta($product->get_id(), '_delivery_date', true);


	if( $shop_delivery == '0' OR $stock_status == 'outofstock' ) {
		$dostavka = '';
		$nalichae = 'false';
		$sales = 'Товар на заказ. Необходима предоплата 100%';
	} else {
		$dostavka = '';
		if( $delivery_date !== '' ) {
			if( $delivery_date !== ''):
				$days = intval($delivery_date);
			else:
				$days = $def_day;
			endif;
			if( $days !== '' AND $days < 32 ):
				$nalichae = 'true';
				$store = '';
			else:
				$nalichae = 'false';
				$store = 'false';
			endif;
			if( $days > 1 ):
				$cost_day = ($days - 2).'-'.$days;
			elseif( $days < 2 AND $days != 0 ):
				$cost_day = '0-'.$days;
			elseif( $days == 0 AND $days !== '' ):
				$cost_day = 0;
			else :
				$cost_day = '';
			endif;
			if($days < 32) {
			$dostavka = "<delivery-options>
				<option cost=\"$shop_delivery_price\"  order-before=\"24\" days=\"$cost_day\"/>
			</delivery-options>";
			}
		} else {
			$nalichae = 'false';
			$gnalichie = 'preorder';
			$sales = 'Товар на заказ. Необходима предоплата 100%';
		}
	}
    if( $shop_is_store == '0' ){
    	$store_mag = 'false';
    } else {
    	$store_mag = @($stock_status != 'outofstock' ) ? 'true' : 'false';
    	if( isset($days) AND ($days === '' OR $days > 31) ) $store_mag = 'false';
    }

    $image = get_the_post_thumbnail_url($product->get_id());
    $image = ($image != '') ? $image : home_url('/wp-content/uploads/woocommerce-placeholder.png');




    if($sale_price != 0 && $sale_price < $price){
        $priceHtml = "<price>{$sale_price}</price>\n<oldprice>{$regular_price}</oldprice>";
    }else{
        $priceHtml = "<price>{$regular_price}</price>";
    }


    $category = $product->get_category_ids();

    $post_obj = new stdClass();
    $post_obj->ID = $product->get_id();
    $post_obj->post_title = $product->get_name();
    $description = yoast_custom_vars($product->get_description(), $post_obj);
    $description = do_shortcode($description);

    if( isset($_GET['html_desc']) && $_GET['html_desc'] == "false" ){
        $description = preg_replace("/<audio(.*?)>(.*?)<\/audio>/i", " ", $description);
        $description = preg_replace("/<video(.*?)>(.*?)<\/video>/i", " ", $description);
        $description = preg_replace("/<script(.*?)>(.*?)<\/script>/i", " ", $description);
        $description = preg_replace("/<style(.*?)>(.*?)<\/style>/i", " ", $description);
    }

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
            $params .= "<param name='{$label}'>{$value}</param>";
        }
    }
    $vendor = '';
    if ( !empty($product->get_tag_ids()) ) {
        $tag_id = $product->get_tag_ids()[0];
        $tag = get_term($tag_id, 'product_tag');
        $vendor = "<vendor>{$tag->name}</vendor>";
    }

    $utm = str_replace('%product_name%', urlencode($product->get_name()), $feed_args['feed-utm']);
    $utm = htmlspecialchars($utm);

    $delivery = ($shop_delivery == '1') ? 'true' : 'false';
    $warranty = ($shop_is_warranty == '1') ? 'true' : 'false';
    $pickup = ($shop_pickup == '1') ? 'true' : 'false';

    echo "
        <offer id='{$product->get_id()}' available='{$nalichae}'>
        <url>{$product->get_permalink()}{$utm}</url>
        {$priceHtml}
        <currencyId>RUR</currencyId>
        <categoryId>{$category[0]}</categoryId>
        <picture>{$image}</picture>
        <store>{$store_mag}</store>
        <pickup>{$pickup}</pickup>
        <delivery>{$delivery}</delivery>
        {$dostavka}
        <name>{$product->get_name()}</name>
        {$vendor}
        <model>{$product->get_name()}</model>
        <description>
            <![CDATA[ {$description} ]]>
        </description>
        <sales_notes>{$sales}</sales_notes>
        <manufacturer_warranty>{$warranty}</manufacturer_warranty>
        {$params}
        </offer>
    ";

}

?>

</offers>

</shop>
</yml_catalog>
