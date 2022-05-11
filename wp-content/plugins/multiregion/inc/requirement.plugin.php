<?php function multiregion_requirement(){ ?>
<h2>Требование плагина</h2>

<h4>1. Замените код  .htaccess</h4>
<textarea class="code-section" readonly>
# BEGIN WordPress
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]

# uploaded files
RewriteRule ^([_0-9a-zA-Z-]+/)?files/(.+) wp-includes/ms-files.php?file=$2 [L]

# add a trailing slash to /wp-admin
RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule  ^[_0-9a-zA-Z-]+/(wp-(content|admin|includes).*) $1 [L]
RewriteRule  ^[_0-9a-zA-Z-]+/(.*\.php)$ $1 [L]
RewriteRule . index.php [L]
# END WordPress</textarea>


<h4>2. Добавьте код в конце файла wp-config.php</h4>
<textarea class="code-section small" readonly>
/* Multiregion Settings */
global $wpdb, $region_key;
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$subDirectory = ($requestUri === false) ? '/' : explode('/', $requestUri)[1];
$region_key = '';
$tableExists = $wpdb->get_results("SHOW TABLES LIKE '%multiregions%'");
if( $tableExists ) {
	$region = $wpdb->get_results("SELECT url FROM {$wpdb->prefix}multiregions WHERE url = '{$subDirectory}' ");
	if( !empty($region) ){
		define("WP_SITEURL", "https://{$_SERVER['HTTP_HOST']}/{$subDirectory}/");
		define("WP_HOME", "https://{$_SERVER['HTTP_HOST']}/{$subDirectory}/");
		$region_key = $subDirectory;
	}
}
/* End Multiregion Settings */</textarea>

<a href="/wp-admin/admin.php?page=multiregion" class="requirement-complete"> <span class="dashicons dashicons-yes"></span> Я выполнил требование</a>

<?php } ?>
