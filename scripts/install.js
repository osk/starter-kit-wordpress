require('dotenv').config();

const chalk = require('chalk');
const { exec } = require('child_process');
const { exit } = require('process');
const { format } = require('util');

const {
  WP_URL,
  WP_TITLE,
  WP_ADMIN_USER,
  WP_ADMIN_EMAIL,
  WP_THEME_NAME,
} = process.env;

const url = WP_URL || 'http://localhost:8080/';
const title = WP_TITLE || 'WordPress starter kit';
const user = WP_ADMIN_USER || 'admin';
const email = WP_ADMIN_EMAIL || 'admin@example.org';
const theme = WP_THEME_NAME || 'ueno-wordpress';

function log(m) {
  console.info(chalk.bold(`=====> ${m}`));
}

function info(m) {
  console.info(chalk.blue(`${m}`));
}

function error(m) {
  console.info(chalk.red(chalk.bold(m)));
}

log('Installing WordPress');

exec('vendor/bin/wp --info', (err) => {
  if (err) {
    error('You need to install wp cli');
    exit(1);
  }
});

function install() {
  const cmd = format(
    'vendor/bin/wp core install --debug --url="%s" --title="%s" --admin_user="%s" --admin_email="%s"',
    url, title, user, email,
  );

  exec(cmd, (err, stdout, stderr) => {
    if (err) {
      error(chalk.red('Unable to install WordPress'));
      console.error(stderr);
      exit(1);
    }

    console.info(stdout);

    exec(
      format('vendor/bin/wp theme activate %s', theme),
      (themeErr, themeStdout, themeStderr) => {
        if (themeErr) {
          error(chalk.red('Unable to set active theme'));
          console.error(themeStderr);
          exit(1);
        }

        console.info(themeStdout);
      },
    );

    exec('vendor/bin/wp plugin activate --all', (pluginErr, pluginStdout, pluginStderr) => {
      if (pluginErr) {
        error(chalk.red('Unable to activate plugins'));
        console.error(pluginStderr);
        exit(1);
      }

      console.info(pluginStdout);
    });

    exec('vendor/bin/wp option set blogdescription ""', (optionErr, optionStdout, optionStderr) => {
      if (optionErr) {
        error(chalk.red('Unable to set option'));
        console.error(optionStderr);
        exit(1);
      }

      console.info(optionStdout);
    });

    exec('vendor/bin/wp rewrite structure /%postname%/', (rewriteErr, rewriteStdout, rewriteStderr) => {
      if (rewriteErr) {
        error(chalk.red('Unable to set rewrite structure'));
        console.error(rewriteStderr);
        exit(1);
      }

      console.info(rewriteStdout);
    });
  });
}

exec('vendor/bin/wp core is-installed', (err) => {
  // returns status code 1 if not installed
  if (err && err.code > 0) {
    install();
  } else {
    info('WordPress is already installed');
    exit(0);
  }
});
