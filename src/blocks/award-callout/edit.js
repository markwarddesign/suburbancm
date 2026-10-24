import { __ } from '@wordpress/i18n';
import {
	RichText,
	useBlockProps,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from '@wordpress/block-editor';
import { Button, PanelBody, TextControl } from '@wordpress/components';

/**
 * suburbancm/award-callout editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const {
		image,
		imageAlt,
		rank,
		eyebrow,
		title,
		description,
		buttonText,
		buttonUrl,
		secondaryText,
		secondaryUrl,
	} = attributes;

	const blockProps = useBlockProps( {
		className: 'scm-award scm-bg-gold' + ( image ? ' has-image' : '' ),
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Links', 'suburbancm' ) } initialOpen={ true }>
					<TextControl
						label={ __( 'Button link', 'suburbancm' ) }
						value={ buttonUrl }
						onChange={ ( val ) => setAttributes( { buttonUrl: val } ) }
						help={ __( 'e.g. /about/ or the BoiseDev Peak 43 list', 'suburbancm' ) }
					/>
					<TextControl
						label={ __( 'Second button link', 'suburbancm' ) }
						value={ secondaryUrl }
						onChange={ ( val ) => setAttributes( { secondaryUrl: val } ) }
						help={ __( 'Optional, e.g. the YouTube video. Leave empty to hide.', 'suburbancm' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Award graphic', 'suburbancm' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Big rank', 'suburbancm' ) }
						help={ __( 'Shown huge beside the headline. Leave empty to hide.', 'suburbancm' ) }
						value={ rank }
						onChange={ ( val ) => setAttributes( { rank: val } ) }
					/>
					<TextControl
						label={ __( 'Graphic alt text', 'suburbancm' ) }
						value={ imageAlt }
						onChange={ ( val ) => setAttributes( { imageAlt: val } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-award__text">
					<RichText
						tagName="p"
						className="scm-eyebrow"
						placeholder={ __( 'Eyebrow (e.g. BoiseDev Peak 43 · 2026)', 'suburbancm' ) }
						value={ eyebrow }
						onChange={ ( val ) => setAttributes( { eyebrow: val } ) }
					/>
					<div className="scm-award__head">
						{ rank && <span className="scm-d scm-award__rank">{ rank }</span> }
						<RichText
							tagName="h2"
							className="scm-d scm-h-m"
							placeholder={ __( 'Headline…', 'suburbancm' ) }
							value={ title }
							onChange={ ( val ) => setAttributes( { title: val } ) }
						/>
					</div>
					<RichText
						tagName="p"
						className="scm-lede"
						placeholder={ __( 'Description…', 'suburbancm' ) }
						value={ description }
						onChange={ ( val ) => setAttributes( { description: val } ) }
					/>
					<div className="scm-btns">
						<RichText
							tagName="span"
							className="scm-btn scm-btn--ink"
							placeholder={ __( 'Button text…', 'suburbancm' ) }
							value={ buttonText }
							onChange={ ( val ) => setAttributes( { buttonText: val } ) }
							allowedFormats={ [] }
						/>
						<RichText
							tagName="span"
							className="scm-btn scm-btn--line"
							placeholder={ __( 'Second button (optional)', 'suburbancm' ) }
							value={ secondaryText }
							onChange={ ( val ) => setAttributes( { secondaryText: val } ) }
							allowedFormats={ [] }
						/>
					</div>
				</div>

				<div className="scm-award__image">
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) => setAttributes( { image: media.url, imageAlt: media.alt || imageAlt } ) }
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) =>
								image ? (
									<>
										<img src={ image } alt={ imageAlt } />
										<div className="scm-edit-overlay">
											<Button variant="secondary" onClick={ open }>{ __( 'Replace', 'suburbancm' ) }</Button>
											<Button variant="secondary" isDestructive onClick={ () => setAttributes( { image: '' } ) }>
												{ __( 'Remove', 'suburbancm' ) }
											</Button>
										</div>
									</>
								) : (
									<div className="scm-edit-empty">
										<Button variant="primary" onClick={ open }>{ __( 'Add award graphic', 'suburbancm' ) }</Button>
									</div>
								)
							}
						/>
					</MediaUploadCheck>
				</div>
			</section>
		</>
	);
};

export default Edit;
