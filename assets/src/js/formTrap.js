const formTrap = ( formClass = 'form--trap' ) => {
	let alreadyFocussing = false;

	const setTarget = ( e ) => {
		const form = e.target.form;
		const focusableElements = form.querySelectorAll(
			'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
		);
		const elementToFocus = e.shiftKey
			? focusableElements[ focusableElements.length - 1 ]
			: focusableElements[ 0 ];
		if ( e.key !== 'Tab' ) return;

		if (
			document.activeElement ===
				focusableElements[ focusableElements.length - 1 ] ||
			( document.activeElement === focusableElements[ 0 ] && e.shiftKey )
		) {
			console.log( 'focussing', elementToFocus );
			elementToFocus.focus();
			e.preventDefault();
		}
	};

	document.addEventListener( 'focusin', ( e ) => {
		const form = e.target.form;
		if ( ! form?.classList?.contains( formClass ) ) return;

		if ( form && ! alreadyFocussing ) {
			alreadyFocussing = true;
			document.addEventListener( 'keydown', setTarget );
			return;
		}

		if ( ! form ) {
			alreadyFocussing = false;
			document.removeEventListener( 'keydown', setTarget );
		}
	} );
};

export default formTrap;
