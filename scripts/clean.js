require('dotenv').config();

const path = require('path');
const appRootDir = require('app-root-dir');
const rimraf = require('rimraf');

const {
  WP_THEME_DIR = './web/app/themes/ueno-wordpress',
} = process.env;

const targets = [
  path.join(WP_THEME_DIR, '/assets'),
  path.join(WP_THEME_DIR, '/js'),
  path.join(WP_THEME_DIR, '/style.css'),
];

function clean() {
  targets.forEach((t) => {
    const target = path.resolve(appRootDir.get(), t);

    rimraf(target, () => {
      console.info(`Cleaned ${target}`);
    });
  });
}

clean();
