import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, ToggleControl, Button } from '@wordpress/components';
import { ImageControl, updateItem } from '../_shared/media';

const FORM_TEMPLATE = [ [ 'core/paragraph', { placeholder: __( 'Add your WPForms block here…', 'suburbancm' ) } ] ];

export default function Edit( { attributes, setAttributes } ) {
	const {
		formTitle, formNote, boxed, asidePosition, asideTitle, asideText, asideList = [], asideImage, asideImageAlt,
		officeLabel, officeTitle, officeText, links = [],
	} = attributes;
	const blockProps = useBlockProps( { className: `scm-form-panel scm-bg-bone${ asidePosition === 'left' ? ' is-aside-left' : '' }` } );
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Layout', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Side column position', 'suburbancm' ) }
						value={ asidePosition }
						options={ [
							{ label: __( 'Right of the form', 'suburbancm' ), value: 'right' },
							{ label: __( 'Left of the form', 'suburbancm' ), value: 'left' },
						] }
						onChange={ set( 'asidePosition' ) }
					/>
					<ToggleControl label={ __( 'Put the form in a white box', 'suburbancm' ) } checked={ !! boxed } onChange={ set( 'boxed' ) } />
					<TextareaControl label={ __( 'Note under the form', 'suburbancm' ) } value={ formNote } onChange={ set( 'formNote' ) } />
				</PanelBody>
				<PanelBody title={ __( 'Office box', 'suburbancm' ) } initialOpen={ false }>
					<TextControl label={ __( 'Small label', 'suburbancm' ) } value={ officeLabel } onChange={ set( 'officeLabel' ) } />
					<TextControl label={ __( 'Big line (leave empty to hide the box)', 'suburbancm' ) } value={ officeTitle } onChange={ set( 'officeTitle' ) } />
					<TextareaControl label={ __( 'Details', 'suburbancm' ) } value={ officeText } onChange={ set( 'officeText' ) } />
				</PanelBody>
				<PanelBody title={ __( 'Heading, list and photo', 'suburbancm' ) } initialOpen={ false }>
					<TextControl label={ __( 'Heading', 'suburbancm' ) } value={ asideTitle } onChange={ set( 'asideTitle' ) } />
					<TextareaControl label={ __( 'Text', 'suburbancm' ) } value={ asideText } onChange={ set( 'asideText' ) } />
					<TextareaControl
						label={ __( 'List — one item per line', 'suburbancm' ) }
						value={ asideList.join( '\n' ) }
						onChange={ ( value ) => setAttributes( { asideList: value.split( '\n' ) } ) }
					/>
					<ImageControl label={ __( 'Photo', 'suburbancm' ) } url={ asideImage } alt={ asideImageAlt } onChange={ ( { url, alt } ) => setAttributes( { asideImage: url, asideImageAlt: alt } ) } />
				</PanelBody>
				<PanelBody title={ __( 'Link cards', 'suburbancm' ) } initialOpen={ false }>
					{ links.map( ( link, i ) => (
						<div key={ i } style={ { borderTop: '1px solid #ddd', paddingTop: 8, marginTop: 8 } }>
							<TextControl label={ __( 'Title', 'suburbancm' ) } value={ link.title } onChange={ ( value ) => setAttributes( { links: updateItem( links, i, { title: value } ) } ) } />
							<TextControl label={ __( 'Text', 'suburbancm' ) } value={ link.text } onChange={ ( value ) => setAttributes( { links: updateItem( links, i, { text: value } ) } ) } />
							<TextControl label={ __( 'Link', 'suburbancm' ) } value={ link.url } onChange={ ( value ) => setAttributes( { links: updateItem( links, i, { url: value } ) } ) } />
							<Button variant="link" isDestructive onClick={ () => setAttributes( { links: links.filter( ( _, j ) => j !== i ) } ) }>
								{ __( 'Remove card', 'suburbancm' ) }
							</Button>
						</div>
					) ) }
					<Button variant="secondary" onClick={ () => setAttributes( { links: [ ...links, { title: '', text: '', url: '' } ] } ) }>
						{ __( 'Add link card', 'suburbancm' ) }
					</Button>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section scm-form-panel__inner">
					<div className={ `scm-form-panel__form${ boxed ? ' is-boxed' : '' }` }>
						<RichText tagName="h2" className="scm-d scm-h-m" value={ formTitle } onChange={ set( 'formTitle' ) } placeholder={ __( 'Form heading…', 'suburbancm' ) } />
						<div className="scm-form">
							<InnerBlocks template={ FORM_TEMPLATE } templateLock={ false } />
						</div>
						{ formNote && <p className="scm-form-panel__note">{ formNote }</p> }
					</div>
					<aside className="scm-form-panel__aside">
						{ officeTitle && (
							<div className="scm-office">
								{ officeLabel && <p className="scm-eyebrow scm-gold">{ officeLabel }</p> }
								<p className="scm-d scm-office__title">{ officeTitle }</p>
								{ officeText && <p className="scm-office__text">{ officeText }</p> }
							</div>
						) }
						{ asideTitle && <h2 className="scm-d scm-h-m">{ asideTitle }</h2> }
						{ asideText && <p className="scm-form-panel__text">{ asideText }</p> }
						{ asideList.filter( Boolean ).length > 0 && (
							<ul className="scm-heavy-list">
								{ asideList.filter( Boolean ).map( ( item, i ) => <li key={ i }>{ item }</li> ) }
							</ul>
						) }
						{ asideImage && (
							<div className="scm-form-panel__image">
								<img src={ asideImage } alt={ asideImageAlt } />
							</div>
						) }
						{ links.map( ( link, i ) => (
							<div key={ i } className="scm-link-card">
								<span className="scm-d scm-link-card__title">{ link.title }</span>
								{ link.text && <span className="scm-link-card__text">{ link.text } →</span> }
							</div>
						) ) }
						{ ! officeTitle && ! asideTitle && ! links.length && (
							<p className="scm-form-panel__text">{ __( 'Fill in the side column in the block settings.', 'suburbancm' ) }</p>
						) }
					</aside>
				</div>
			</section>
		</>
	);
}
