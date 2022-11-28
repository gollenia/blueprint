import validateInput from './validity.js';
import { menuDrawer, menuDropdown } from './menu.js';
import cookies from './cookies.js';
import formTrap from './formTrap.js';


document.addEventListener("DOMContentLoaded", function(event) {
	validateInput();
	formTrap();
	menuDropdown('.menu__item--has-dropdown', {
		dropClass: 'menu__item--open',
	});

	menuDrawer('hamburger');
	cookies();
})