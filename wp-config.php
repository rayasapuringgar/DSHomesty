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
define( 'DB_NAME', 'homestay' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '(*U[/<;#A(+ qN+;9^&ZqQYr{<8w:F<IK}`&^]QPr%~.0W0f{_:nSuj +<Zx]x,N' );
define( 'SECURE_AUTH_KEY',  'g2BIc2lW@;POj_8cWNk=Itwxp5_cu_{]]ai5rs6JJ&wezc)a$pz%nJ8LX[4u!Zd^' );
define( 'LOGGED_IN_KEY',    'uM)|l^PXW9X![mnBh5^[5]R7~8M5Mc&yGK4=7.70^#k_t55}ZdS$/BKS8:h1EDw~' );
define( 'NONCE_KEY',        '6^(>dNE|fARXjgYtCj*{2j&#t#CS#]d4(5 [BrgGZOq2UFQ&4)[a{TbKV; Il0Ae' );
define( 'AUTH_SALT',        'rcJNgbsy6$n$EHV^w<ZPRmNzIqDkK[*9(Uf^GL#f>SR&Ot$)bCCM.1!c2_=Mbi#w' );
define( 'SECURE_AUTH_SALT', 'Z)}9o^Fv8$V<=y^i@^C(_T98X6ZbP09++Jm:|)q3/;wAuQb!n8%Of/.m+pWa:MRX' );
define( 'LOGGED_IN_SALT',   'L]<.mUmczsqmsDyK*&u31I&DeD}&+j@|Z[({>@5BlA+]l#Iu. :mOL[}gJF<[bK2' );
define( 'NONCE_SALT',       'pm| gO:Jqv5EC6+er QJ{E!1wYY]&NO[eU5oOcK-&0d+3nx|3(#dPsUBqT.DmJX~' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ds_';

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
