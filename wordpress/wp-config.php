<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         ')3g^.YBCFkSr9/B#l+v>a;@ND#tXM I#*K&)D<(Y+_K8t>9~pyz_ORP5(^v`++gy' );
define( 'SECURE_AUTH_KEY',  'gw;m: mP,Z0M3.^ bMD-&kG--f>?gzS&Vt$Be|.YN{h!ibq}%2ws$hhfs*id8Q[J' );
define( 'LOGGED_IN_KEY',    ';p?)-/w)8NS?#G>J;:z.yjQ,RiSpGWv;M(8,s`U?5wvZS_WA]eec382j~q{`Nu2$' );
define( 'NONCE_KEY',        'u4 43j5)KygGz,YZWH6v)Pt.-p;(+JC;>%jJiFE1($bPd%- mK{V~-}XQ{9.Tovd' );
define( 'AUTH_SALT',        'o&)7QbeBf;U/^qN=U(qF/&tP1Qt%I+h~P`)yI}ZZJ?ALIv)/wI[OT`}<_I[2l[kZ' );
define( 'SECURE_AUTH_SALT', 'i{!aP:_X;tc<%r!-<^Sfq[?IRyW1w)E1.|1I<F0F@n,flO+L?QD=5:R[0.B6`]_f' );
define( 'LOGGED_IN_SALT',   'YydRn{C~,!(8X0>arvT:QOr^u^+:1gsQl2F7> E+(S>BhY:5u=]=mVJA6]kNZ S6' );
define( 'NONCE_SALT',       'zz%Jo9~}. h*?9+<$I|L_*(ze1Au%f1?jnp0`__#53fhxQ;ig51DaUci[1)0w*b>' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
