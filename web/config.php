<?php

// Check if heroku router is serving via https
if (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == 'https') {
  $_SERVER['HTTPS'] = 'on';
}

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/web';

define('ROOT_DIR', $root_dir);
define('WEB_ROOT_DIR', $webroot_dir);

$dev = getenv('DEV') === 'true';
define('IS_DEV', $dev);

require_once(dirname(__DIR__) . '/vendor/autoload.php');

try {
  $dotenv = new Dotenv\Dotenv(ROOT_DIR);
  $dotenv->load();
} catch (Exception $e) {
}

$_http_host_schema = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$_http_host_name = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : 'localhost';
$_server_http_url = $_http_host_schema."://".$_http_host_name;

define('WP_HOME', getenv('WP_HOME') ?: $_server_http_url);
define('WP_SITEURL', (getenv('WP_SITEURL') ?: $_server_http_url).'/wp');

define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR );

// disallow editing of files via admin UI
define('DISALLOW_FILE_MODS', true);

// we're not updating automatically
define('AUTOMATIC_UPDATER_DISABLED', true);

if (!IS_DEV) {
  define('FORCE_SSL_LOGIN', true);
  define('FORCE_SSL_ADMIN', true);
}

define('WP_ALLOW_MULTISITE', false);

// required by WP
$table_prefix  = 'wp_';

if (IS_DEV) {
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  define('SAVEQUERIES', true);
  define('WP_DEBUG', true);
  define('SCRIPT_DEBUG', true);
} else {
  ini_set('display_errors', 0);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', false);
  define('WP_DEBUG', false);
}
