const cookies = () => {
	const sendConsentRequest = () => {
		fetch('/wp-admin/admin-ajax.php?action=set_consent').then(
			(response) => {
			}
		);
	};

	window.addEventListener('DOMContentLoaded', () => {
		const okClick = document.getElementById('consentPrivacy');
		if (!okClick) return;
		okClick.addEventListener('click', () => {
			sendConsentRequest();
			document
				.getElementById('consentDialog')
				.classList.remove('modal--open');
		});
	});
};

export default cookies;
