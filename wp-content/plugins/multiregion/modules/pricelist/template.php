<?php if( !is_super_admin() ) exit("Access Denied"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактор цен</title>
	<link href="/wp-content/plugins/multiregion/modules/pricelist/css/style.css?v=7" rel="stylesheet" />
</head>
<body>



<div class="wrapper">
	<form method="get">
		<?php
            $list_id = ( isset($_GET['list_id']) ) ? $_GET['list_id'] : 1;
            $region_id = ( isset($_GET['region_id']) ) ? $_GET['region_id'] : '';

			require 'inc/regions.php';
			require 'inc/product-list.php';

            if($list_id == 2 ){
                require 'inc/category.php';
                $category_id = ( isset($_GET['cat_id']) ) ? $_GET['cat_id'] : $first;
            }
		?>
	</form>

	<?php



    if($list_id == 1){
        $allowed = get_posts([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key'  => $region_id.'_allow_market',
            'meta_value'  => '1',
            'fields' => 'ids'
        ]);
        $products = ($allowed) ? wc_get_products(['include' => $allowed, 'limit' => -1]) : [];
    }else{
    	$cat_slug = get_term_by('id', $category_id, 'product_cat')->slug;
        $products = wc_get_products([
    		'posts_per_page' => -1,
    		'status' => 'publish',
    		'category'  => [$cat_slug]
    	]);
    }




	echo "<table class='pricelist'>";
	echo "<tr> <th>ID</th> <th>Название</th> <th>Параметры</th> </tr>";
	foreach( $products as $product ){
		$price_html = "";
		if( $product->get_type() == 'simple' ){
			$regular_price = get_post_meta($product->get_id(), $region_id.'_regular_price', true);
			$sale_price = get_post_meta($product->get_id(), $region_id.'_sale_price', true);
			$delivery_date = get_post_meta($product->get_id(), $region_id.'_delivery_date', true);
			$allow_market = get_post_meta($product->get_id(), $region_id.'_allow_market', true);
            $stock_status = get_post_meta($product->get_id(), $region_id.'_region_stock_status', true);

			$default_regular_price = get_post_meta($product->get_id(), '_regular_price', true);
			$default_sale_price = get_post_meta($product->get_id(), '_sale_price', true);
            $default_delivery_date = get_post_meta($product->get_id(), '_delivery_date', true);

            $s1 = ($allow_market == 1) ? 'selected' : '';
            $s2 = ($allow_market == 1) ? 'selected' : '';
            $status1 = ($stock_status != 'outofstock') ? 'selected' : '';
            $status2 = ($stock_status != 'outofstock') ? 'selected' : '';

			$price_html .= "<tr>";
    			$price_html .= "<td>Простой</td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='regular_price' placeholder='{$default_regular_price}' value='{$regular_price}'></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='sale_price' placeholder='{$default_sale_price}' value='{$sale_price}'></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='delivery_date' placeholder='{$default_delivery_date}' value='{$delivery_date}'></td>";
    			$price_html .= "<td><select save='false' id='{$product->get_id()}' class='ajax_field' name='allow_market'><option value='0' {$s1}>Нет</option><option value='1' {$s2}>Да</option></select></td>";
    			$price_html .= "<td><select save='false' id='{$product->get_id()}' class='ajax_field' name='stock_status'><option value='outofstock' {$status1}>Нет</option><option value='instock' {$status2}>Да</option></select></td>";
			$price_html .= "</tr>";
		}elseif( $product->get_type() == 'grouped' ){
			$delivery_date = get_post_meta($product->get_id(), $region_id.'_delivery_date', true);
			$allow_market = get_post_meta($product->get_id(), $region_id.'_allow_market', true);
            $stock_status = get_post_meta($product->get_id(), $region_id.'_region_stock_status', true);
            $default_delivery_date = get_post_meta($product->get_id(), '_delivery_date', true);

            $s1 = ($allow_market == 1) ? 'selected' : '';
            $s2 = ($allow_market == 1) ? 'selected' : '';
            $status1 = ($stock_status != 'outofstock') ? 'selected' : '';
            $status2 = ($stock_status != 'outofstock') ? 'selected' : '';

			$price_html .= "<tr>";
    			$price_html .= "<td>Комплект</td>";
    			$price_html .= "<td><input type='text' disabled></td>";
    			$price_html .= "<td><input type='text' disabled></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='delivery_date' placeholder='{$default_delivery_date}' value='{$delivery_date}'></td>";
    			$price_html .= "<td><select save='false' id='{$product->get_id()}' class='ajax_field' name='allow_market'><option value='0' {$s1}>Нет</option><option value='1' {$s2}>Да</option></select></td>";
                $price_html .= "<td><select save='false' id='{$product->get_id()}' class='ajax_field' name='stock_status'><option value='outofstock' {$status1}>Нет</option><option value='instock' {$status2}>Да</option></select></td>";
            $price_html .= "</tr>";

		}else{
			continue;
		}

		echo
		"
			<tr>
				<td class='product_id'>{$product->get_id()}</td>
				<td class='product_name'>{$product->get_name()} <a href='/wp-admin/post.php?post={$product->get_id()}&action=edit' target='blank'>edit</a></td>
				<td>
					<table class='variations' region='{$region_id}'>
						<tr>
							<th>Тип</th>
							<th>Базовая цена</th>
							<th>Цена распродажи</th>
							<th>Срок доставки</th>
							<th>Выгрузка в ЯМ</th>
							<th>В наличии</th>
						</tr>
						{$price_html}
					</table>
				</td>
			</tr>
		";
	}
	echo "</table>";
	?>
	<div id='notice'>
		<h2>Уведомление <i>x</i></h2>
		<span></span>
	</div>
</div>

<script src='/wp-content/plugins/multiregion/modules/pricelist/js/main.js?v=4'></script>

</body>
</html>
