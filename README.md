# WordPress starter kit

WordPress starter kit with some nice things for starting a new WordPress project.

## Development

```bash
npm run dev
```

This will start a PHP server via `wp-cli` and a webpack dev server running in parallel. Changing code under `src/` will hot reload for the given theme (see environment variables) and copy all assets from `src/assets/` into the theme directory.

If running for the first time, there's some one time setup to run:

## Setting up local environment

You need to have PHP7.1+, MySQL (or some supported db) and Composer installed

### Windows

Install [PHP](http://php.net/downloads.php) and [Composer](https://getcomposer.org/download/).

### Mac OS X

```bash
brew install mysql
brew tap homebrew/php
brew install php71
brew install composer
```

After installing mysql, it's started with

```bash
brew services start mysql
```

### MySQL database

Create a mysql database, if you've just installed mysql you can use root which has the empty password.

```bash
$ mysql -u root -e "create database \`starter-kit-wordpress\`"
$ npm run install:wp
# take note of admin password
$ npm run dev
```

mysqlworkbench can be used to manage the sql server via GUI, if that's your thing.

```bash
brew cask install mysqlworkbench
```

### Installing

Install dependencies, `preinstall` script will install Composer dependencies.

```bash
npm install
```

Then run the install script which uses `wp-cli` to setup Wordpress.

We're assuming the db will be named `starter-kit-wordpress` and the server will be running on `127.0.0.1:3306`, if that's not the case, create `.env` and change accordingly.

```bash
$ npm run install:wp
# take note of admin password
$ npm run dev
```

## Plugins

When adding plugins use the [wpackagist composer repository](https://wpackagist.org/) (the repo is already in `composer.json`) to add the dependency in `composer.json`. To make sure the plugin is installed under `web/app/plugins/` an entry needs to be added to `installer-paths` in `composer.json`.

E.g. to add the ACF free plugin:

1. Add the following to the `"web/app/plugins/{$name}/"` array under `installer-paths`:
  `"wpackagist-plugin/advanced-custom-fields"``
2. Require the plugin via composer
  `composer require wpackagist-plugin/advanced-custom-fields`
3. Plugin is now installed under `web/app/plugins/advanced-custom-fields` and can be used locally. All plugins are ignored by git, see `.gitignore`. On deploy to Heroku it will be installed as part of the build

### Advanced Custom Fields (ACF)

For custom fields for pages and post types Advanced Custom Fields is used. To manage the fields the correct way is to do the changes from the UI. This triggers a change to the relevant file under web/app/themes/ueno-wordpress/acf-json that allows for the custom fields to be version controlled and kept in sync over all environments.

## Build

Before running a build update the version (`UENO_THEME_VERSION`) in `function.php` for cache busting.

Running `npm run build` will clean up any dev versions of bundled files (via `scripts/clean.js`) and build a production build of CSS and JS.

A banner will be added to the top of `style.css` that sets the theme name.

Some projects will want the built files tracked by Git since it's not always possible to run a custom script during build.

## Deployment

This project supports deployments to two different environments: Heroku and WPEngine, along with a generic "upload-to-ftp" deploy.

These two environments with the additional development environment that uses PHP's built-in server might have some conflicts.

### Heroku deployment

Heroku is used for development and should be setup to auto-deploy from `master` branch. Heroku supports running `composer` during build and requires some extra plugins to make file uploads work, see below.

### WPEngine deployment

Deployment to WPEngine is done via the `scripts/wpengine.sh` that:

* Creates a new `wpengine` branch (if it exists, it will be deleted!)
* Installs plugins via `composer`
* Arranges the project in a way that wpengine supports
* Copies wpengine specific files from `wpengine/`, specifically a `.gitignore` file that ignores a whole lot of files
* Refreshes git against this new project structure and;
* Pushes the `wpengine` branch to wpengine server (you need to have setup [git push](https://wpengine.com/support/set-git-push-user-portal/))
* Performs cleanup: delete branch and switch back to master

WPEngine git push is only additive, so any files that exist before a push will not be deleted. This means you might want to FTP in and delete e.g. themes.

Note that you should push to a staging version on WPEngine and then use the dashboard to deploy staging to production _after_ verifying everything works as expected.

### Upload-to-ftp deployment

When running on a host that doesn't support git deployment, we need to create a "deploy", a directory with all the files we'll be uploading. First create a production build and check everything in. Then run the `deploy.sh` script and optionally specify a relative path to the assets directory (it defaults to `/app/themes/ueno-wordpress/assets`):

```bash
> ./scripts/deploy.sh
# or if theme will be located at /wp-content/themes/ueno-wordpress
> ./scripts/deploy.sh /wp-content/themes/ueno-wordpress
```

This creates a `deploy/` directory with `plugins/` and `themes/` subdirectories that are uploaded into `wp-content/`.

## Environment variables

In dev no env variables should be needed, but when hosting they need to be set, see `.env_example`

* `DATABASE_URL` – URL to database, `JAWSDB_MARIA_URL` is also checked, defaults to `mysql://root:@127.0.0.1:3306/starter-kit-wordpress`
* `WP_URL` – Required for heroku install script
* `WP_ADMIN_PASSWORD` – Required for heroku install script
* `WP_ADMIN_EMAIL` – Required for heroku install script
* `WP_ADMIN_USER` – Optional for heroku install script, defaults to `admin`
* `WP_TITLE` – Optional for heroku install script, defaults to `Headless WordPress`
* `WP_THEME` – Name of the theme to use, defaults to `ueno-wordpress`
* `WP_THEME_DIR` – Directory of the theme, defaults to `./web/app/themes/ueno-wordpress`

Also the following can be set for Wordpress security tokens:
`AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`

## Heroku

Create a Heroku app, add the JawsDB Maria addon and set the env variables from above to correct values for your case.

Push the app to Heroku, `app.json` defines a post deploy script for first time push that installs WP.

The install script can be run manually with:

```bash
> heroku run scripts/install.sh
```

To re-install, the database can be reset by running

```bash
> heroku run scripts/uninstall.sh
```

Since Heroku has an ephemeral filesystem we need to persist uploads somewhere else, like on S3. The "Amazon Web Services" and "WP Offload S3 Lite" plugins are used to facilitate that. `AWS_S3_ACCESS_ID`, `AWS_S3_SECRET_KEY` and `AWS_S3_BUCKET` need to be defined for it to work.

## Headless CMS

For headless projects:

* Remove the `src/` directory
* Remove all dev dependencies from `packages.json` except for `cross-env`
* Remove all `package.json` `scripts` except for the install scripts and `dev:wp`, rename `dev:wp` to `dev`
* Remove all frontend files from `web/app/themes/ueno-wordpress` (i.e. `404.php`, `header.php` and such)
* Add an empty `style.css` that only contains the required header, e.g.

 ```css
 /*
 Theme Name: ueno-headless
 Author: ueno
 */
 ```

## Inspired by

* [wordpress-heroku](https://github.com/PhilippHeuer/wordpress-heroku)
* [bedrock](https://github.com/roots/bedrock)
