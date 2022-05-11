<?php
$uri = explode('/', $_SERVER['REQUEST_URI']);

if( in_array('pricelist', $uri) ){
    new DJVirtualPage(array(
    	'slug'	=> 'pricelist',
    	'type'	=> 'page',
    	'title'	=> 'pricelist',
        'template' => __DIR__ . '/template.php'
    ));
}
