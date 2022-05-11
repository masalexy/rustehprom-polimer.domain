<?php
add_filter( 'template_include', function($template){
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    $xmlFeeds = get_option('multiregion_xml_feeds');

    if($xmlFeeds && array_key_exists('name', $xmlFeeds) ){
        $feeds = $xmlFeeds['name'];
        foreach($feeds as $i => $feed){
            $xml_name = $feed.'.xml';
            $xml_utm = $xmlFeeds['utm'][$i];
            $xml_template = __DIR__ . '/feeds/'. $xmlFeeds['controller'][$i];
            if( in_array($xml_name, $uri) && file_exists($xml_template) ){
                if($xml_utm != '') $_GET['xml_utm'] = $xml_utm;
                return $xml_template;
            }
        }
    }

	return $template;
}, 99 );

add_action( 'admin_menu', function(){
    add_submenu_page( 'multiregion', 'Фиды', 'Фиды', 'manage_options', 'multiregion_xml_feeds', 'multiregion_xml_feeds');
});

function multiregion_xml_feeds(){
    echo "
        <link rel='stylesheet' href='/wp-content/plugins/multiregion/modules/xml/assets/style.css?v=6' />
        <script src='/wp-content/plugins/multiregion/modules/xml/assets/main.js?v=6'></script>
    ";

    if( isset($_POST['xml-feed']) ){
        update_option('multiregion_xml_feeds', $_POST['xml-feed']);
    }
    $xmlFeeds = get_option('multiregion_xml_feeds');

    $feeds = scandir(__DIR__ . '/feeds/');
    $feeds = array_diff($feeds, ['.', '..']);
    function get_controller($feeds, $def_value = ''){
        $controller = "<select name='xml-feed[controller][]'>";
        foreach($feeds as $feed){
            $label = str_replace('.php', '', $feed);
            $selected = ($def_value == $feed) ? 'selected' : '';
            $controller .= "<option value='{$feed}' {$selected}>{$label}</option>";
        }
        $controller .= "</select>";
        return $controller;
    }

    $controller = get_controller($feeds);

    $feedItem = "
        <tr>
            <td> <input type='text' name='xml-feed[name][]' required /> </td>
            <td> <input type='text' name='xml-feed[utm][]' /> </td>
            <td> {$controller} </td>
            <td> <span class='dashicons dashicons-no removeFeed'></span> </td>
        </tr>
    ";
    $clonedFeedItem = $feedItem;

    if($xmlFeeds){
        $feedItem = "";
        foreach($xmlFeeds['name'] as $i => $item){
            $controller = get_controller($feeds, $xmlFeeds['controller'][$i]);
            $feedItem .= "
                <tr>
                    <td> <input type='text' name='xml-feed[name][]' required value='{$xmlFeeds['name'][$i]}' /> </td>
                    <td> <input type='text' name='xml-feed[utm][]' value='{$xmlFeeds['utm'][$i]}' /> </td>
                    <td> {$controller} </td>
                    <td> <span class='dashicons dashicons-no removeFeed'></span> </td>
                </tr>
            ";
        }
    }

    echo "
        <form method='post'>
            <table id='feed-items-table' border='1'>
                <thead>
                    <tr>
                        <td>Фид</td>
                        <td>UTM метка</td>
                        <td colspan='2'>Контроллер</td>
                    </tr>
                </thead>

                <tbody>

                {$feedItem}

                </tbody>

                <tfoot>
                    <tr><td colspan='4'> <span id='add-feed-item'><span>Добавить</span> <span class='dashicons dashicons-plus'></span></span> </td></tr>
                    <tr><td colspan='4'> <button id='save-feed-items'>Сохранить</button> </td></tr>
                </tfoot>
            </table>
        </form>
        <script>
            var clonedFeedItem = `{$clonedFeedItem}`;
        </script>
    ";
}
