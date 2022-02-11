function extendColorInput() {
	window.addEventListener(
		'DOMContentLoaded',
		() => {
			const colorInputFields = document.getElementsByTagName('input');
			for (const element of colorInputFields) {
				if (element.type === 'color') {
					const hexInput = document.createElement('input');
					hexInput.value = element.value;
					hexInput.classList.add('ctx-hex-input');
					hexInput.pattern = '#[0-9A-Fa-f]{6}';
					element.insertAdjacentElement('afterend', hexInput);

					hexInput.addEventListener('change', (event) => {
						element.value = event.target.value;
					});

					element.addEventListener('change', (event) => {
						hexInput.value = event.target.value;
					});
				}
			}
		},
		false
	);
}

export default extendColorInput;
