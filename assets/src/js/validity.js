/**
 * This function extends the browsers own validity system. It removes the default error
 *
 * @param {Object} args
 */
const validateInput = (args) => {
	const conf = {
		events: ['focusout', 'change'],
		errorClass: 'error',
		...args,
	};

	const addErrorListener = (event) => {
		if (!event.target.required) return;
		const errorMessage =
			event.target.parentElement.querySelector('.error-message');

		if (errorMessage !== null) errorMessage.remove();

		if (event.target.validity.valid) {
			event.target.parentElement.classList.remove(conf.errorClass);
			return;
		}

		event.target.parentElement.classList.add('error');

		const message =
			event.target.getAttribute('data-text-error') ??
			event.target.validationMessage;

		const span = document.createElement('span');
		span.innerHTML = message;
		span.classList.add('error-message');
		event.target.parentNode.append(span);
	};

	for (event of conf.events) {
		document.addEventListener(event, addErrorListener);
	}
};

export default validateInput;
