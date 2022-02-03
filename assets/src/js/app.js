import validateInput from './validity.js';
import { menuDrawer, menuDropdown } from './menu.js';
import cookies from './cookies.js';

validateInput();
menuDropdown(1024);
menuDrawer('hamburger');
cookies();
