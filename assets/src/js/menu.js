/**
 * Open a dropdown menu, but only on amaximum screen width
 *
 * @param {string} itemClass class that contains the menu item
 * @param {Object} args
 */
function menuDropdown(itemClass, args) {
	const options = {
		maxScreenWidth: 1024,
		dropClass: 'menu-open',
		...args,
	};

	const closeAllDropdowns = () => {
		document.querySelectorAll(itemClass).forEach((el) => {
			el.classList.remove(options.dropClass);
		});
	};

	const menu = document.querySelectorAll(itemClass);

	console.log(menu);
	if (menu.length > 0) {
		menu.forEach((element) => {
			element.addEventListener('click', (event) => {
				if (window.innerWidth > options.maxScreenWidth) return;
				if (!event.target.classList.contains('mobile__arrow')) return;

				event.stopPropagation();
				event.preventDefault();

				if (event.currentTarget.classList.contains(options.dropClass)) {
					event.currentTarget.classList.remove(options.dropClass);
					return;
				}

				closeAllDropdowns();

				event.currentTarget.classList.add(options.dropClass);
			});
		});
	}
}

/**
 *   Open menu on mobile when hamburger icon is clicked
 *
 * @param {string} hamburgerId
 * @param {Object} args
 */
function menuDrawer(hamburgerId, args) {
	let hamburgers = document.getElementsByClassName('hamburger');

	console.log(hamburgerId);

	if (!hamburgers.length) return;

	let hamburger = hamburgers[0];

	const target = hamburger.getAttribute('data-target');

	const options = {
		openClass: 'menu--open',
		activeClass: 'hamburger--active',
		...args,
	};

	if (hamburger) {
		hamburger.addEventListener('click', () => {
			hamburger.firstElementChild.classList.toggle(options.activeClass);
			const menu = document.getElementById(target);
			//menuDropdown({ closeAll: true });
			menu.classList.toggle(options.openClass);
		});
	}
}

export { menuDropdown, menuDrawer };
