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
define('DB_NAME', 'osmedicine');

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
define('AUTH_KEY',         '+M,`p<*P xld`coclq0DJ5,t{@BFyzfQJU9?;@ww#~XH[S14=v~.hPT%fDq@#;3s');
define('SECURE_AUTH_KEY',  'uj]q;OcNH$!Q8-J:wW16jff{M#gE>oN#,`^LD:(Ne{9N??y[0JvPRirP:D.|F.zH');
define('LOGGED_IN_KEY',    '5TGuDv$WEr>]VXwL*K](!m6|cyA@AOl/+P+m_M) =c]V/C?R]xuL}$o<PAk 4o<s');
define('NONCE_KEY',        '$cS+?Pv.H!TIu 2sX>I,bdt^9zx_BUt(ri1z>%kH!)2si=:XLe!#}c0QBslmW~]z');
define('AUTH_SALT',        'H91q-)GF97aSk3Fb,y-3.AB<*gE#.-Sz;^3 ( l0@(iYrOx(ZkU@e6@4;fgaOngD');
define('SECURE_AUTH_SALT', 'jZfwc4j9^e_^@k6vW4|RY<c.h*m:8MIx&mUQOU_Orh64mcFTkA%@(pYA>-&TPnFF');
define('LOGGED_IN_SALT',   'f(S[kQwiHy6Q%r_:Y/i6V_;+BCTrL<Om=:ILT`Oh${(wfE5/W:T{2cOzA*oSYeQ^');
define('NONCE_SALT',       'xukc4NTv^)%YaT^@[14cS24rZyREc=sXP:cn>5wMOu[s+&)z.rlhy?WJVsmG:<-#');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'osmedicine.test');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
