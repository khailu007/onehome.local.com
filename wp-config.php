<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'khachhang_wp_onehome' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'd@t@base' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3316' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'SCfej.9KCfDk0u`MqBZJv*f[?0G<nz%^1Z{4U-%9-|-I~R8jMzau&Qz#g]%tvUf}' );
define( 'SECURE_AUTH_KEY',  'AjLt.7j_}8+edTru8@Q?S?hj(DuU+U7~K*EAbpd.2bzYg6ZzZJ3h]u79]F&]*w` ' );
define( 'LOGGED_IN_KEY',    '4EFaiAPtB(G/n2[gpRP{c^qZ$f?S`44#BK@x41/0daH-9iSX=bN+GGo.sY)>WLcW' );
define( 'NONCE_KEY',        '.Wby06VbBB<5v$ FUL)-veutat&]R+cdRS:N(D@*8&D9Dxsy3mb~ZTu30W|)pf4,' );
define( 'AUTH_SALT',        'vb(,V4_fW2L-+>%1UT-?_~O~jrekC52UlBPR:Qs=*uN=OesmaCsaZ$2|93zRG#C5' );
define( 'SECURE_AUTH_SALT', '0b?.~XkzIl]sFGE(]ARr^A#a/<Ks b#0p@rdh//WJW:z_IJ?AjQlG`&cY4q~g/De' );
define( 'LOGGED_IN_SALT',   'OQ8fh#M`r^fYd_:`t~*_e1O<v ~?E*PyN!,sb_~Re(%pN22poW;95)_LS4`A*H61' );
define( 'NONCE_SALT',       'Uls_u@Ha*g;k}[}NEbK2rv4g!DtU!:*@eyo)(a{Jmni^L@Z}ch9nG-NC`jU(&DYF' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
