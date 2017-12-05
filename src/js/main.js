/* global IS_DEV */

import devtools from './devtools';
import button from './components/button';

function loaded() {
  devtools.init(IS_DEV);

  button();
}

document.addEventListener('DOMContentLoaded', loaded);
