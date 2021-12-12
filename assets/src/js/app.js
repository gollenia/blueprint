import validateInput from './validity.js';
import { menuDrawer, menuDropdown } from './menu.js';

validateInput();
menuDropdown(1024);
menuDrawer('hamburger');
