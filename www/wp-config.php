<?php

// Composer autoloader
require dirname( __FILE__ ). '../../vendor/autoload.php';

// Load our .env file to get all our settings
try {
	Dotenv::load( dirname( __FILE__ ). '/../' );
}
catch( Exception $e ) {
	// If the .env file is missing, die without giving away to much info - but with a
	// reference to this part of the file so the confused developer will find it's way - HI!
	echo "Configuration is not completed for this installation (ref: " . basename( __FILE__ ) . ", line ".__LINE__ . ")\n";
	die;
}

Dotenv::required( array( 'DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_CHARSET', 'DB_COLLATE', 'SITE_HOSTNAME', 'DB_PREFIX' ) );


// =======================================
// Custom Content Directory & Hostname
// =======================================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . getenv( 'SITE_HOSTNAME' ) . '/content' );

define( 'WP_HOME', 'http://' . getenv( 'SITE_HOSTNAME' ) );
define( 'WP_SITEURL', 'http://'.getenv( 'SITE_HOSTNAME' ) );
define( 'DOMAIN_CURRENT_SITE', getenv( 'SITE_HOSTNAME' ) );


// ========================
// Database settings
// ========================
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'DB_HOST' ) );
define( 'DB_CHARSET', getenv( 'DB_CHARSET' ) );
define( 'DB_COLLATE', getenv( 'DB_COLLATE' ) );
$table_prefix  = getenv( 'DB_PREFIX' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define( 'AUTH_KEY',         'f=gmDGq6L.K]jF<.TmlSSJc0Lj.fU{dF|W-2|1%W4G6xy2+f9!m$p:.?Cv8#zE7b' );
define( 'SECURE_AUTH_KEY',  ':<6J2D)_AASe6YV0V-Z>!`chl(e_V6nvn5ifEU.W<Kr|$MPp5B_+d&ku<SATu%j|' );
define( 'LOGGED_IN_KEY',    'dq-E5@F-6#8wA<3D6_pgRr#EK*]j^%CBvaZu,@E]O.&Z (Ko$-$7rW8?}Lt!_*wI' );
define( 'NONCE_KEY',        '{gv`t{!b7;?f |v;:gU+!^^+ADN8+A(hy1J*L+gEisN,-5Up~8VHh}>+F>|NZVbw' );
define( 'AUTH_SALT',        '#w$*}<c@DUghBKC -D-vJGx.5`SsF,_K{adFCT.xdX}BNHYtw/|/(*Z:L!JJQdRI' );
define( 'SECURE_AUTH_SALT', 'vXw>z^/|b#+n~c/6O`Yu|$,?5f04^<StxdhGmd0=o9{` XE5}DF4{@>U=;=YJw@8' );
define( 'LOGGED_IN_SALT',   '}wV166,+hPH|,zbPt+QCmgkRI+4wb8re)$8J{&v8G5f?_O}WSX`I CrU6dB*9Gw#' );
define( 'NONCE_SALT',       'UQ50#wEI1zeG [KtHq93=uhjZQTd}VWhLs^x0]OXd3{%3DR+p`h3+=C1=i~V-{:R' );


#define( 'UPLOADS',  WP_CONTENT_DIR  . '/media' );
#define( 'UPLOADS',   '/home/vagrant/uploads' );

# API keys 

define("GF_LICENSE_KEY", "a16a82a55a7c3c2e4e42ecca85229f5d");
define('WPCOM_API_KEY','16320ff67db1');


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define( 'WP_DEBUG', false );

// Always go SSL on prod if we have Cloudfront enabled
if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
       define('FORCE_SSL_ADMIN', true);
       $_SERVER['HTTPS']='on';
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
//if ( !defined('ABSPATH') )
// define('ABSPATH', dirname(__FILE__) . '/');

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );



/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
