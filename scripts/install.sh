#!/usr/bin/env bash
cd $HOME

if [[ ! -z "$WP_URL" && ! -z "$WP_ADMIN_PASSWORD" && ! -z "$WP_ADMIN_EMAIL" ]]; then

  wp_title=${WP_TITLE:-'WordPress starter kit'}
  wp_user=${WP_ADMIN_USER:-'admin'}
  wp_url="$(echo $WP_URL)"
  wp_password="$(echo $WP_ADMIN_PASSWORD)"
  wp_email="$(echo $WP_ADMIN_EMAIL)"
  wp_theme=${WP_THEME:-'ueno-wordpress'}

  vendor/bin/wp core install --url="$wp_url" --title="$wp_title" --admin_user="$wp_user" --admin_password="$wp_password" --admin_email="$wp_email"

  vendor/bin/wp theme activate "$wp_theme"
  vendor/bin/wp plugin activate --all
else
  echo "Unable to install WordPress automatically, WP_URL, WP_ADMIN_PASSWORD and WP_ADMIN_EMAIL must be set"
fi
