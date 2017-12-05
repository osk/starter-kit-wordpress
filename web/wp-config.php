<?php

/**
 * This is setup to work for Heroku, for other hosting, somethings might need to
 * be changed here, e.g. how the db stuff is handled.
 */

require_once(dirname(__DIR__).'/web/config.php');

$databaseUrl = getenv('DATABASE_URL') ? getenv('DATABASE_URL') : getenv('JAWSDB_MARIA_URL');

// default for dev
if (empty($databaseUrl)) {
  $databaseUrl = 'mysql://root:@127.0.0.1:3306/starter-kit-wordpress';
}

$url = parse_url($databaseUrl);
$port = '';
if (isset($url['port']) && $url['port'] !== '') {
  $port = ':' . $url['port'];
}

define('DB_NAME', trim($url['path'], '/'));
define('DB_USER', $url['user']);
define('DB_PASSWORD', $url['pass']);
define('DB_HOST', $url['host'] . $port);
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

if (!defined('ABSPATH')) {
  define('ABSPATH', WEB_ROOT_DIR . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
