import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

const BOXES = [
	{ key: '1', className: 'scm-action--filled', btn: 'scm-btn' },
	{ key: '2', className: 'scm-action--outline', btn: 'scm-btn scm-btn--line' },
];

const Edit = ( { attributes, setAttributes } ) => {
	const blockProps = useBlockProps( { className: 'scm-actions scm-bg-bone' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section label', 'suburbancm' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Heading for screen readers', 'suburbancm' ) }
						help={ __( 'Not shown on the page; announced to screen-reader users.', 'suburbancm' ) }
						value={ attributes.title }
						onChange={ ( value ) => setAttributes( { title: value } ) }
					/>
				</PanelBody>
				{ BOXES.map( ( box, i ) => (
					<PanelBody key={ box.key } title={ i === 0 ? __( 'Filled box link', 'suburbancm' ) : __( 'Outlined box link', 'suburbancm' ) }>
						<TextControl
							label={ __( 'Button URL', 'suburbancm' ) }
							value={ attributes[ `link${ box.key }` ] }
							onChange={ ( value ) => setAttributes( { [ `link${ box.key }` ]: value } ) }
						/>
					</PanelBody>
				) ) }
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section--sm scm-actions__grid">
					{ BOXES.map( ( box ) => (
						<div key={ box.key } className={ `scm-action ${ box.className }` }>
							<RichText
								tagName="h3"
								className="scm-d scm-h-s"
								value={ attributes[ `title${ box.key }` ] }
								onChange={ ( value ) => setAttributes( { [ `title${ box.key }` ]: value } ) }
								placeholder={ __( 'Title…', 'suburbancm' ) }
							/>
							<RichText
								tagName="p"
								value={ attributes[ `description${ box.key }` ] }
								onChange={ ( value ) => setAttributes( { [ `description${ box.key }` ]: value } ) }
								placeholder={ __( 'Description…', 'suburbancm' ) }
							/>
							<RichText
								tagName="span"
								className={ box.btn }
								value={ attributes[ `linkText${ box.key }` ] }
								onChange={ ( value ) => setAttributes( { [ `linkText${ box.key }` ]: value } ) }
								placeholder={ __( 'Button text', 'suburbancm' ) }
								allowedFormats={ [] }
							/>
						</div>
					) ) }
				</div>
			</section>
		</>
	);
};

export default Edit;
