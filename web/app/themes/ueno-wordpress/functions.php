<?php

//require_once('../config.php');

define('UENO_THEME_VERSION', '0.1');

add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  // remove unneeded things
  remove_action('wp_head', 'wp_resource_hints', 2);
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 11, 0);
  remove_action('wp_head', 'wp_site_icon', 99);
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('wp_print_styles', 'print_emoji_styles');
  add_filter('emoji_svg_url', '__return_false');
});

add_action('wp_enqueue_scripts', function() {
  if (!IS_DEV) {
    wp_enqueue_style('styles', get_stylesheet_uri(), array(), UENO_THEME_VERSION);
  }
  wp_enqueue_script('scripts', get_theme_file_uri('/js/main.js'), array(), UENO_THEME_VERSION);
});
