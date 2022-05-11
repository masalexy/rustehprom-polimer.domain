<?php
global $labels, $fieldTypes;
$labels = [
	'name' => 'Название города',
	'url' => 'URL города',
	'url_type' => 'Тип',
	'name_ask' => 'Название города (на вопрос - где?;чему?)',
	'region' => 'Область',
	'phone' => 'Телефон',
	'email' => 'E-mail',
	'address' => 'Адрес',
	'grafik' => 'График работы',
	'head_scripts' => 'Скрипты перед &lt;/head&gt;',
	'body_scripts' => 'Скрипты в &lt;/body&gt;'
];

$fieldTypes = [
	'name' => 'text',
	'url' => 'text',
	'url_type' => 'select',
	'name_ask' => 'text',
	'region' => 'text',
	'phone' => 'tel',
	'email' => 'email',
	'address' => 'textarea',
	'grafik' => 'textarea',
	'head_scripts' => 'textarea',
	'body_scripts' => 'textarea'
];

require 'field.types.php';
require 'update.region.php';
require 'add.region.php';
require 'shortcodes.region.php';
require 'requirement.plugin.php';

// Добавим видимость пункта меню для Редакторов
add_action( 'admin_menu', function(){
	add_menu_page( 'Мультирегион', 'Мультирегион', 'edit_others_posts', 'multiregion', 'multiregion_page', 'dashicons-networking', 116 );
	add_submenu_page( 'multiregion_page', 'Редактировать город', 'Редактировать город', 'manage_options', 'multiregion_update_page', 'multiregion_update_page' );
	add_submenu_page( 'multiregion', 'Добавить город', 'Добавить город', 'manage_options', 'multiregion_add_page', 'multiregion_add_page' );
	add_submenu_page( 'multiregion', 'Шорткоды', 'Шорткоды', 'manage_options', 'multiregion_shortcodes', 'multiregion_shortcodes' );
	add_submenu_page( 'multiregion_page', 'Требование', 'Требование', 'manage_options', 'multiregion_requirement', 'multiregion_requirement' );
});

add_action( 'admin_enqueue_scripts', function(){
	wp_enqueue_style( 'multiregion_css',  plugins_url( '../assets/css/style.css', __FILE__ ), false, '1.1.0' );
	wp_enqueue_script( 'multiregion_js',  plugins_url( '../assets/js/main.js', __FILE__ ), false, '1.1.0' );
});

function multiregion_page(){
    global $wpdb;
    $regions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions");
    echo "<input type='search' class='search-region' placeholder='Введите название города' />";
    echo "<a href='/wp-admin/admin.php?page=multiregion_add_page' class='add-region-button'> <span class='dashicons dashicons-plus'></span> Добавить</a>";
    echo "<ul class='region-list'>";
    foreach($regions as $region){
		$default = ($region->url == '') ? '<span>Основной</span>' : '';
        echo "
            <li class='region-item' data-search='{$region->name}'>
                <span class='region-name'>{$region->name}</span>
				{$default}
                <a href='/wp-admin/admin.php?page=multiregion_update_page&region_id={$region->id}' class='region-edit'> <span class='dashicons dashicons-edit'></span> </a>
            </li>";
    }
    echo "</ul>";
}
