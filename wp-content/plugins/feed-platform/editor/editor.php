<?php if( !is_super_admin() ) exit("Access Denied. Try to <a href='/digi-login.php?pricelist=true'>log in</a>"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактор цен</title>
	<link href="/wp-content/plugins/feed-platform/editor/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body>



<div class="wrapper">
    <div class="top-bar">

    	<form method="get">
    		<?php
    			require 'inc/regions.php';
    			require 'inc/feed-select.php';
                global $def_region_id, $def_feed, $feed_labels;
                $current_gorod = isset($_GET['region_id']) ? $_GET['region_id'] : $def_region_id;
                $current_region_id = ($current_gorod != 1) ? $current_gorod : '';
                $current_feed = isset($_GET['feed-id']) ? $_GET['feed-id'] : $def_feed;
    		?>
    	</form>

        <script>
            window.feedParams = {
                current_feed: '<?php echo $current_feed; ?>',
                current_gorod: '<?php echo $current_gorod; ?>',
                current_region_id: '<?php echo $current_region_id; ?>'
            };
        </script>

        <a href="https://rustehprom-polimer.ru<?php echo ($current_gorod != 1) ? '/' . $current_gorod : ''; ?>/genxmlfeed/<?php echo $feed_labels[$current_feed]; ?>/" target="_blank">Открить фид</a>

        <div class="add_products">Добавить товары</div>

    </div>


    <?php require 'inc/default-settings.php' ?>


	<?php
    $products = [];
    $ids = get_feed_products($current_feed, $current_gorod);

    echo count($ids);

    if($ids){
        $products = wc_get_products([
            'include' => $ids,
            'status' => 'publish',
            'limit' => -1
        ]);
    }



	echo "<table class='pricelist'>";
	echo "<tr> <th>ID</th> <th>Название</th> <th>Параметры</th> </tr>";
	foreach( $products as $product ){
		$price_html = "";
		if( $product->get_type() == 'simple' ){
			$regular_price = get_post_meta($product->get_id(), $current_region_id.'_regular_price', true);
			$sale_price = get_post_meta($product->get_id(), $current_region_id.'_sale_price', true);
			$sales_note = get_post_meta($product->get_id(), $current_region_id.'_sales_note', true);
			$delivery_date = get_post_meta($product->get_id(), $current_region_id.'_delivery_date', true);
            $stock_status = get_post_meta($product->get_id(), $current_region_id.'_region_stock_status', true);

			$default_regular_price = get_post_meta($product->get_id(), '_regular_price', true);
			$default_sale_price = get_post_meta($product->get_id(), '_sale_price', true);
            $default_delivery_date = get_post_meta($product->get_id(), '_delivery_date', true);

            $status1 = ($stock_status != 'outofstock') ? 'selected' : '';
            $status2 = ($stock_status != 'outofstock') ? 'selected' : '';

            $regular_price = ($regular_price) ? $regular_price : $default_regular_price;

			$price_html .= "<tr>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='regular_price' placeholder='{$default_regular_price}' value='{$regular_price}'></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='sale_price' placeholder='{$default_sale_price}' value='{$sale_price}'></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='sales_note' placeholder='' value='{$sales_note}'></td>";
    			$price_html .= "<td><input type='text' save='false' id='{$product->get_id()}' class='ajax_field' name='delivery_date' placeholder='{$default_delivery_date}' value='{$delivery_date}'></td>";
    			$price_html .= "<td><select save='false' id='{$product->get_id()}' class='ajax_field' name='stock_status'><option value='outofstock' {$status1}>Нет</option><option value='instock' {$status2}>Да</option></select></td>";
    			$price_html .= "<td><button value='{$product->get_id()}' class='remove-product-item'>&times;</button></td>";
			$price_html .= "</tr>";
		}else{
			continue;
		}

		echo
		"
			<tr class='row-line'>
				<td class='product_id'>{$product->get_id()}</td>
				<td class='product_name'>{$product->get_name()} <a href='/wp-admin/post.php?post={$product->get_id()}&action=edit' target='blank'>edit</a></td>
				<td>
					<table class='variations' region='{$current_region_id}'>
						<tr>
							<th>Базовая цена</th>
							<th>Цена распродажи</th>
							<th>Предложение</th>
							<th>Срок доставки</th>
							<th>В наличии</th>
							<th>Удалить</th>
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


<div class="editor-modal products-modal hidden">
    <div class="editor-modal-close">&times;</div>
    <div class="editor-modal-content">
        <div class="editor-container">
            <div class="load-mode-block">
                <label><input type="radio" class="load-mode" name="load-mode" value="site" checked>С сайта</label>
                <label><input type="radio" class="load-mode" name="load-mode" value="feed">С фида</label>
                <label><input type="radio" class="load-mode" name="load-mode" value="name">По названию</label>
            </div>
            <div class="modes" mode="site">
                <?php include('inc/load-modes.php'); ?>
            </div>
            <div class="actions">
                <div><span id="check_all">Выбрать все</span> <b>|</b> <span id="uncheck_all">Снять все</span></div>
                <div id="add_to_feed">&#43; Добавить в фид</div>
            </div>
            <div id="p_loader_gif" class="hidden">
                <img src="/wp-content/plugins/feed-platform/editor/css/loading.gif" />
            </div>
            <div id="products-load-container"></div>
        </div>
    </div>
</div>



<div class="progress-loader hidden"><img src="/wp-content/plugins/feed-platform/editor/css/loading.gif" /></div>

<script src='/wp-content/plugins/feed-platform/editor/js/main.js?v=<?php echo time(); ?>'></script>

</body>
</html>
