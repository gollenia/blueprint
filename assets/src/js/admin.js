import { registerPlugin } from '@wordpress/plugins';
import './admin.scss';
import colorSettings from './admin/colorSettings';
//import headerSettings from './admin/headerSettings';

registerPlugin('plugin-color-settings', {
	icon: null,
	render: colorSettings,
});
