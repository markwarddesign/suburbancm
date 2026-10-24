import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { ImageControl } from '../_shared/media';

/**
 * suburbancm/page-title editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const { title, titleHighlight, subtitle, tagline, background, buttonText, buttonUrl, imageId, imageUrl, imageAlt } = attributes;
	const blockProps = useBlockProps( { className: `scm-page-title scm-bg-${ background }` } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Style', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Background', 'suburbancm' ) }
						value={ background }
						options={ [
							{ label: __( 'Charcoal', 'suburbancm' ), value: 'ink' },
							{ label: __( 'Gold', 'suburbancm' ), value: 'gold' },
						] }
						onChange={ ( value ) => setAttributes( { background: value } ) }
					/>
					<TextControl
						label={ __( 'Button link', 'suburbancm' ) }
						help={ __( 'Optional. Button text is edited on the page.', 'suburbancm' ) }
						value={ buttonUrl }
						onChange={ ( value ) => setAttributes( { buttonUrl: value } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Photo below', 'suburbancm' ) } initialOpen={ false }>
					<ImageControl
						label={ __( 'Full-width photo', 'suburbancm' ) }
						id={ imageId }
						url={ imageUrl }
						alt={ imageAlt }
						onChange={ ( { id, url, alt } ) => setAttributes( { imageId: id, imageUrl: url, imageAlt: alt } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<section className="scm-wrap scm-page-title__text">
					<h1 className="scm-d scm-h-xl">
						<RichText tagName="span" className="scm-line" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Headline…', 'suburbancm' ) } />
						<RichText tagName="span" className="scm-line scm-page-title__highlight" value={ titleHighlight } onChange={ ( value ) => setAttributes( { titleHighlight: value } ) } placeholder={ __( 'Optional gold second line…', 'suburbancm' ) } allowedFormats={ [] } />
					</h1>
					<RichText tagName="p" className="scm-d scm-page-title__tagline" value={ tagline } onChange={ ( value ) => setAttributes( { tagline: value } ) } placeholder={ __( 'Optional tagline…', 'suburbancm' ) } allowedFormats={ [] } />
					<div className="scm-page-title__row">
						<RichText tagName="p" className="scm-lede" value={ subtitle } onChange={ ( value ) => setAttributes( { subtitle: value } ) } placeholder={ __( 'Intro text…', 'suburbancm' ) } />
						<RichText
							tagName="span"
							className={ `scm-btn${ background === 'gold' ? ' scm-btn--ink' : '' }` }
							value={ buttonText }
							onChange={ ( value ) => setAttributes( { buttonText: value } ) }
							placeholder={ __( 'Optional button', 'suburbancm' ) }
							allowedFormats={ [] }
						/>
					</div>
				</section>
				{ imageUrl && (
					<figure className="scm-photo-band">
						<img src={ imageUrl } alt={ imageAlt } />
					</figure>
				) }
			</div>
		</>
	);
};

export default Edit;
