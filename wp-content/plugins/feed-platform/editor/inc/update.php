<?php
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
$editor = wp_get_current_user();

if( isset($_POST['update_data']) ){
	$data = json_decode(stripslashes($_POST['update_data']));
	$errors = [];

	if($data->name == 'regular_price'){
		$sale_price = get_post_meta($data->id, $data->region_id.'_sale_price', true);
		if($sale_price >= $data->value){
			$errors[] = 'Введите значение, которое больше цены распродажи.';
		}else if($sale_price == 0 || $sale_price == ''){
			update_post_meta( $data->id, $data->region_id.'_regular_price', $data->value );
			update_post_meta( $data->id, $data->region_id.'_price', $data->value );
		}else{
			update_post_meta( $data->id, $data->region_id.'_regular_price', $data->value );
		}
		wc_delete_product_transients( $data->id );
	}elseif($data->name == 'sale_price'){
		$regular_price = get_post_meta($data->id, $data->region_id.'_regular_price', true);
		$def_regular_price = get_post_meta($data->id, '_regular_price', true);
		$regular_price = ($regular_price) ? $regular_price : $def_regular_price;
		if($data->value == 0 || $data->value == ''){
			update_post_meta( $data->id, $data->region_id.'_sale_price', '');
			update_post_meta( $data->id, $data->region_id.'_price', $regular_price );
		}elseif($data->value < $regular_price){
			update_post_meta( $data->id, $data->region_id.'_sale_price', $data->value );
			update_post_meta( $data->id, $data->region_id.'_price', $data->value );
		}else{
			$errors[] = 'Введите значение, которое меньше базовой цены.';
		}
		wc_delete_product_transients( $data->id );
	}elseif($data->name == 'sales_note'){
		update_post_meta( $data->id, $data->region_id.'_sales_note', $data->value);
	}elseif($data->name == 'delivery_date'){
		update_post_meta( $data->id, $data->region_id.'_delivery_date', $data->value);
	}elseif($data->name == 'allow_market'){
		update_post_meta( $data->id, $data->region_id.'_allow_market', $data->value);
	}elseif($data->name == 'stock_status'){
		update_post_meta( $data->id, $data->region_id.'_region_stock_status', $data->value);
	}

	if( empty($errors) ){
		echo 1;
	}else{
		foreach($errors as $error){
			echo $error;
		}
	}
}




if( isset($_POST['mode']) ){
    global $wpdb;
    $gorod = $_POST['gorod'];
    $feed = $_POST['feed'];
    $mode = $_POST['mode'];
    $value = $_POST['value'];

    $exits = $wpdb->get_col("SELECT post_id FROM {$wpdb->prefix}feed_platform WHERE gorod = '{$gorod}' AND feed_id = '{$feed}'  ");

    $products = [];
	if($mode == "feed"){
	    $feed_ids = $wpdb->get_col("SELECT post_id FROM {$wpdb->prefix}feed_platform WHERE gorod = '{$value}' AND feed_id = '{$feed}'  ");
		if( !empty($feed_ids) ){
			$products_data = wc_get_products([
		        'include' => $feed_ids,
		        'limit' => -1
		    ]);
		}
	}else{
		$products_data = wc_get_products([
	        'category' => [$value],
	        'exclude' => $exits,
	        'limit' => -1
	    ]);
	}

    foreach($products_data as $p_data){
        $products[] = [
            'id' => $p_data->get_id(),
            'title' => $p_data->get_name()
        ];
    }

    echo json_encode($products);
}


if( isset($_POST['post_ids'])){
    $ids = explode(',', $_POST['post_ids']);
    $gorod = $_POST['gorod'];
    $feed = $_POST['feed'];
	$exits = $wpdb->get_col("SELECT post_id FROM {$wpdb->prefix}feed_platform WHERE gorod = '{$gorod}' AND feed_id = '{$feed}'  ");
    $query = "INSERT INTO `{$wpdb->prefix}feed_platform` (id, feed_id, gorod, post_id) VALUES";
    $values = [];
    foreach($ids as $id){
		if( in_array($id, $exits) ) continue;
        $values[] = " (null, '{$feed}', '{$gorod}', {$id})";
    }

	if( !empty($values) ){
	    $values = join(',', $values);
	    $query .= $values;
	    $res = $wpdb->query($query);

	    if($res){
	        echo json_encode(["status" => "SUCCESS"]);
	    }else{
	        echo json_encode(["status" => "Ошибка: {$wpdb->last_error}"]);
	    }
	}else{
		 echo json_encode(["status" => "SUCCESS"]);
	}
}


if( isset($_POST['rm_post_id'])){
    $id = $_POST['rm_post_id'];
    $gorod = $_POST['gorod'];
    $feed = $_POST['feed'];

    $res = $wpdb->query("DELETE FROM {$wpdb->prefix}feed_platform WHERE post_id = {$id} AND gorod = '{$gorod}' AND feed_id = '{$feed}'  ");

    if($res){
        echo json_encode(["status" => "SUCCESS"]);
    }else{
        echo json_encode(["status" => "Ошибка: {$wpdb->last_error}"]);
    }
}

if( isset($_POST['post_keyword'])){
	global $wpdb;
    $keyword = $_POST['post_keyword'];
	if(is_numeric($keyword)){
		$products = $wpdb->get_results("SELECT ID, post_title  FROM $wpdb->posts WHERE ID = {$keyword} AND post_type = 'product' AND  post_status = 'publish' ");
	}else{
		$products = $wpdb->get_results("SELECT ID, post_title  FROM $wpdb->posts WHERE post_title LIKE '%{$keyword}%' AND post_type = 'product' AND  post_status = 'publish' ");
	}
    echo json_encode($products);
}





if( isset($_POST['def_settings']) ){
	$data = json_decode(stripslashes($_POST['def_settings']), true);
	$key = "{$data['name']}_{$data['gorod']}_{$data['feed']}";
	$value = $data['value'];
	$res = update_option($key, $value);
	if($res){
        echo json_encode(["status" => "SUCCESS"]);
    }else{
        echo json_encode(["status" => "Ошибка: {$res}"]);
    }
}
