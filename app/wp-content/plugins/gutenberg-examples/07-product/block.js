( function( blocks, editor, i18n, element, components, _ ) {
	var el = element.createElement;
	var RichText = editor.RichText;
	var MediaUpload = editor.MediaUpload;
	var InspectorControls = editor.InspectorControls; // For adding block controls.
	var BlockDescription  = blocks.BlockDescription; // For adding descriptions to block settings panels.
	var ToggleControl     = components.ToggleControl; // For adding toggle controls to block settings panels.


	blocks.registerBlockType( 'gutenberg-examples/example-07-product', {
		title: i18n.__( 'Product', 'gutenberg-examples' ),
		description: 	i18n.__('Specify a city, address or place, and a map will be included'),
		icon: 'tag',
		category: 'widgets',
		attributes: {
			name: {
				type: 'string',
				source: 'html',
				selector: 'h2',
			},
			description: {
				type: 'string',
				source: 'html',
				selector: 'p',
			}
		},

		edit: function( {attributes, setAttributes, focus, className}  ) {

			const {
				name,
				description,
			} = attributes;


			return (
				el( 'div', { className: className },
					el( RichText, {
						tagName: 'h2',
						inline: true,
						placeholder: i18n.__( 'Specify the name of the product…', 'gutenberg-examples' ),
						value: attributes.name,
						onChange: function( value ) {
							setAttributes( { name: value } );
						},
					} ),
					el( RichText, {
						tagName: 'p',
						inline: true,
						placeholder: i18n.__( 'Describe this product...', 'gutenberg-examples' ),
						value: attributes.description,
						onChange: function( value ) {
							setAttributes( { description: value } );
						},
					} ),
				)
			);
		},
		save: function( props ) {
			var attributes = props.attributes;
			return (
				el( 'div', { className: props.className },
					el( RichText.Content, {
						tagName: 'h2', value: attributes.name
					} ),
					el( RichText.Content, {
						tagName: 'p', value: attributes.description
					} ),
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
