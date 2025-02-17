<?php
define( 'WP_CACHE', true ); // Added by WP Rocket
define( 'WP_ROCKET_EMAIL', 'vendors@thekenyatimes.com');
define( 'WP_ROCKET_KEY', '11fe480b');
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
define( 'DB_NAME', "a0v.5ee.mywebsitetransfer.com_1655166265" );
/** MySQL database username */
define( 'DB_USER', "5cf4e6a4a5" );
/** MySQL database password */
define( 'DB_PASSWORD', "W.eAX47wINXf5Qee2Ci77" );
/** MySQL hostname */
define( 'DB_HOST', "localhost:3306" );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ACgE2Zh5EEsFnm3vhkIySbQ9cBKzH6vTsU3ViVPL0E3GxvXh3Ci8fLT8rlT7EEXq');
define('SECURE_AUTH_KEY',  'rbFwZOnPB4Yt5GGAmINr3LFFVPDFqjxFSMtG7ZXQ4OTeWh31EOMDtoQ8xWKB0zNE');
define('LOGGED_IN_KEY',    'qaA07sld1AQg2hATUYIvB2JXNu01ZvrlwCUlX9sB1xeMVm6Z6wqlCmJL8Dip6ntY');
define('NONCE_KEY',        'RIZh2xsq9OiLUL3rXyev0eakLvPvMDkzqzVTAutWDVodL1LwVogooXBXf9DajIbs');
define('AUTH_SALT',        'XigFRCK8BiYKRIyqf4KlUKwawMdl4ny9oDIXBJZlMJrI4GyuEx0cJ3mpkongg7U0');
define('SECURE_AUTH_SALT', 'BAGvqmEWW0WzL3lFAb9oZw40R2429hCo7rLzFjdVR6T0LExc0R173mpL7Xk73h4p');
define('LOGGED_IN_SALT',   'Fia8Oy4WuaScgRpS6MzDwezvJtA4Ua3pdlojvbERlI4WJ87aRmqPgxpmRKR9B6m1');
define('NONCE_SALT',       'VZhqIk2yVptS3BinYyNXDnZ2nKJLnsqBvogwyYd0iz4wrhQXjBLyVAogalZugPTA');
/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');
/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'y6ilo_';
define('DISALLOW_FILE_EDIT',true);
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
/** Change Memory Limit to 256
ini_set('memory_limit','256MM')