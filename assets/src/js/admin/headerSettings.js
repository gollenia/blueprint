/**
 * Adds a metabox for the page header settings
 */

/**
 * WordPress dependencies
 */
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { RangeControl, SelectControl, TextControl } from '@wordpress/components';
import { URLInput } from '@wordpress/block-editor';
import { useSelect, useDispatch } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

 
const headerSettings = () => {

	const {
		meta,
		meta: { header },
	} = useSelect((select) => ({
		meta: select('core/editor').getEditedPostAttribute('meta') || {},
	}));

	const { editPost } = useDispatch('core/editor');

	const [headerData, setheaderData] = useState(header);

	const setData = (key, data) => {
		setheaderData({...headerData, [key]: data});
	}

	console.log("header", meta)

	useEffect(() => {
		editPost({
			meta: {
				...meta,
				header: headerData,
			},
		});
	}, [headerData]);

	return (
		<PluginDocumentSettingPanel
			name="header-settings"
			title={__('Header Settings', 'blueprint')}
			className="header-settings"
		>
		
			<TextControl label={__('Subtitle', 'blueprint')} value={headerData.subtitle} onChange={(value) => { setData('subtitle', value)}}/>
	
			<div className="header-settings-section">
			<h3>{__('Image Settings', 'blueprint')}</h3>

				<RangeControl help={__('Percent of browser height', 'blueprint')} min={10} max={100} step={10} label={__('Header image height', 'blueprint')} value={headerData.height} onChange={(value) => { setData('height', value)}}/>
		
			
				<SelectControl 
					label={__('Orientation', 'blueprint')}
					onChange={(value) => { setData('image_position', value)}}
					value={headerData.image_position}
					options={[
						{label: __('Top', 'blueprint'), value: 0},
						{label: __('Middle', 'blueprint'), value: 1},
						{label: __('Bottom', 'blueprint'), value: 2},
					]}
				/>
			
			</div>
			<div className="header-settings-section">
			<h3>{__('Link Button', 'blueprint')}</h3>
			<div>
				<URLInput
					label={__('Page or URL', 'blueprint')}
					value={ headerData.link?.url }
					onChange={ ( url, post ) => setData( 'link', { url, title: post && post.title || __('Click here', 'blueprint') }) } 
				/>
				</div>

				<TextControl label={__('Button title', 'blueprint')} value={headerData.link?.title} onChange={(value) => { setData('link', {url: headerData.link.url, title: value})}}/>
		
			</div>

		</PluginDocumentSettingPanel>
	);
};

export default headerSettings;
