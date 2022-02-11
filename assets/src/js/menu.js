/**
 * Open a dropdown menu, but only on amaximum screen width
 *
 * @param {string} itemClass class that contains the menu item
 * @param {Object} args
 */
function menuDropdown(itemClass, args) {
	const options = {
		maxScreenWidth: 1024,
		itemClass: '.menu__item--has-dropdown',
		dropClass: 'menu__item--open',
		closeAll: false,
		...args,
	};

	const closeAllDropdowns = () => {
		document.querySelectorAll(itemClass).forEach((el) => {
			el.classList.remove(options.dropClass);
		});
	};

	if (options.closeAll) {
		closeAllDropdowns();
		return;
	}

	const menu = document.querySelectorAll(options.itemClass);
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
 */
function menuDrawer(hamburgerId) {
	const hamburger = document.getElementById(hamburgerId);

	if (hamburger) {
		hamburger.addEventListener('click', () => {
			hamburger.firstElementChild.classList.toggle('is-active');
			const menu = document.getElementById('hamburger-menu');
			menuDropdown({ closeAll: true });
			menu.classList.toggle('menu--open');
		});
	}
}

export { menuDropdown, menuDrawer };
