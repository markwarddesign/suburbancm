import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	RichText,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

// Theme asset base, printed for the editor in functions.php.
const asset = ( file ) => `${ window.suburbancmTheme?.uri || '' }/assets/images/projectaire/${ file }`;

const ImagePicker = ( { label, value, onChange } ) => (
	<MediaUploadCheck>
		<MediaUpload
			onSelect={ ( media ) => onChange( media.url ) }
			allowedTypes={ [ 'image' ] }
			render={ ( { open } ) => (
				<div style={ { marginBottom: 12 } }>
					<p style={ { margin: '0 0 6px' } }>{ label }</p>
					<Button variant="secondary" onClick={ open }>
						{ value ? __( 'Replace', 'suburbancm' ) : __( 'Choose image', 'suburbancm' ) }
					</Button>
					{ value && (
						<Button variant="link" isDestructive onClick={ () => onChange( '' ) }>
							{ __( 'Use built-in screenshot', 'suburbancm' ) }
						</Button>
					) }
				</div>
			) }
		/>
	</MediaUploadCheck>
);

const Edit = ( { attributes, setAttributes } ) => {
	const {
		title,
		titleHighlight,
		text,
		features = [],
		image,
		imageAlt,
		phoneImage,
		caption,
		buttonText,
		buttonUrl,
		secondaryText,
		secondaryUrl,
	} = attributes;

	// One hook call for both layouts; the detailed preview is drawn by ServerSideRender.
	const blockProps = useBlockProps( { className: attributes.layout === 'detailed' ? undefined : 'scm-pa scm-bg-ink-2' } );
	const setFeature = ( index, value ) =>
		setAttributes( { features: features.map( ( f, i ) => ( i === index ? value : f ) ) } );

	const layoutPanel = (
		<PanelBody title={ __( 'Layout', 'suburbancm' ) }>
			<SelectControl
				label={ __( 'Layout', 'suburbancm' ) }
				value={ attributes.layout }
				options={ [
					{ label: __( 'Band — logo, benefits, screenshots (Home)', 'suburbancm' ), value: 'band' },
					{ label: __( 'Detailed — during construction and at handoff', 'suburbancm' ), value: 'detailed' },
				] }
				onChange={ ( value ) => setAttributes( { layout: value } ) }
			/>
		</PanelBody>
	);

	if ( attributes.layout === 'detailed' ) {
		const text = ( key, label, multiline ) => {
			const Control = multiline ? TextareaControl : TextControl;
			return <Control label={ label } value={ attributes[ key ] } onChange={ ( value ) => setAttributes( { [ key ]: value } ) } />;
		};
		return (
			<div { ...blockProps }>
				<InspectorControls>
					{ layoutPanel }
					<PanelBody title={ __( 'Heading', 'suburbancm' ) }>
						{ text( 'eyebrow', __( 'Small label', 'suburbancm' ) ) }
						{ text( 'title', __( 'Heading', 'suburbancm' ) ) }
						{ text( 'text', __( 'Intro', 'suburbancm' ), true ) }
					</PanelBody>
					<PanelBody title={ __( 'During construction', 'suburbancm' ) } initialOpen={ false }>
						{ text( 'duringTitle', __( 'Title', 'suburbancm' ) ) }
						{ text( 'duringText', __( 'Text', 'suburbancm' ), true ) }
						<TextareaControl
							label={ __( 'List — one item per line', 'suburbancm' ) }
							value={ ( attributes.duringFeatures || [] ).join( '\n' ) }
							onChange={ ( value ) => setAttributes( { duringFeatures: value.split( '\n' ) } ) }
						/>
						<ImagePicker label={ __( 'Screenshot', 'suburbancm' ) } value={ image } onChange={ ( url ) => setAttributes( { image: url } ) } />
						{ text( 'imageAlt', __( 'Screenshot alt text', 'suburbancm' ) ) }
						{ text( 'duringCaption', __( 'Caption', 'suburbancm' ) ) }
					</PanelBody>
					<PanelBody title={ __( 'At handoff', 'suburbancm' ) } initialOpen={ false }>
						{ text( 'handoffTitle', __( 'Title', 'suburbancm' ) ) }
						{ text( 'handoffLead', __( 'Bold lead line', 'suburbancm' ), true ) }
						{ text( 'handoffText', __( 'Text', 'suburbancm' ), true ) }
						<ImagePicker label={ __( 'Screenshot', 'suburbancm' ) } value={ attributes.handoffImage } onChange={ ( url ) => setAttributes( { handoffImage: url } ) } />
						{ text( 'handoffImageAlt', __( 'Screenshot alt text', 'suburbancm' ) ) }
						{ text( 'handoffCaption', __( 'Caption', 'suburbancm' ) ) }
					</PanelBody>
					<PanelBody title={ __( 'Buttons', 'suburbancm' ) } initialOpen={ false }>
						{ text( 'secondaryText', __( 'Client login text', 'suburbancm' ) ) }
						{ text( 'secondaryUrl', __( 'Client login link', 'suburbancm' ) ) }
						{ text( 'aboutText', __( 'Second button text', 'suburbancm' ) ) }
						{ text( 'aboutUrl', __( 'Second button link', 'suburbancm' ) ) }
					</PanelBody>
				</InspectorControls>
				<ServerSideRender block="suburbancm/projectaire" attributes={ attributes } />
			</div>
		);
	}

	return (
		<>
			<InspectorControls>
				{ layoutPanel }
				<PanelBody title={ __( 'Screenshots', 'suburbancm' ) }>
					<ImagePicker label={ __( 'Desktop screenshot', 'suburbancm' ) } value={ image } onChange={ ( url ) => setAttributes( { image: url } ) } />
					<TextControl label={ __( 'Desktop screenshot alt text', 'suburbancm' ) } value={ imageAlt } onChange={ ( value ) => setAttributes( { imageAlt: value } ) } />
					<ImagePicker label={ __( 'Phone screenshot', 'suburbancm' ) } value={ phoneImage } onChange={ ( url ) => setAttributes( { phoneImage: url } ) } />
					<TextControl label={ __( 'Caption', 'suburbancm' ) } value={ caption } onChange={ ( value ) => setAttributes( { caption: value } ) } />
				</PanelBody>
				<PanelBody title={ __( 'Button links', 'suburbancm' ) }>
					<TextControl label={ __( 'Gold button link', 'suburbancm' ) } value={ buttonUrl } onChange={ ( value ) => setAttributes( { buttonUrl: value } ) } />
					<TextControl label={ __( 'Outline button link', 'suburbancm' ) } value={ secondaryUrl } onChange={ ( value ) => setAttributes( { secondaryUrl: value } ) } />
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section scm-pa__inner">
					<div className="scm-pa__text">
						<img className="scm-pa__logo" src={ asset( 'projectaire-logo.png' ) } alt="ProjectAire" />
						<h2 className="scm-d scm-h-l">
							<RichText tagName="span" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Headline…', 'suburbancm' ) } allowedFormats={ [] } />
							{ ' ' }
							<RichText tagName="span" className="scm-gold" value={ titleHighlight } onChange={ ( value ) => setAttributes( { titleHighlight: value } ) } placeholder={ __( 'gold words', 'suburbancm' ) } allowedFormats={ [] } />
						</h2>
						<RichText tagName="p" className="scm-lede" value={ text } onChange={ ( value ) => setAttributes( { text: value } ) } placeholder={ __( 'Intro…', 'suburbancm' ) } />
						<ul className="scm-rules">
							{ features.map( ( feature, index ) => (
								<li key={ index } style={ { display: 'flex', gap: 6, alignItems: 'center' } }>
									<RichText tagName="span" value={ feature } onChange={ ( value ) => setFeature( index, value ) } placeholder={ __( 'What owners see…', 'suburbancm' ) } />
									<Button size="small" icon="no-alt" label={ __( 'Remove', 'suburbancm' ) } onClick={ () => setAttributes( { features: features.filter( ( _, i ) => i !== index ) } ) } />
								</li>
							) ) }
						</ul>
						<Button variant="secondary" size="small" onClick={ () => setAttributes( { features: [ ...features, '' ] } ) }>
							{ __( 'Add line', 'suburbancm' ) }
						</Button>
						<div className="scm-btns">
							<RichText tagName="span" className="scm-btn" value={ buttonText } onChange={ ( value ) => setAttributes( { buttonText: value } ) } placeholder={ __( 'Gold button', 'suburbancm' ) } allowedFormats={ [] } />
							<RichText tagName="span" className="scm-btn scm-btn--line" value={ secondaryText } onChange={ ( value ) => setAttributes( { secondaryText: value } ) } placeholder={ __( 'Outline button', 'suburbancm' ) } allowedFormats={ [] } />
						</div>
					</div>
					<figure className="scm-pa__shots">
						<img className="scm-pa__desktop" src={ image || asset( 'overview.jpg' ) } alt={ imageAlt } />
						<img className="scm-pa__phone" src={ phoneImage || asset( 'overview-phone.jpg' ) } alt="" />
						{ caption && <figcaption>{ caption }</figcaption> }
					</figure>
				</div>
			</section>
		</>
	);
};

export default Edit;
