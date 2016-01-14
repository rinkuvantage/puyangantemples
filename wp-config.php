<?php @ob_start();
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'puyangan');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '?mil#?=Rhl5Y&c>Y+oa+T7@3]j6MXDG?zvAglE;+Dhw#^41Tw4|*~l&@mkZT]&-{');
define('SECURE_AUTH_KEY',  'SVbHz8=g-i&+ nMi blY(c`GT(gzQ_w(9he.y,|t>>7A*0bR8 #KI|ubI6.rTEEu');
define('LOGGED_IN_KEY',    'Nig}zuUK4*I84EC#CTYKm#kWdtg=PBfouSP>xpVatAW?Kd<p=-(a`=}H!:^D]nh%');
define('NONCE_KEY',        '_7)G-Q;2q^hIUmEr#3}.g?yO>.-Q28v|][m:76It/mia?c9dvrbg51N6r|MFnF/-');
define('AUTH_SALT',        'B22W<9Bb}@&@rVBzCR+f!(Foo+:i~1(rW?%K#d@x6d!]. &v`9ehV)<xKp>ke+~+');
define('SECURE_AUTH_SALT', 'WkHB4*3PMc[QHSM.|pV&6[:u3kJ(VQlG[*cQF#BoB$3|96ew^6>UwF|o%bht, W:');
define('LOGGED_IN_SALT',   '`&8:IyhQtOGjovV>g2puhZ3GMs7UOUIc>-HBwKVnuq7V$nh>^*=?>JozX8Cer[et');
define('NONCE_SALT',       '9T,C|ua6(g@iV4zZHT*FI/tmGnx16?%V/|OXV0r!DrR$[?-.A%*g-:enEPS@MWl8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pg_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
