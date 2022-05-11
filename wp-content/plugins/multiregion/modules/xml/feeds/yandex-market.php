<?php
header("Content-Type: text/xml; charset=utf-8");
header('Content-type: application/xml');
header( 'HTTP/1.1 200 OK');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">";
global $region_obj;
$region_id = ($region_obj->url == '') ? '' : $region_obj->id;
?>

<yml_catalog date="<?php echo date('Y-m-d h:i'); ?>">
<shop>
<name>online-kassa-54fz.ru</name>
<company>Онлайн кассы 54ФЗ</company>
<url><?php echo home_url(); ?></url>
<email><?php echo $region_obj->email; ?></email>
<currencies>
    <currency id="RUR" rate="1"/>
</currencies>
<categories>
<?php
$categories = get_categories(['taxonomy' => 'product_cat', 'hide_empty' => false, 'exclude' => [1827]]);
foreach($categories as $category){
    $parent = ($category->parent != 0) ? "parentId='{$category->parent}'" : '';
    echo "<category id='{$category->term_id}' {$parent}>{$category->name}</category>";
}
?>
</categories>
<delivery-options>
    <option cost="300" days=""/>
</delivery-options>
<cpa>1</cpa>
<offers>
<?php
$products = wc_get_products(['limit' => -1, 'status' => 'publish']);
$xml_utm = (isset($_GET['xml_utm'])) ? '?' . htmlspecialchars($_GET['xml_utm']) : '';
foreach($products as $product){
    $utm = $xml_utm;
    $in_market = get_post_meta($product->get_id(), $region_id.'_allow_market', true);
    $stock_status = get_post_meta($product->get_id(), $region_id.'_region_stock_status', true);
    $day = get_post_meta($product->get_id(), $region_id.'_delivery_date', true);
    if($in_market != 1) continue;

    $image = get_the_post_thumbnail_url($product->get_id());
    $description = product_dup_vars($product->get_description());
    if($product->is_type('simple') && $product->is_on_sale()){
        $price = "<price>{$product->get_sale_price()}</price>\n<oldprice>{$product->get_regular_price()}</oldprice>";
    }else{
        $price = "<price>".auto_price($product)."</price>";
    }

    $category_id = $product->get_category_ids()[0];
    if( class_exists('WPSEO_Primary_Term') ){
    	$wpseo_primary_term = new WPSEO_Primary_Term('product_cat', $product->get_id());
    	$primary_category_id = $wpseo_primary_term->get_primary_term();
    }
    $category_id = ($primary_category_id) ? $primary_category_id : $category_id;
    $utm = str_replace('%product_id%', $product->get_id(), $utm);
    $category = get_term($category_id, 'product_cat');
    $attributes =  $product->get_attributes(); $params = '';
    if($attributes){
        foreach($attributes as $key => $attribute){
            $name = wc_attribute_label($key);
            $value = $product->get_attribute($key);
            $params .= "<param name='{$name}'>{$value}</param>";
        }
    }
    if ( !empty($product->get_tag_ids()) ) {
        $tag_id = $product->get_tag_ids()[0];
        $tag = get_term($tag_id, 'product_tag');
        $vendor = "<vendor>{$tag->name}</vendor>";
    }

    $inStore = ($stock_status != 'outofstock') ? 'true' : 'false';

    if( $day > 1 ):
        $cost_day = ($day - 2).'-'.$day;
    elseif( $day < 2 AND $day != 0 ):
        $cost_day = '0-'.$day;
    elseif( $day == 0 AND $day !== '' ):
        $cost_day = 0;
    else :
        $cost_day = '';
    endif;
    $deliveryOptions = ($day != '') ? "<delivery-options><option cost='300' order-before='24' days='{$cost_day}'/></delivery-options>" : '';

    echo "
        <offer id='{$product->get_id()}' available='{$inStore}'>
        <url>{$product->get_permalink()}{$utm}</url>
        {$price}
        <currencyId>RUR</currencyId>
        <categoryId>{$category_id}</categoryId>
        <picture>{$image}</picture>
        <store>{$inStore}</store>
        <pickup>true</pickup>
        <delivery>true</delivery>
        {$deliveryOptions}
        <name>{$product->get_name()}</name>
        {$vendor}
        <model>{$product->get_name()}</model>
        <description>
            <![CDATA[ {$description} ]]>
        </description>
        <sales_notes>Оплата наличными или картой! Можно в рассрочку!</sales_notes>
        <manufacturer_warranty>true</manufacturer_warranty>
        {$params}
        </offer>
    ";

    $product_duplicate_index = 1000;
    $product_duplicates = get_field('duplicate_pages', $product->get_id());
    $product_duplicates = ($product_duplicates) ? $product_duplicates : [];
    foreach($product_duplicates as $dup){
        $product->set_description($description);
        $product->set_name($dup['duplicate_page_title']);
        if( $dup['duplicate_page_short_desc'] ){
        	$product->set_short_description($dup['duplicate_page_short_desc']);
        }
        if( $dup['duplicate_page_desc'] ){
        	$product->set_description($dup['duplicate_page_desc']);
        }
        $duplicateLink = home_url("/kupit/{$dup['duplicate_page_slug']}/");
        $duplicateDescription = product_dup_vars($product->get_description());
        echo "
            <offer id='{$product_duplicate_index}{$product->get_id()}' available='{$inStore}'>
            <url>{$duplicateLink}</url>
            {$price}
            <currencyId>RUR</currencyId>
            <categoryId>{$category_id}</categoryId>
            <picture>{$image}</picture>
            <store>true</store>
            <pickup>true</pickup>
            <delivery>true</delivery>
            {$deliveryOptions}
            <name>{$product->get_name()}</name>
            {$vendor}
            <model>{$product->get_name()}</model>
            <description>
                <![CDATA[ {$duplicateDescription} ]]>
            </description>
            <sales_notes>Оплата наличными или картой! Можно в рассрочку!</sales_notes>
            <manufacturer_warranty>true</manufacturer_warranty>
            {$params}
            </offer>
        ";
        $product_duplicate_index += 1000;
    }


}
?>

</offers>

</shop>
</yml_catalog>
