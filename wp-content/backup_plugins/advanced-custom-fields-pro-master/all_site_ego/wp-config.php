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
define('DB_NAME', 'all_site_ego');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'bG|mf_fjIF!ai:0kr]*e:*5NiaR|%O~>(E^e0[E{o&lgbE-tiGQp0d/elcAe%j/B');
define('SECURE_AUTH_KEY',  '(CSfDl2:A5$kH=K*l$Tb#c9&l.53-RBP2hM%cNz;(4Vv=w},gTItgiueBbqEgi%F');
define('LOGGED_IN_KEY',    'P{XYkxA_gR%gkGDU(jV+/FOwb11hG;70hzzz^&1&6_^$b^xDEKapkMsL<B!,s=8@');
define('NONCE_KEY',        '3|#?)ha??!)?!a.Fs#)UZ()t3(QTz<xkxV`!dK=pdwDw(_Aide)Xx %Ts(^Z@U]I');
define('AUTH_SALT',        'QM|xl3RdD]:aBp^jwL2$O3/LStxIk&_C0y4HUm5GxP<Y%V kpXh%Ub$)p!MKHe+f');
define('SECURE_AUTH_SALT', '>@2m;~.A/4[!P1PbBjwzNrNo)9s(m(tvAz58MU<43h>rCNEfc+1EihlRc29}ZyH*');
define('LOGGED_IN_SALT',   'IRZofndaE`q_h(~>J +t_UQd@Nj>1N!ZkM6bd0#zCd.|Olrs=igYaadc,<ackB6t');
define('NONCE_SALT',       'cM0eL<tv4jgb?!#zMxZ,c;eUvtIEyY;wm~2Vi}9H/VH%j)>kYO~=OXYnp;Nx!2VI');

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

ini_set('file_uploads', true);
define('MAX_UPLOAD_SIZE', 200000);
define('TYPE_WHITELIST', serialize(array(
  'image/jpeg',
  'image/png',
  'image/gif',
)));

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
