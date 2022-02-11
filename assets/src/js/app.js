import validateInput from './validity.js';
import { menuDrawer, menuDropdown } from './menu.js';
import cookies from './cookies.js';

validateInput();

menuDropdown('menu__item--has-dropdown', {
	dropClass: 'menu__item--open',
});

menuDrawer('hamburger');
cookies();
