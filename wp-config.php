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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'spraga_db' );

/** Database username */
define( 'DB_USER', 'spraga_user' );

/** Database password */
define( 'DB_PASSWORD', '91p(]la&PON$^BvG' );

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
define( 'AUTH_KEY',         'omi+u=WU$DsfWIi ?NDvxJD0_dE2CU;JJEkebbr7Kff!,]`BYs!s~]A&#5])LCG9' );
define( 'SECURE_AUTH_KEY',  'NhN@a-tVjeFVqfs>=Wb$(2+I*BHLn]c(GwMOkq<=fZc8qD`P}%iWEpeV-~,f+iKe' );
define( 'LOGGED_IN_KEY',    '.8^7u3C?W{oonqAoJOrA!TR*|Y|d6P2qoX4]2`wsa F60673Kq=Ymw48]*qckkHv' );
define( 'NONCE_KEY',        'F|e84fhC[G_)?7IyzU}c/w=V6dG%~v?v:K}nE^}O]W1^9ilM_pY|/fPk$XiN<TA[' );
define( 'AUTH_SALT',        'sJFqYE+x4PxEZHE@r;41XZ;Mlu0G2g.{uhMZ;b1{[KrLtl9`Ct_TQ_HvTXcw]oj2' );
define( 'SECURE_AUTH_SALT', 'q?Ay*6sc+iJD|Y9XIyms7${MbnMUv02MYW{Jbx.T+]9KPLS*SV:%G}eXgP-@Rxx>' );
define( 'LOGGED_IN_SALT',   'o&Y3p50Gx>?<og{*ESVkY-pE18CHj7HLZGknV&k7)XC+$_W~;}+5cKMt9Ga*QWsc' );
define( 'NONCE_SALT',       'Z:qjt:Dho8gvX;kp:8l 95UN7FJy2yAFh?}gY?#~vRY_GTpH=E 8vwc6#xtp/TO ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'spraga_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

// theme
define( 'WP_DEFAULT_THEME', 'spraga' );

// general changes
define('WP_POST_REVISIONS', 0);
define('AUTOSAVE_INTERVAL', 3600);
define('EMPTY_TRASH_DAYS', 3600);

// disabling updates
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISALLOW_FILE_EDIT', true);
//define('DISALLOW_FILE_MODS', true);

// allow svg
define('ALLOW_UNFILTERED_UPLOADS', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
