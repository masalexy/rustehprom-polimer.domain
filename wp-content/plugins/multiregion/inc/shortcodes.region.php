<?php
function multiregion_shortcodes(){
    global $labels;
    echo "<h2>Шорткоды</h2>";
    echo "<table class='shortcodes-table' border='1'>";
        echo "<tr>";
            echo "<td>Меню со списком городов</td>";
            echo "<td>[multiregion_list]</td>";
        echo "</tr>";
    foreach($labels as $key => $label){
        echo "<tr>";
            echo "<td>{$label}</td>";
            echo "<td>[multiregion param='{$key}']</td>";
        echo "</tr>";
    }
    echo "</table>";
}



add_shortcode('multiregion', function ( $atts ) {
    global $region_key, $wpdb;
    $atts = shortcode_atts( array(
		'param' => 'name',
		'html' => 'true'
	), $atts );

    $region = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE url = '{$region_key}' ")[0];
    $default_region = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE url = '' ")[0];

    if(property_exists($region, $atts['param']) && $region->{$atts['param']} != ''){
        return multiregion_shortcode_filter($atts['param'], $region->{$atts['param']}, $atts['html']);
    }else{
        return multiregion_shortcode_filter($atts['param'], $default_region->{$atts['param']}, $atts['html']);
    }
});


add_shortcode('multiregion_list', function() {
    global $region_key, $wpdb, $wp;
    $regions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions ORDER BY id");
    $home_url = 'rustehprom-polimer.ru';

    $list = "<ul>";
    foreach($regions as $region){
        $active = ($region->url == $region_key) ? 'active' : '';

        if($region->url_type == 1){
            $link = "{$region->url}.{$home_url}/{$wp->request}/";
        }else{
            $link = "{$home_url}/{$region->url}/{$wp->request}/";
        }
        $link = explode('/', $link);
        $link = array_filter($link);
        $link = 'https://' . join('/', $link) . '/';
        $list .= "<li class='region-item {$active}' data-search='{$region->name}'><a href='{$link}'>{$region->name}</a></li>";
    }
    $list .= "</ul>";
    return $list;
});

function multiregion_list(){
    echo do_shortcode('[multiregion_list]');
}

function multi_link($link){
    return home_url($link);
}

function multiregion_shortcode_filter($type, $value, $html = true){
    global $region_key;
    if($html == 'false'){
        return $value;
    }
    if($type == 'phone'){
        $class = ($region_key == '') ? 'comagic_phone' : 'comagic_phone_'.$region_key;
        return "<a href='tel:{$value}' class='{$class}'>{$value}</a>";
    }elseif($type == 'email'){
        return "<a href='mailto:{$value}'>{$value}</a>";
    }
    return $value;
}

function home_urlm($url, $region = false){
    global $region_obj;
    if($region) $region_obj = $region;

    if($region_obj->url_type == 1){
        $link = "https://{$region_obj->url}.".REGION_ROOT."{$url}";
    }else{
        $link = "https://".REGION_ROOT."/{$region_obj->url}/{$url}";
    }
    return $link;
}
