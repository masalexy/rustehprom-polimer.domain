<?php
function multiregion_update_page(){
    if( isset($_POST['region']) ){
        $_POST = array_map('stripslashes_deep', $_POST );
        update_region( $_POST['region'], $_POST['region_id'] );
    }

    if( !isset($_GET['region_id']) ){
        echo "<div class='region-not-exists'>Город не существует</div>";
        return;
    }

    global $wpdb, $labels, $fieldTypes;
    $region_id = $_GET['region_id'];
    $region = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE id = '{$region_id}' ")[0];



    echo "<form action='/wp-admin/admin.php?page=multiregion_update_page&region_id={$region_id}' method='post' class='region-form'>";
    echo "<h2>Редактировать город: {$region->name}</h2>";
    echo "<table class='region-table'>";
    foreach($region as $key => $value){
        if($key == 'id') continue;
        $input = get_field_content($key, $fieldTypes[$key], $value);
        echo "<tr>";
            echo "<td>{$labels[$key]}</td>";
            echo "<td>{$input}</td>";
        echo "</tr>";
    }
        echo "<tr>";
            echo "<td><input type='hidden' name='region_id' value='{$region->id}' /></td>";
            echo "<td><button class='region-button'>Обновить</button></td>";
        echo "</tr>";

    echo "</table>";
    echo "</form>";
}

function update_region($region, $id){
    global $wpdb;

    $result = $wpdb->update(
    	$wpdb->prefix.'multiregions',
    	$region,
    	['id' => $id],
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
    	],
    	['%d']
    );

    if($result){
        echo "<div class='region_added'>Город успешно обновлен.</div>";
    }
}
