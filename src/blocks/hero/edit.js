import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	URLInput,
} from '@wordpress/block-editor';
import { PanelBody, Button, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const {
		headingLine1,
		headingHighlight,
		paragraph,
		button1Text,
		button1Link,
		button2Text,
		button2Link,
		backgroundImageId,
		backgroundImageUrl,
		imageAlt,
		imageCaption,
	} = attributes;

	const blockProps = useBlockProps( { className: 'scm-hero' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Photo below the headline', 'suburbancm' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) =>
								setAttributes( {
									backgroundImageId: media.id,
									backgroundImageUrl: media.url,
									imageAlt: media.alt || imageAlt,
								} )
							}
							allowedTypes={ [ 'image' ] }
							value={ backgroundImageId }
							render={ ( { open } ) => (
								<Button variant={ backgroundImageUrl ? 'secondary' : 'primary' } onClick={ open }>
									{ backgroundImageUrl ? __( 'Replace photo', 'suburbancm' ) : __( 'Choose photo', 'suburbancm' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					{ backgroundImageUrl && (
						<>
							<Button
								variant="link"
								isDestructive
								onClick={ () => setAttributes( { backgroundImageId: undefined, backgroundImageUrl: '' } ) }
							>
								{ __( 'Remove photo', 'suburbancm' ) }
							</Button>
							<TextControl
								label={ __( 'Alt text', 'suburbancm' ) }
								value={ imageAlt }
								onChange={ ( val ) => setAttributes( { imageAlt: val } ) }
							/>
							<TextControl
								label={ __( 'Caption', 'suburbancm' ) }
								help={ __( 'Shown on the photo, e.g. the project name.', 'suburbancm' ) }
								value={ imageCaption }
								onChange={ ( val ) => setAttributes( { imageCaption: val } ) }
							/>
						</>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Button links', 'suburbancm' ) }>
					<URLInput
						label={ __( 'Gold button link', 'suburbancm' ) }
						value={ button1Link }
						onChange={ ( url ) => setAttributes( { button1Link: url } ) }
					/>
					<URLInput
						label={ __( 'Outline button link', 'suburbancm' ) }
						value={ button2Link }
						onChange={ ( url ) => setAttributes( { button2Link: url } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<section className="scm-wrap scm-hero__text">
					<h1 className="scm-d scm-h-xl">
						<RichText
							tagName="span"
							className="scm-line"
							value={ headingLine1 }
							onChange={ ( val ) => setAttributes( { headingLine1: val } ) }
							placeholder={ __( 'First line…', 'suburbancm' ) }
							allowedFormats={ [] }
						/>
						<RichText
							tagName="span"
							className="scm-line scm-gold"
							value={ headingHighlight }
							onChange={ ( val ) => setAttributes( { headingHighlight: val } ) }
							placeholder={ __( 'Gold second line…', 'suburbancm' ) }
							allowedFormats={ [] }
						/>
					</h1>
					<div className="scm-hero__row">
						<RichText
							tagName="p"
							className="scm-lede"
							value={ paragraph }
							onChange={ ( val ) => setAttributes( { paragraph: val } ) }
							placeholder={ __( 'Intro text…', 'suburbancm' ) }
						/>
						<div className="scm-btns">
							<RichText
								tagName="span"
								className="scm-btn"
								value={ button1Text }
								onChange={ ( val ) => setAttributes( { button1Text: val } ) }
								placeholder={ __( 'Gold button', 'suburbancm' ) }
								allowedFormats={ [] }
							/>
							<RichText
								tagName="span"
								className="scm-btn scm-btn--line"
								value={ button2Text }
								onChange={ ( val ) => setAttributes( { button2Text: val } ) }
								placeholder={ __( 'Outline button', 'suburbancm' ) }
								allowedFormats={ [] }
							/>
						</div>
					</div>
				</section>
				{ backgroundImageUrl && (
					<figure className="scm-photo-band">
						<img src={ backgroundImageUrl } alt={ imageAlt } />
						{ imageCaption && <figcaption>{ imageCaption }</figcaption> }
					</figure>
				) }
			</div>
		</>
	);
}
