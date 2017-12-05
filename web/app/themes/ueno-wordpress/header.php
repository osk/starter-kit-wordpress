<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="alternate" type="application/atom+xml" href="<?php bloginfo('atom_url'); ?>">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
  include 'components/grid-overlay.php';
?>

<?php
wp_nav_menu(array(
  'theme_location' => 'menu',
  'container' => 'nav',
  'container_class' => 'navigation',
  'menu_class' => 'navigation__list',
));
?>
