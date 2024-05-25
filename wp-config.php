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
define( 'DB_NAME', 'hwinarmy_com' );

/** Database username */
define( 'DB_USER', 'hwinarmy_com' );

/** Database password */
define( 'DB_PASSWORD', 'fSKBxRbdxy' );

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
define( 'AUTH_KEY',         'ID%xUn%[.qoS#1qsY]iAp.9!@|:WthbY$jEI_2csmVc5yeBF[6a$J11VIVq/w<gX' );
define( 'SECURE_AUTH_KEY',  'dw4ttAw{K$WwTabg2ERa9?eD;DKh6a$MShgc$V~nh`%.&W{vq{ks-vU}y|VL,tfy' );
define( 'LOGGED_IN_KEY',    'MJi}F/%F^}m=RB&lk xK;ck7P))xY{:y.s ~}P|u;rHn[9rOwW*%+cc&qpnkq$hP' );
define( 'NONCE_KEY',        '3!`&mV|}vE/>!mmb]>I&2;7c:(6(cy;Mfk,1{e;Z~<gp@/ $~EPA3/K|tDanaGNL' );
define( 'AUTH_SALT',        '+#50i,=i:tM+NZ72,fCKc}o>h)G63(:xn!Aen7qzI/7(t?1w6C34JWnuuY]?9;Z2' );
define( 'SECURE_AUTH_SALT', '`YNKa&B?L,N6i7iOu<HY#4:hFl$ntE>Wyt`6@*yl]7=7s7K{Y#G{WuFAqgEJT<N_' );
define( 'LOGGED_IN_SALT',   'K~V73JmKdjmCU60c]Czlo`CjiPEg2Zx`5;SEJ^gqh^pgf}1%dz+,_p$91(v02VxG' );
define( 'NONCE_SALT',       'IP@IjORmP+IyAYmU)S)gC~~2%/{0(]s4xUH!a`;[IT0n]xTW:U;G>^0g~WTo&VxC' );

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
