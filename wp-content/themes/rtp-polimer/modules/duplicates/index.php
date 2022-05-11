<?php
add_action('admin_head', function() {
	echo "<link rel='stylesheet' href='/wp-content/themes/rtp-polimer/modules/duplicates/input/style-duplicate-functions.css?v=8' media='all'>";
});
add_action( 'admin_footer', function (){
    echo "<script src='/wp-content/themes/rtp-polimer/modules/duplicates/input/duplicate-functions.js?v=33'></script>";
	echo '<div class="modal_editor_popup" style="display: none;"><span class="dashicons dashicons-no-alt"></span><div id="modat_editor"></div><div id="insert_modal_content">Вставить</div></div>';
});

add_action( 'wp', function (){
    global $wp_rewrite, $duplicateObject;
    $duplicateObject = [];

    $products = get_posts([
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);


    foreach($products as $product){
        $duplicates = get_field('duplicate_pages', $product->ID);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                if($duplicate['duplicate_page_slug'] == '') continue;
                add_rewrite_rule(
                    'kupit/'.$duplicate['duplicate_page_slug'].'$',
                    'index.php?product='.$product->post_name,
                    'top'
                );
                $duplicateObject['p_'.$duplicate['duplicate_page_slug']] = [
                    'title' => $duplicate['duplicate_page_title'],
                    'slug' => $duplicate['duplicate_page_slug'],
                    'short_desc' => $duplicate['duplicate_page_short_desc'],
                    'desc' => $duplicate['duplicate_page_desc'],
                    'image' => $duplicate['duplicate_page_image'],
                    'gallery' => $duplicate['duplicate_page_gallery'],
                    'seo_desc' => $duplicate['duplicate_page_seo_desc']
                ];

                $yoastDuplicates[] = $duplicate['duplicate_page_slug'];
            }
        }
    }

    $categories = get_categories([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);


    foreach($categories as $category){
        $duplicates = get_field('duplicate_pages', $category);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                if($duplicate['duplicate_page_slug'] == '') continue;
                add_rewrite_rule(
                    'kupit/cat/'.$duplicate['duplicate_page_slug'].'$',
                    'index.php?product_cat='.$category->slug,
                    'top'
                );
                $duplicateObject['c_'.$duplicate['duplicate_page_slug']] = [
                    'title' => $duplicate['duplicate_page_title'],
                    'prefix' => $duplicate['duplicate_page_prefix'],
                    'slug' => $duplicate['duplicate_page_slug'],
                    'short_desc' => $duplicate['duplicate_page_short_desc'],
                    'desc' => $duplicate['duplicate_page_desc'],
					'seo_desc' => $duplicate['duplicate_page_seo_desc']
                ];
            }
        }
    }

    $tags = get_categories([
        'taxonomy' => 'product_tag',
        'hide_empty' => false,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);


    foreach($tags as $tag){
        $duplicates = get_field('duplicate_pages', $tag);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                if($duplicate['duplicate_page_slug'] == '') continue;
                add_rewrite_rule(
                    'kupit/brand/'.$duplicate['duplicate_page_slug'].'$',
                    'index.php?product_tag='.$tag->slug,
                    'top'
                );
                $duplicateObject['t_'.$duplicate['duplicate_page_slug']] = [
                    'title' => $duplicate['duplicate_page_title'],
                    'prefix' => $duplicate['duplicate_page_prefix'],
                    'slug' => $duplicate['duplicate_page_slug'],
                    'short_desc' => $duplicate['duplicate_page_short_desc'],
                    'desc' => $duplicate['duplicate_page_desc'],
					'seo_desc' => $duplicate['duplicate_page_seo_desc']
                ];
            }
        }
    }

    $wp_rewrite->flush_rules( true );
});



