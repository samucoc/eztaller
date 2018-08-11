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
define('DB_NAME', 'eztaller_web');

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
define('AUTH_KEY',         'Aw{]ghiY,x^-E$i;o3M(Gy6`pNb~_COtsd@EC[NWR&=UndVG^]sfqB|>%_(~Tqc+');
define('SECURE_AUTH_KEY',  'SK>Aei4xLTJ7o1cT37@)La9f0GmOb_PDQ<hf%E:_hDVxbE>{ylX;7el0.BCNpmOS');
define('LOGGED_IN_KEY',    'kL|lcP#a<;n9|#}O:Ukh:EhA#;ko81M~C;)88z=h3$ <)%5wtktPfKSg<3cjjx&x');
define('NONCE_KEY',        'G>/V+RS3K tItQ}BXJ!U9uuR&x6uaFQvmLJ$7,qDRk!T;P$nnP.{8)(Qn$-2A78J');
define('AUTH_SALT',        '-Ff<%~4/$+F; 4[)} v<TIF#ozn[@vFM7^3)UB!YM A.Xj|:0OD1GpC$hkBU*Nk2');
define('SECURE_AUTH_SALT', 'Y-M#r+,/{ZV;v$o,39!{ 4LIx*5brb]gxJd&?I3A4Oi//CN|0$IFsRpnnu=WRyuE');
define('LOGGED_IN_SALT',   'd>2AFeo>h;;~8DHe/G*(n1d,5gDJud+K9a?-S>$5qH~4u/Kt6*>&F<.d^lVNjcxp');
define('NONCE_SALT',       'aA8{mF)!->>E0LGZNU*J:?[<0{2j:./^HLW0X4n{hN;`(NeTeL36iqeetK8v/^mH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ez_';

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
