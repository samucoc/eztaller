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
define('DB_PASSWORD', '15829807vanesamito');

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
define('AUTH_KEY',         'k+h76IatqY3s7F43@Mgv,5qhA5sv;-sYOE_Us3M)75:F|+@ahiV[jb-F!ChQ@12a');
define('SECURE_AUTH_KEY',  '@/[G91-n($xFSv9lfshnSl~1xR(ItJ8=s<ZiACk/2I~k9*($_=|>-epvEG.yi}Y:');
define('LOGGED_IN_KEY',    'R06~}Z#AQf?)xhiV=8;aQgK!o`Ym#6sNj6;1ik/z&Eg!m.rjfi;{|aV}/v,3R,c<');
define('NONCE_KEY',        '|_XRDYg$v d{k%,r*Pk8vL=/UXo0<$zUrLUBD?EmYO#*n<o_J?o6rg/]fra4U@/(');
define('AUTH_SALT',        '4&:MzMqY(Rm.V;5=}0OUEZ>U2TMfM_8DD)YR$J~}qu{357gESF..|!E@1b_J^ a/');
define('SECURE_AUTH_SALT', 'XY/ghng1D#ghsz:f`e0ac<<}nc-a~G{vhLO.vG 6UEhV|=ypc)_1S+>p^,aL4GqU');
define('LOGGED_IN_SALT',   '9*-RhHdO]e?;a06q`1.k7gl-yQX$QB3f4pY2BY5!^pz$%5 n:QlF5@hD.9mQ_J22');
define('NONCE_SALT',       'pGC-{qD<k3wf*r_R(*16G(A>s))=8x5@/J>U,.V*N_Gq?l3#DtRjidIFG?Z3+hx:');

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