add_action('wp', function(){
    global $duplicateObject, $duplicateSettings;
    $duplicateSettings = [];

    if( is_product() ){
        global $wp;
        $key = urldecode('p_'.str_replace('kupit/', '', $wp->request));
        if( array_key_exists($key, $duplicateObject) ){
            $duplicateSettings = [
                'title' => $duplicateObject[$key]['title'],
                'slug' => $duplicateObject[$key]['slug'],
                'short_desc' => array_key_exists('short_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['short_desc'] : false,
                'desc' => array_key_exists('desc', $duplicateObject[$key]) ? $duplicateObject[$key]['desc'] : false,
                'image' => array_key_exists('image', $duplicateObject[$key]) ? $duplicateObject[$key]['image'] : false,
                'gallery' => array_key_exists('gallery', $duplicateObject[$key]) ? $duplicateObject[$key]['gallery'] : false,
                'seo_desc' => array_key_exists('seo_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['seo_desc'] : false
            ];
        }
    }

    if( is_product_category() ){
        global $wp;
        $key = urldecode('c_'.str_replace('kupit/cat/', '', $wp->request));
        if( array_key_exists($key, $duplicateObject) ){
            $duplicateSettings = [
                'title' => $duplicateObject[$key]['title'],
                'prefix' => $duplicateObject[$key]['prefix'],
                'slug' => $duplicateObject[$key]['slug'],
                'short_desc' => array_key_exists('short_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['short_desc'] : false,
                'desc' => array_key_exists('desc', $duplicateObject[$key]) ? $duplicateObject[$key]['desc'] : false,
				'seo_desc' => array_key_exists('seo_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['seo_desc'] : false
            ];
        }
    }

    if( is_product_tag() ){
        global $wp;
        $key = urldecode('t_'.str_replace('kupit/brand/', '', $wp->request));
        if( array_key_exists($key, $duplicateObject) ){
            $duplicateSettings = [
                'title' => $duplicateObject[$key]['title'],
                'prefix' => $duplicateObject[$key]['prefix'],
                'slug' => $duplicateObject[$key]['slug'],
                'short_desc' => array_key_exists('short_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['short_desc'] : false,
                'desc' => array_key_exists('desc', $duplicateObject[$key]) ? $duplicateObject[$key]['desc'] : false,
				'seo_desc' => array_key_exists('seo_desc', $duplicateObject[$key]) ? $duplicateObject[$key]['seo_desc'] : false
            ];
        }
    }
});

add_filter('wpseo_next_rel_link', '__return_false');
add_filter('wpseo_prev_rel_link', '__return_false');

function yoast_canonical($canonical_url){
    global $duplicateSettings;

    if( is_product() ){
        if( !empty($duplicateSettings) )
            return home_url("/kupit/{$duplicateSettings['slug']}/");
    }

    if( is_product_category() ){
        if( !empty($duplicateSettings) )
            return home_url("/kupit/cat/{$duplicateSettings['slug']}/");
    }

    return $canonical_url;
};

add_filter('wpseo_title', 'yoast_custom_vars');
add_filter('wpseo_metadesc', 'yoast_custom_vars');

function yoast_custom_vars($seo, $feed_product = false){

    $name_ask = explode(';', do_shortcode("[multiregion param='name_ask']"));
    $region = [
        'name' => do_shortcode("[multiregion param='name']"),
        'gorode'  => (array_key_exists(0, $name_ask)) ? $name_ask[0] : '',
        'gorodu'  => (array_key_exists(1, $name_ask)) ? $name_ask[1] : '',
    ];
    $seo = str_replace('%region%', $region['name'], $seo);
    $seo = str_replace('%region_e%', $region['gorode'], $seo);
    $seo = str_replace('%region_u%', $region['gorodu'], $seo);

    if( is_product() ){
        global $post, $duplicateSettings;
        $seoTitle = ( !empty($duplicateSettings) ) ? $duplicateSettings['title'] : $post->post_title;
        $category = wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names'])[0];
        $seo = str_replace('%productTitle%', $seoTitle, $seo);
        $seo = str_replace('%categoryTitle%', $category, $seo);
    }

	if( $feed_product ){
        global $duplicateSettings;
        $seoTitle = ( !empty($duplicateSettings) ) ? $duplicateSettings['title'] : $feed_product->post_title;
        $category = wp_get_post_terms($feed_product->ID, 'product_cat', ['fields' => 'names'])[0];
        $seo = str_replace('%productTitle%', $seoTitle, $seo);
        $seo = str_replace('%categoryTitle%', $category, $seo);
    }

    if( is_product_category() || is_product_tag() ){
        global $duplicateSettings;
        $term = get_queried_object();
        $seoTitle = ( !empty($duplicateSettings) ) ? $duplicateSettings['title'] : $term->name;
        $seo = str_replace('%categoryTitle%', $seoTitle, $seo);
        $seo = str_replace('%tagTitle%', $seoTitle, $seo);
    }

    return $seo;
}

add_filter('the_content', function($content){
    return yoast_custom_vars($content);
});

add_filter('wpseo_metadesc', function($desc){
	global $duplicateSettings;
    if ( (is_product() || is_product_category() || is_product_tag()) && !empty($duplicateSettings) ) {
        if($duplicateSettings['seo_desc'] != ''){
			return $duplicateSettings['seo_desc'];
		}
    }
    return $desc;
});

function product_dup_vars($string){
    global $product; if ( ! is_object( $product)) $product = wc_get_product( get_the_ID() );
    $string = str_replace('%productTitle%', $product->get_name(), $string);
    return $string;
}


add_filter( 'wpseo_sitemap_index', function() {
	global $wpdb;
	$regions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE url != ''");
	$sitemap_custom_items = '';
	foreach($regions as $region){
		$post_sitemap = home_urlm("/product-sitemap.xml", $region);
		$page_sitemap = home_urlm("/product_cat-sitemap.xml", $region);
		$category_sitemap = home_urlm("/product_tag-sitemap.xml", $region);
		$date = date('c');
		$sitemap_custom_items .= "
		<sitemap><loc>{$post_sitemap}</loc><lastmod>{$date}</lastmod></sitemap>
		<sitemap><loc>{$page_sitemap}</loc><lastmod>{$date}</lastmod></sitemap>
		<sitemap><loc>{$category_sitemap}</loc><lastmod>{$date}</lastmod></sitemap>
		";
	}
	return $sitemap_custom_items;
});

add_filter( "wpseo_sitemap_product_content", function( $var ) {
    $links = '';
    $products = get_posts([
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);

    foreach($products as $product){
        $duplicates = get_field('duplicate_pages', $product->ID);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                $date = get_the_modified_date('c', $product);
                $thumbanil = get_the_post_thumbnail_url($product->ID);
                $link = home_url("/kupit/{$duplicate['duplicate_page_slug']}/");
                $links .=
                "<url>
        		    <loc>{$link}</loc>
            		<lastmod>{$date}</lastmod>
                    <image:image>
            			<image:loc>{$thumbanil}</image:loc>
            			<image:title><![CDATA[{$product->post_title}]]></image:title>
            		</image:image>
            	</url>";
            }
        }
    }
    return $links;
}, 10, 1 );


add_filter( "wpseo_sitemap_product_cat_content", function( $var ) {
    $links = '';
    $categories = get_categories([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);


    foreach($categories as $category){
        $duplicates = get_field('duplicate_pages', $category);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                $date = new DateTime(get_term_meta($category->term_id, 'term_modified_gmt', true), new DateTimeZone('Europe/Moscow'));
                $date = $date->format('c');

                $link = home_url("/kupit/cat/{$duplicate['duplicate_page_slug']}/");
                $links .=
                "<url>
        		    <loc>{$link}</loc>
            		<lastmod>{$date}</lastmod>
            	</url>";
            }
        }
    }


    return $links;
}, 10, 1 );


add_filter( "wpseo_sitemap_product_tag_content", function( $var ) {
    $links = '';
    $tags = get_categories([
        'taxonomy' => 'product_tag',
        'hide_empty' => true,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'duplicate_pages',
                'value'   => '',
                'compare' => '!='
            ],
            [
                'key'     => 'duplicate_pages',
                'compare' => 'EXISTS'
            ]
        ]
    ]);

    foreach($tags as $tag){
        $duplicates = get_field('duplicate_pages', $tag);
        if( !empty($duplicates) ){
            foreach($duplicates as $duplicate){
                $date = new DateTime(get_term_meta($tag->term_id, 'term_modified_gmt', true), new DateTimeZone('Europe/Moscow'));
                $date = $date->format('c');
                $link = home_url("/kupit/brand/{$duplicate['duplicate_page_slug']}/");
                $links .=
                "<url>
        		    <loc>{$link}</loc>
            		<lastmod>{$date}</lastmod>
            	</url>";
            }
        }
    }

    return $links;
}, 10, 1 );
