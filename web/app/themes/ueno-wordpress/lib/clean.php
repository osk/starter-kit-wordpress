<?php

add_action('after_setup_theme', function() {
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 570, 9999 ); // Unlimited height, soft crop
  add_image_size('800x800', 800, 800, true); // 800x800 hard crop example
});

/**
 * "Cleans" the WordPress output and disables things we don't want or need
 */

add_action('after_setup_theme', function() {
  // header generates <title> for us
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

add_action('admin_menu', function() {
  remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
  remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Status Metabox
  remove_meta_box( 'commentsdiv','post','normal' ); // Comments Metabox
  remove_meta_box( 'postcustom','post','normal' ); // Custom Fields Metabox
  remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
  remove_meta_box( 'revisionsdiv','post','normal' ); // Revisions Metabox
  remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
  remove_meta_box( 'trackbacksdiv','post','normal' ); // Trackback Metabox
});

// don't allow admin editing of style.css
if (!defined('DISALLOW_FILE_EDIT')) {
  define('DISALLOW_FILE_EDIT', true);
}

// remove admin options from pages
add_action('admin_menu' , function() {
  remove_meta_box('postcustom' , 'page' , 'normal');
  remove_meta_box('commentstatusdiv' , 'page' , 'normal');
  remove_meta_box('commentsdiv' , 'page' , 'normal');
  remove_meta_box('authordiv' , 'page' , 'normal');
 });

// remove things from customize theme in admin
add_action('customize_register', function($customize) {
  $customize->remove_section('title_tagline');
  $customize->remove_section('colors');
  $customize->remove_section('header_image');
  $customize->remove_section('background_image');
  // $customize->remove_panel('nav_menus');
  // $customize->remove_section( 'static_front_page');
  $customize->remove_section('custom_css');
}, 50);

add_action('wp_dashboard_setup', function() {
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box('dashboard_primary', 'dashboard', 'side' );
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box('dashboard_secondary', 'dashboard', 'side' );
});

// remove text color changing from editor
add_filter('mce_buttons_2', function($buttons) {
  $remove = array('forecolor');
  return array_diff( $buttons, $remove );
});

