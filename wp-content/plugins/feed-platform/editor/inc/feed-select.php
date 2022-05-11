<?php
global $def_feed, $feed_labels;
$feeds = get_field('feed-platforms', 'option');
$def_feed = $feeds[0]['feed-id'];
echo "<div class='select-item'>Выберите фид:";
echo "<select name='feed-id' id='feed_form'>";
foreach($feeds as $feed){
    $selected = (isset($_GET['feed-id']) && $_GET['feed-id'] == $feed['feed-id']) ? 'selected' : '';
    echo "<option value='{$feed['feed-id']}' {$selected}>{$feed['feed-slug']}</option>";
    $feed_labels[$feed['feed-id']] = $feed['feed-slug'];
}
echo "</select>";
echo "</div>";
