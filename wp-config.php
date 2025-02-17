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
define('DB_NAME', 'db_wordpress');

/** Database username */
define('DB_USER', 'fenicfelix');

/** Database password */
define('DB_PASSWORD', 'Lexie@#14');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'InhkW[ol8%b+%2&h=]cL7.zEQq4T-i|B`7!w:uBp^^vaeAWv;E+M]ax 2z;k/XxE');
define('SECURE_AUTH_KEY',  'g9J@.U#N:mE?<aK`pDJH%b3#1+cqv.?I`M8lch*EhGIVW)j`83@<Xz 3:J|O9eH}');
define('LOGGED_IN_KEY',    '/JH.oOv.Hp{2}%qQoZJDeqtm+ePuj4yF a[b)mu3{=NCXkkN1F9=[^LsumHq)d+J');
define('NONCE_KEY',        'XB^wL+kT]XL.jU/uBW;:ut:$jX7DOg.<w`>[rOQQ0n3nW]#GBByA0vnWb]nj?xY ');
define('AUTH_SALT',        '.W4T$NT{`}7tSr$yg(YnGztVzCKg= Q;Sft+j<ZQ:vcn`ueb&[X=B>|{p?mg6$c/');
define('SECURE_AUTH_SALT', 'E/u8 2j5w* )<rci:af/RVgAAKKhYWRque?na5ZFqtv6Sd*JD=?X/+UNXmS*8apW');
define('LOGGED_IN_SALT',   'c`pp5mGG/YtgtucI?)Mw8)P<=p&xf@MJ&G>TA<jn}?+pT_7r m{G0O%VPND7[:*C');
define('NONCE_SALT',       '{^DJqyi]X3K_rM5@BTSPY1HJ2itx4~!:+!Tg^HR4sB+x1&u{|Le,UPh;&-;{n`I)');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('DISALLOW_FILE_EDIT', true);
