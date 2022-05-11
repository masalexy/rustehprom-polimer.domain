<?php
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');


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
?>
