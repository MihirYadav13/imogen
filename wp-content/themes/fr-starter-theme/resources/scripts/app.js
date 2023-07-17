import '../styles/app.scss';

// 1. Import 3rd Party Libs
import './autoload/_bootstrap';
import './autoload/_fonts';
import fetchInject from 'fetch-inject';
window.fetchInject = fetchInject;

// 2. Import custom JS
import './util/current-breakpoint';
import './util/load-splide-async';
import './util/load-truncate-ellipsis-async';
import './util/element-is-in-viewport';
import './util/dropdown-animation';
import './components/embedded-video-thumbnail';
import './components/card-filter';

// 3. Import global
import './global/header';

// 4. Import blocks
import './blocks/card-grid';

//Make variables globals
window.currentBreakpoint = require('./util/current-breakpoint').currentBreakpoint;