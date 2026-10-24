import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import { ImageControl } from '../_shared/media';

/**
 * suburbancm/mission editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const { title, quote, description, buttonText, buttonUrl, imageUrl, imageAlt, rowReverse } = attributes;
	const blockProps = useBlockProps( { className: `scm-mission scm-bg-gold${ imageUrl ? ' has-image' : '' }${ rowReverse ? ' is-reversed' : '' }` } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button and photo', 'suburbancm' ) }>
					<TextControl label={ __( 'Button link', 'suburbancm' ) } value={ buttonUrl } onChange={ ( value ) => setAttributes( { buttonUrl: value } ) } />
					<ImageControl
						label={ __( 'Photo (optional)', 'suburbancm' ) }
						url={ imageUrl }
						alt={ imageAlt }
						onChange={ ( { url, alt } ) => setAttributes( { imageUrl: url, imageAlt: alt } ) }
					/>
					{ imageUrl && (
						<ToggleControl label={ __( 'Photo on the left', 'suburbancm' ) } checked={ !! rowReverse } onChange={ ( value ) => setAttributes( { rowReverse: value } ) } />
					) }
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section scm-mission__inner">
					<div className="scm-mission__text">
						<RichText tagName="p" className="scm-eyebrow" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Label, e.g. Our mission', 'suburbancm' ) } />
						<RichText tagName="blockquote" className="scm-d scm-mission__quote" value={ quote } onChange={ ( value ) => setAttributes( { quote: value } ) } placeholder={ __( 'The mission, as a big statement…', 'suburbancm' ) } />
						<RichText tagName="p" className="scm-lede" value={ description } onChange={ ( value ) => setAttributes( { description: value } ) } placeholder={ __( 'Supporting paragraph…', 'suburbancm' ) } />
						<RichText tagName="span" className="scm-btn scm-btn--ink" value={ buttonText } onChange={ ( value ) => setAttributes( { buttonText: value } ) } placeholder={ __( 'Optional button', 'suburbancm' ) } allowedFormats={ [] } />
					</div>
					{ imageUrl && (
						<div className="scm-mission__image">
							<img src={ imageUrl } alt={ imageAlt } />
						</div>
					) }
				</div>
			</section>
		</>
	);
};

export default Edit;
