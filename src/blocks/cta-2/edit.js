import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

/**
 * suburbancm/cta-2 editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const { title, subtitle, primaryButtonText, primaryButtonUrl, secondaryButtonText, secondaryButtonUrl } = attributes;
	const blockProps = useBlockProps( { className: 'scm-cta scm-cta--ink scm-bg-ink-2' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button links', 'suburbancm' ) }>
					<TextControl label={ __( 'Gold button link', 'suburbancm' ) } value={ primaryButtonUrl } onChange={ ( value ) => setAttributes( { primaryButtonUrl: value } ) } />
					<TextControl label={ __( 'Outline button link', 'suburbancm' ) } value={ secondaryButtonUrl } onChange={ ( value ) => setAttributes( { secondaryButtonUrl: value } ) } />
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section--sm scm-cta__inner">
					<div className="scm-cta__text">
						<h2 className="scm-d scm-h-l">
							<RichText tagName="span" className="scm-line" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Headline…', 'suburbancm' ) } allowedFormats={ [] } />
							<RichText tagName="span" className="scm-line scm-gold" value={ subtitle } onChange={ ( value ) => setAttributes( { subtitle: value } ) } placeholder={ __( 'Optional gold second line', 'suburbancm' ) } allowedFormats={ [] } />
						</h2>
					</div>
					<div className="scm-btns">
						<RichText tagName="span" className="scm-btn scm-btn--line" value={ secondaryButtonText } onChange={ ( value ) => setAttributes( { secondaryButtonText: value } ) } placeholder={ __( 'Outline button', 'suburbancm' ) } allowedFormats={ [] } />
						<RichText tagName="span" className="scm-btn" value={ primaryButtonText } onChange={ ( value ) => setAttributes( { primaryButtonText: value } ) } placeholder={ __( 'Gold button', 'suburbancm' ) } allowedFormats={ [] } />
					</div>
				</div>
			</section>
		</>
	);
};

export default Edit;
