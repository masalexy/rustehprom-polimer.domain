<?php
global $wpdb;
$regions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions");
echo "<div class='regions'>Выберите город:";
echo "<select name='region_id' id='region_form'>";
foreach($regions as $region){
    $selected = (isset($_GET['region_id']) && $_GET['region_id'] == $region->id) ? 'selected' : '';
    $id = ($region->url != '') ? $region->id : '';
    echo "<option value='{$id}' {$selected}>{$region->name}</option>";
}
echo "</select>";
echo "</div>";
