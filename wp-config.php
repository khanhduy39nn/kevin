<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'atarchitect');

/** MySQL database username */
define('DB_USER', 'songle14');

/** MySQL database password */
define('DB_PASSWORD', 'Donghanh2109@');

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
define('AUTH_KEY',         'G#hm]^dqR vQ+G12jdBGH0 6!|I.-KM:c9vidd?1Gx?,u@`6S@t0JS,M7S,V^KSQ');
define('SECURE_AUTH_KEY',  'wI7E1s8M{2m!Ct]3:sGP6Q&89p#njj4J5KviJ;W6/EHQuRd{X^o7hwY*y;@)#exa');
define('LOGGED_IN_KEY',    '_JA7_IIq/-YeXOW4-=EP|2CIsJr0Pd{TIgsf6%KW8v#N<^/=Nsx-+X+@]<-<>O6%');
define('NONCE_KEY',        'H9d0&P#2/W~GoplQoN&-T_|N-t.Oa+wUX!9XV@j&^Y!`d^Uj%wke=Cq9Ff|vI;u%');
define('AUTH_SALT',        '9*|JisMB/>gcmnV0|exXk|`0E[).TOIO,1+KZOOf=pRw`-B~>JJ`!4WcpIUI^G&#');
define('SECURE_AUTH_SALT', '%72>nfWO3l5[ez=:GTb*9-9*C8UYt+izs9=B*D_!d&d:9Dnli,5(A~BImp:zOWVQ');
define('LOGGED_IN_SALT',   'dJ$|8-5N1E]|FKL4Xl:*S)>~$Z>`89T*U2UoN=w8||@j<-De &yy+X*1gF[M)S+E');
define('NONCE_SALT',       '084j]lipr-[>J$~k;_RFmX3 */@ YBXEW;Roh0++`te||*},~ f*7ZItv$qED<g|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dt2_';

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
