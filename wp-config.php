<?php
error_reporting(0);
@ini_set('display_errors', 0);
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'polimer_pol2019' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_MEMORY_LIMIT', '64M' );

define('DISALLOW_FILE_EDIT', true);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '&`Gc;n)0I#J<EqL}|G-Wj%S~XfHK2[a()vOe-+lId.M&caD1o7Jgtl7o`Mj0}L|p' );
define( 'SECURE_AUTH_KEY',  'ihLy4pxTYDk6.=OHa/d3qX.,jOv0SyT}7={CTSDm]C%0%6UxyGNdfY4;Xd^(n?{1' );
define( 'LOGGED_IN_KEY',    'VtUk^<Fr!r5So}%ie18]:zD>H0f7LxOyAkSmw:b8ivpejRA>xU==oAKAPdE-[iGG' );
define( 'NONCE_KEY',        '&v=F%vTmXR2d#9geiTve.jz$ypMQ?a* osAVdqdM4(VU^:Yk#HPZusPm;,H28ZOc' );
define( 'AUTH_SALT',        'f{a&?/y9aG{Drz*!S)dlX6V oIhPNUcrSl31oVcehT^o;_glDfgyn0<JO(t~okuV' );
define( 'SECURE_AUTH_SALT', 'H.NK08~>s@r:Rhb^+rJdTr}il.vi0_8p*A?WHQ-jk4a$sZZ0IpwLb!XXlhNB*xP9' );
define( 'LOGGED_IN_SALT',   '$LGFoflzwuk,=b8FQMJbE6WT6jJ(7U.m(!l(jS|-VlmJiE<#$j ijp0-WqQM&IiS' );
define( 'NONCE_SALT',       'JUT136H8o/M%:U8Mm->{os!oHrV7z+$?0.S~x^q;Jl9@vx;1{Fp^=Ry&T0C_k)~9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'hwxo_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );



/* Multiregion Settings */
define('REGION_ROOT', 'rustehprom-polimer.domain');
global $wpdb, $region_key, $region_obj;
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$subDirectory = ($requestUri === false) ? '/' : explode('/', $requestUri)[1];
$subdomain = explode('.', $_SERVER['HTTP_HOST']);
$subdomain = (count($subdomain) == 3) ? $subdomain[0] : false;
$subDirectory = ($subdomain) ? $subdomain : $subDirectory;

$region_key = '';
$tableExists = $wpdb->get_results("SHOW TABLES LIKE '%multiregions%'");
if( $tableExists ) {
	$region_obj = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE url = '' ")[0];
	$region = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}multiregions WHERE url = '{$subDirectory}' ");
	if( !empty($region) ){
        $region = $region[0];
        if($region->url_type == 0){
            define("WP_SITEURL", "https://{$_SERVER['HTTP_HOST']}/{$subDirectory}/");
    		define("WP_HOME", "https://{$_SERVER['HTTP_HOST']}/{$subDirectory}/");
        }else{
            define("WP_SITEURL", "https://{$_SERVER['HTTP_HOST']}");
    		define("WP_HOME", "https://{$_SERVER['HTTP_HOST']}");
        }
		$region_key = $subDirectory;
        $region_obj = $region;
	}else{
        define("WP_SITEURL", "https://{$_SERVER['HTTP_HOST']}/");
		define("WP_HOME", "https://{$_SERVER['HTTP_HOST']}/");
    }
}
/* End Multiregion Settings */
