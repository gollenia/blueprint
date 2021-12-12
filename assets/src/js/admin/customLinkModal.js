function customLinkModal() {
	const linkButtons = document.getElementsByClassName('ctx-link-modal');

	for (let element of linkButtons) {
		element.addEventListener('click', (event) => {
			const parent = event.target.parentNode;
			const textarea = document.createElement('textarea');
			textarea.id = 'ctx-link-textarea';
			textarea.style = 'display:none;';
			document.body.appendChild(textarea);

			jQuery(document).on('wplink-open', () => {
				document
					.getElementById('wp-link-wrap')
					.classList.add('has-text-field');
			});

			jQuery(document).on('wplink-close', () => {
				document
					.getElementById('wp-link-wrap')
					.classList.add('has-text-field');
				const linkTextarea =
					document.getElementById('ctx-link-textarea');
				const div = document.createElement('div');
				div.innerHTML = linkTextarea.value.trim();

				const linkElem = div.firstChild;

				parent.querySelector('#input-title').value = linkElem.innerHTML;
				parent.querySelector('#input-url').value =
					linkElem.getAttribute('href');
				parent.querySelector('#link-preview').innerHTML =
					linkElem.getAttribute('href');
			});

			wpLink.open('ctx-link-textarea');
		});
	}
}

export default customLinkModal;
