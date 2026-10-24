import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

/**
 * suburbancm/cta-1 editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const { title, description, buttonText, buttonUrl } = attributes;
	const blockProps = useBlockProps( { className: 'scm-cta scm-bg-gold' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button link', 'suburbancm' ) } initialOpen={ true }>
					<TextControl
						label={ __( 'Button URL', 'suburbancm' ) }
						value={ buttonUrl }
						onChange={ ( value ) => setAttributes( { buttonUrl: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section--sm scm-cta__inner">
					<div className="scm-cta__text">
						<RichText
							tagName="h2"
							className="scm-d scm-h-l"
							placeholder={ __( 'Headline…', 'suburbancm' ) }
							value={ title }
							onChange={ ( value ) => setAttributes( { title: value } ) }
						/>
						<RichText
							tagName="p"
							className="scm-lede"
							placeholder={ __( 'Optional line of text…', 'suburbancm' ) }
							value={ description }
							onChange={ ( value ) => setAttributes( { description: value } ) }
						/>
					</div>
					<RichText
						tagName="span"
						className="scm-btn scm-btn--ink"
						placeholder={ __( 'Button text…', 'suburbancm' ) }
						value={ buttonText }
						onChange={ ( value ) => setAttributes( { buttonText: value } ) }
						allowedFormats={ [] }
					/>
				</div>
			</section>
		</>
	);
};

export default Edit;
