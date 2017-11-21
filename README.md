
# WordPress starter kit

WordPress starter kit with some nice things for starting a new WordPress project

## Development

```bash
> npm run dev
```

This will start a PHP server via `wp-cli` and a webpack dev server running in parallel. Changing code under `src/` will hot reload for the given theme (see environment variables) and copy all assets from `src/assets/` into the theme directory.

If running for the first time, there's some one time setup to run:

## Setting up local environment

You need to have PHP7.1+, MySQL (or some supported db) and Composer installed

```bash
> brew install mysql
> brew tap homebrew/php
> brew install php71
> brew install composer
```

Install dependencies, `preinstall` script will install Composer dependencies.

```bash
> npm install
```

Create a mysql database, if you've just installed mysql you can use root which has the empty password. Then run the install script which uses `wp-cli` to setup Wordpress, then start.

We're assuming the db will bes named `demo-wordpress-api` and the server will be running on `127.0.0.1:3306`, if that's not the case, create `.env` and change accordingly.

```bash
> mysql -u root -e "create database \`demo-wordpress-api\`"
> npm run install:wp
# take note of admin password
> npm run dev
```

mysqlworkbench can be used to manage the sql server via GUI, if that's your thing.

```bash
> brew cask install mysqlworkbench
```

## Environment variables

In dev no env variables should be needed, but when hosting they need to be set, see `.env_example`

* `DATABASE_URL` – URL to database, `JAWSDB_MARIA_URL` is also checked, defaults to `mysql://root:@127.0.0.1:3306/demo-wordpress-api`
* `WP_URL` – Required for heroku install script
* `WP_ADMIN_PASSWORD` – Required for heroku install script
* `WP_ADMIN_EMAIL` – Required for heroku install script
* `WP_ADMIN_USER` – Optional for heroku install script, defaults to `admin`
* `WP_TITLE` – Optional for heroku install script, defaults to `Headless WordPress`
* `WP_THEME` – Name of the theme to use, defaults to `ueno-wordpress`
* `WP_THEME_DIR` – Directory of the theme, defaults to `./web/app/themes/ueno-wordpress`

Also the following can be set for Wordpress security tokens:
`AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`

## Build

Running `npm run build` will clean up any dev versions of bundled files (via `scripts/clean.js`) and build a production build of CSS and JS.

A banner will be added to the top of `style.css` that sets the theme name.

## Heroku

Create a Heroku app, add the JawsDB Maria addon and set the env variables from above to correct values for your case.

Push the app to Heroku, `app.json` defines a post deploy script for first time push that installs WP.

The install script can be run manually with:

```bash
> heroku run scripts/install.sh
```

To re-install the database can be reset by running

```bash
> heroku run scripts/uninstall.sh
```

Since Heroku has an ephemeral filesystem we need to persist uploads somewhere else, like on S3. The "Amazon Web Services" and "WP Offload S3 Lite" plugins are used to facilitate that. `AWS_S3_ACCESS_ID`, `AWS_S3_SECRET_KEY` and `AWS_S3_BUCKET` need to be defined for it to work.

## Inspired by

https://github.com/PhilippHeuer/wordpress-heroku

https://github.com/roots/bedrock