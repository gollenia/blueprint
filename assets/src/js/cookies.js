const cookies = () => {
	const sendConsentRequest = (all = false) => {
		const args = all ? '1' : '0';
		fetch('/wp-admin/admin-ajax.php?action=set_consent&all=' + args).then((response) => {
				if (all) {
					location.reload(true);
				}
			}
		);
	};

	window.addEventListener('DOMContentLoaded', () => {
		const consentBox = document.getElementById("allCookiesCheck");

		const okClick = document.getElementById('consentPrivacy');
		if (!okClick) return;
		okClick.addEventListener('click', () => {
			sendConsentRequest(consentBox.checked);
			document
				.getElementById('consentDialog')
				.classList.remove('modal--open');
		});

		const allClick = document.getElementById('consentAll');
		if (!allClick) return;
		allClick.addEventListener('click', () => {
			consentBox.checked = true;
			sendConsentRequest(consentBox.checked);
			document
				.getElementById('consentDialog')
				.classList.remove('modal--open');
		});

		const openDialog = document.getElementById('openCookiesDialog');

		if (!openDialog) return;
		openDialog.addEventListener('click', () => {
			document
				.getElementById('consentDialog')
				.classList.add('modal--open');
		});
	});
};

export default cookies;
