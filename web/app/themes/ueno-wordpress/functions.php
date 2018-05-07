<?php

define('UENO_THEME_VERSION', '0.1');

// and make sure we're not leaking on stage/prod
if (!defined('UENO_CONFIG_SET')) {
  ini_set('display_errors', 0);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', false);
  define('WP_DEBUG', false);
}

require_once('lib/clean.php');

// If we're running a development version this will be set, otherwise it's not
if (!defined('IS_DEV')) {
  define('IS_DEV', false);
}

add_action('wp_enqueue_scripts', function() {
  // in development styles are injected via development build of main.js
  if (!IS_DEV) {
    wp_enqueue_style('styles', get_stylesheet_uri(), array(), UENO_THEME_VERSION);
  }
  wp_enqueue_script('scripts', get_theme_file_uri('/js/main.js'), array(), UENO_THEME_VERSION);
});

// Add pages to menu under Appearance > Menus
add_action('init', function() {
  register_nav_menus(
    array(
      'menu' => 'Menu',
    )
  );
});

// Allow SVG uploads
add_filter('upload_mimes', function($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
});
