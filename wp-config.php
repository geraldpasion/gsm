<?php
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
define('DB_NAME', 'gsm');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'xktd&vu-HAc5vFM;#9F%pvjjV_bOntgSN*j;@;ET_htUG,37j,^/A/Q&O 9H}.hv');
define('SECURE_AUTH_KEY',  'B7nQ6B:+8;1SRZ0UZ~N#^*E-v``wYP]U|EE`jf[ky{98d=U#ea~M,G|l8Q-w8xbs');
define('LOGGED_IN_KEY',    'l~8`+-^G)OyN Ai+B%*=%tW^aY70UpNz;@rVueJAK]oG-qrEhya%NLaVhf|g,j<l');
define('NONCE_KEY',        'iOSyIZ9kcz(l~n:`=!vHufT4GEuz^-E<Ncw9`zk2n/|v7Q-4.tl;BGnK)-y(6-.3');
define('AUTH_SALT',        'pK==0FvH0qg6N)N?BU%d ni0z^`rg}!u}EgRS2}//kHE~)8$=-05Q/xd0`$mQ~-s');
define('SECURE_AUTH_SALT', '(R~OA@$(^Il?Q[QtQh#Bcr~TKM^/4:9gE.aR-NX$WS?W1v} DT:}}vUIWH!`Dm.b');
define('LOGGED_IN_SALT',   '19Xg9DD)R.G-Pz:Z.$SdMn+b3S,6?ppthr.R$_*/m2#OYlBn7tP9V.-P.=i|at9>');
define('NONCE_SALT',       'igO@7va!Q.F)lug[yX-g=9ek2n,]R@p(k0$%2o9ucT+Mg3`>,EieF4.V/2zJh@/O');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
