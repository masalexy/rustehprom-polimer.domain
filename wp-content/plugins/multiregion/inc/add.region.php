<?php
function multiregion_add_page(){
    if( isset($_POST['region']) ){
        $_POST = array_map('stripslashes_deep', $_POST );
        insert_region( $_POST['region']);
    }

    global $labels, $fieldTypes;
    echo "<form action='/wp-admin/admin.php?page=multiregion_add_page' method='post' class='region-form'>";
    echo "<h2>Добавить город</h2>";
    echo "<table class='region-table'>";
    foreach($labels as $key => $value){
        if($key == 'id') continue;
        $input = get_field_content($key, $fieldTypes[$key]);
        echo "<tr>";
            echo "<td>{$labels[$key]}</td>";
            echo "<td>{$input}</td>";
        echo "</tr>";
    }
        echo "<tr>";
            echo "<td></td>";
            echo "<td><button class='region-button'>Добавить</button></td>";
        echo "</tr>";

    echo "</table>";
    echo "</form>";
}

function insert_region($region){
    global $wpdb;


    $result = $wpdb->insert(
    	$wpdb->prefix.'multiregions',
    	$region,
    	[
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    		'%s',
    	]
    );

    if($result){
        echo "<div class='region_added'>Город успешно добавлен. <b><a href='/wp-admin/admin.php?page=multiregion'>Посмотреть</a></b> </div>";
    }

}
