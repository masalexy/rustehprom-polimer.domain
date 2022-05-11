<?php

add_filter('wpseo_title',function($title){
	global $region_key;
	if( is_front_page() && $region_key != '' ){
		return yoast_custom_vars("{$title} в %region_e%");
	}
	return $title;
});


add_filter('wpseo_metadesc',function($desc){
	$desc = str_replace('%excerpt%', get_excerpt_max_charlength(150), $desc);
	return $desc;
});



add_filter('wpseo_robots',function($robots){
	if( is_product_category() || is_product_tag() || is_shop()){
		$robots = 'index,follow';
	}
	return $robots;
});


function get_excerpt_max_charlength( $charlength ){
	$output = '';
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode(' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$output = mb_substr( $subex, 0, $excut );
		} else {
			$output = $subex;
		}
	} else {
		$output = $excerpt;
	}
	return $output;
}
