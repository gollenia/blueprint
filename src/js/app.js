import cookies from './cookies.js';
import formTrap from './formTrap.js';
import { menuDrawer, menuDropdown } from './menu.js';

document.addEventListener('DOMContentLoaded', function (event) {
	//traps the tab-next within a form
	formTrap();
	menuDropdown('.menu__item--has-dropdown', {
		dropClass: 'menu__item--open',
	});

	menuDrawer('hamburger');
	cookies();
});
