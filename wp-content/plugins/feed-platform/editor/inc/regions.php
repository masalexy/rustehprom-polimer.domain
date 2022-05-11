<?php
global $wpdb, $def_socr, $all_regions;
$all_regions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions");
$def_socr = $all_regions[0]->region_id;
echo "<div class='select-item'>Выберите город:";
echo "<select name='socr' id='region_form'>";
foreach($all_regions as $region){
    $selected = (isset($_GET['region_id']) && $_GET['region_id'] == $region->id) ? 'selected' : '';
    $id = ($region->url != '') ? $region->id : '';
    echo "<option value='{$id}' {$selected}>{$region->name}</option>";
}
echo "</select>";
echo "</div>";
