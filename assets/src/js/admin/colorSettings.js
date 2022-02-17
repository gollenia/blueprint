/**
 * Adds a metabox for the page color settings
 */

/**
 * WordPress dependencies
 */
 import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
 import { ColorPalette, SelectControl, TextControl } from '@wordpress/components';
 import { URLInput } from '@wordpress/block-editor';
 import { useSelect, useDispatch } from '@wordpress/data';
 import { useState, useEffect } from '@wordpress/element';
 import { __ } from '@wordpress/i18n';
 
  
 const pageColorSettings = () => {
 
	 const {
		 meta,
		 meta: { page_colors },
	 } = useSelect((select) => ({
		 meta: select('core/editor').getEditedPostAttribute('meta') || {},
	 }));

	 const colors = useSelect('core/block-editor').getSettings().colors;
 
	 const { editPost } = useDispatch('core/editor');
 
	 const [pageColors, setpageColors] = useState(page_colors);
 
	 const setData = (key, data) => {
		 const primary = colors.find(color => color.slug === 'primary').color;
		 const secondary = colors.find(color => color.slug === 'secondary').color;

		 if((key == 'primary_color' && data == primary) || key == 'secondary_color' && data == secondary) {
			setpageColors({...pageColors, [key]: ""});
			return;
		 }
		 setpageColors({...pageColors, [key]: data});
	 }

 
	 useEffect(() => {
		 editPost({
			 meta: {
				 ...meta,
				 page_colors: pageColors,
			 },
		 });
	 }, [pageColors]);

	 console.log("color", meta)
 
	 return (
		 <PluginDocumentSettingPanel
			 name="page-color-settings"
			 title={__('Color Settings', 'blueprint')}
			 className="page-color-settings"
		 >
		 <h3>{__('Primary Color', 'blueprint')}</h3>
		 <ColorPalette
		 	colors={colors}
            value={pageColors?.primary_color}
            onChange={(value) => {setData('primary_color', value)}}
            defaultValue="#000"
			disableCustomColors={true}
        />
		<h3>{__('Secondary Color', 'blueprint')}</h3>
		<ColorPalette
			colors={colors}
            value={pageColors?.secondary_color}
            onChange={(value) => {setData('secondary_color', value)}}
            defaultValue="#000"
			disableCustomColors={true}
        />
 
		 </PluginDocumentSettingPanel>
	 );
 };
 
 export default pageColorSettings;
 