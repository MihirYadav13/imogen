import {domReady} from '@roots/sage/client';

// 1. Import 3rd Party Libs
import './autoload/_bootstrap';
import fetchInject from 'fetch-inject';
window.fetchInject = fetchInject;

// 2. Import custom JS
import './util/current-breakpoint';
import './util/load-splide-async';
import './util/load-truncate-ellipsis-async';

//Make variables globals
window.currentBreakpoint = require('./util/current-breakpoint').currentBreakpoint;

// import then needed Font Awesome functionality
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// import the Facebook and Twitter icons
import {
  faChevronDown,
  faSearch,
  faBars,
  faXmark
} from '@fortawesome/free-solid-svg-icons';

// add the imported icons to the library
library.add(
  faSearch,
  faChevronDown,
  faBars,
  faXmark
);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();

/**
 * app.main
 */
const main = async (err) => {
  if (err) {
    // handle hmr errors
    console.error(err);
  }

  // application code
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
