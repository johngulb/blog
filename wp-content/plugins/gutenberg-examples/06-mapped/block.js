( function( blocks, editor, i18n, element, components, _ ) {
	var el = element.createElement;
	var RichText = editor.RichText;
	var MediaUpload = editor.MediaUpload;
	var InspectorControls = editor.InspectorControls; // For adding block controls.
	var BlockDescription  = blocks.BlockDescription; // For adding descriptions to block settings panels.
	var ToggleControl     = components.ToggleControl; // For adding toggle controls to block settings panels.
	var GOOGLE_API_KEY    = 'AIzaSyCHX3tZDcQNj7q0M7M0hoWPn_ooZ0-lxnE';

	blocks.registerBlockType( 'gutenberg-examples/example-06-mapped', {
		title: i18n.__( 'Map', 'gutenberg-examples' ),
		description: 	i18n.__('Specify a city, address or place, and a map will be included'),
		icon: 'location',
		category: 'widgets',
		attributes: {
			location: {
				type: 'string',
				source: 'html',
				selector: 'h2',
			},
			description: {
				type: 'string',
				source: 'html',
				selector: 'p',
			},
		},

		edit: function( {attributes, setAttributes, focus, className}  ) {

			const {
				location,
				description,
			} = attributes;


			return (
				el( 'div', { className: className },
					el( RichText, {
						tagName: 'h3',
						inline: true,
						placeholder: i18n.__( 'Specify a city, address, or place…', 'gutenberg-examples' ),
						value: attributes.location,
						onChange: function( value ) {
							setAttributes( { location: value } );
						},
					} ),
					el( RichText, {
						tagName: 'p',
						inline: true,
						placeholder: i18n.__( 'Describe this location...', 'gutenberg-examples' ),
						value: attributes.description,
						onChange: function( value ) {
							setAttributes( { description: value } );
						},
					} )
				)
			);
		},
		save: function( props ) {
			var attributes = props.attributes;
			//
			var mapURL = 'https://maps.googleapis.com/maps/api/staticmap?center=' + attributes.location + '&zoom=13&size=600x300&maptype=roadmap&key=' + GOOGLE_API_KEY;
			return (
				el( 'div', { className: props.className },
					el( RichText.Content, {
						tagName: 'h2', value: attributes.location
					} ),
					el( RichText.Content, {
						tagName: 'p', value: attributes.description
					} ),
					mapURL &&
						el( 'div', { className: 'map-image' },
							el( 'img', { src: mapURL } ),
						),
				)
			);
		},
	} );

} )(
	window.wp.blocks,
	window.wp.editor,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window._,
);
