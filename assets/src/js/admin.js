import extendColorInput from './admin/extendColorInput';
import customLinkModal from './admin/customLinkModal';
import headerSettings from './admin/headerSettings';
import { registerPlugin } from '@wordpress/plugins';
import './admin.scss';

extendColorInput();
customLinkModal();

registerPlugin('plugin-page-attributes', {
	icon: null,
	render: headerSettings,
});
