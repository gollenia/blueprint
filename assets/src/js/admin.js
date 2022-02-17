import headerSettings from './admin/headerSettings';
import colorSettings from './admin/colorSettings';
import { registerPlugin } from '@wordpress/plugins';
import './admin.scss';

registerPlugin('plugin-page-attributes', {
	icon: null,
	render: headerSettings,
});

registerPlugin('plugin-color-settings', {
	icon: null,
	render: colorSettings,
});